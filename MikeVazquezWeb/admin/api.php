<?php
/**
 * API del Panel de Administración - Mike Vazquez Web
 */

require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');

// Obtener la acción solicitada
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Manejo de acciones públicas primero
if ($action === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = isset($data['email']) ? $data['email'] : '';
    $password = isset($data['password']) ? $data['password'] : '';
    
    if (verify_admin_login($email, $password)) {
        echo json_encode(['success' => true, 'message' => 'Sesión iniciada con éxito']);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Correo no autorizado']);
    }
    exit;
}

if ($action === 'status') {
    echo json_encode(['logged_in' => is_admin_logged_in()]);
    exit;
}

if ($action === 'logout') {
    logout_admin();
    echo json_encode(['success' => true, 'message' => 'Sesión cerrada']);
    exit;
}

// Para el resto de las acciones, verificar que el usuario esté autenticado
if (!is_admin_logged_in()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Ruta al archivo de datos y de plantillas
$db_file = __DIR__ . '/../data/articles.json';
$template_file = __DIR__ . '/templates/article_template.html';

// Asegurar que el archivo de datos existe
if (!file_exists($db_file)) {
    if (!is_dir(dirname($db_file))) {
        mkdir(dirname($db_file), 0755, true);
    }
    file_put_contents($db_file, json_encode([]));
}

// Procesar acciones de administración
switch ($action) {
    case 'list':
        $articles = json_decode(file_get_contents($db_file), true);
        // Devolver ordenados por fecha descendente
        usort($articles, function($a, $b) {
            return strcmp($b['date'], $a['date']);
        });
        echo json_encode($articles);
        break;

    case 'save':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $id = isset($data['id']) ? $data['id'] : '';
        $title = isset($data['title']) ? trim($data['title']) : '';
        $slug = isset($data['slug']) ? slugify($data['slug']) : '';
        $summary = isset($data['summary']) ? trim($data['summary']) : '';
        $meta_title = isset($data['meta_title']) ? trim($data['meta_title']) : '';
        $meta_description = isset($data['meta_description']) ? trim($data['meta_description']) : '';
        $content = isset($data['content']) ? trim($data['content']) : '';
        $image = isset($data['image']) ? trim($data['image']) : '';
        $type = isset($data['type']) ? $data['type'] : 'articulo'; // 'articulo' o 'pagina'
        $status = isset($data['status']) ? $data['status'] : 'publicado'; // 'publicado' o 'borrador'
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
        $show_on_home = isset($data['show_on_home']) ? (bool)$data['show_on_home'] : false;

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'El título es obligatorio']);
            exit;
        }

        if (empty($slug)) {
            $slug = slugify($title);
        }

        // Cargar artículos existentes
        $articles = json_decode(file_get_contents($db_file), true);

        // Verificar unicidad de slug
        foreach ($articles as $art) {
            if ($art['slug'] === $slug && $art['id'] !== $id) {
                // Si el slug existe, añadirle un sufijo aleatorio o numérico
                $slug = $slug . '-' . rand(100, 999);
                break;
            }
        }

        // Crear o actualizar
        $is_new = empty($id);
        if ($is_new) {
            $id = uniqid('post_', true);
        }

        $updated_article = [
            'id' => $id,
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'content' => $content,
            'image' => $image,
            'type' => $type,
            'status' => $status,
            'date' => $date,
            'show_on_home' => $show_on_home,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($is_new) {
            $articles[] = $updated_article;
        } else {
            foreach ($articles as $index => $art) {
                if ($art['id'] === $id) {
                    // Si el slug cambió, registrar el anterior para borrar su carpeta vieja
                    $old_slug = $art['slug'];
                    $articles[$index] = $updated_article;
                    break;
                }
            }
        }

        // Guardar en el archivo JSON
        if (file_put_contents($db_file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al escribir en la base de datos']);
            exit;
        }

        // Si se editó y el slug cambió, borrar la carpeta del slug anterior
        if (isset($old_slug) && $old_slug !== $slug) {
            delete_static_folder($old_slug);
        }

        // Gestionar la compilación estática
        if ($status === 'publicado') {
            $compiled = compile_static_page($updated_article, $template_file);
            if (!$compiled) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Artículo guardado en JSON, pero falló la generación de la página estática. Revisa los permisos de escritura.',
                    'article' => $updated_article
                ]);
                exit;
            }
        } else {
            // Si es borrador, nos aseguramos de que no haya página estática pública activa
            delete_static_folder($slug);
        }

        echo json_encode([
            'success' => true, 
            'message' => $is_new ? 'Entrada creada con éxito' : 'Entrada actualizada con éxito',
            'article' => $updated_article
        ]);
        break;

    case 'delete':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['id']) ? $data['id'] : '';

        if (empty($id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }

        $articles = json_decode(file_get_contents($db_file), true);
        $found = false;
        $slug_to_delete = '';

        foreach ($articles as $index => $art) {
            if ($art['id'] === $id) {
                $slug_to_delete = $art['slug'];
                array_splice($articles, $index, 1);
                $found = true;
                break;
            }
        }

        if (!$found) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Artículo no encontrado']);
            exit;
        }

        // Guardar JSON actualizado
        file_put_contents($db_file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Borrar carpeta física
        if (!empty($slug_to_delete)) {
            delete_static_folder($slug_to_delete);
        }

        echo json_encode(['success' => true, 'message' => 'Entrada eliminada correctamente']);
        break;

    case 'upload_image':
        if (!isset($_FILES['image'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No se recibió ninguna imagen']);
            exit;
        }

        $file = $_FILES['image'];
        $upload_dir = __DIR__ . '/../images/uploads/';

        // Asegurar que la carpeta de subidas existe
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Validar formato de imagen
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $file['tmp_name']);
        finfo_close($file_info);

        if (!in_array($mime_type, $allowed_types)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido. Solo imágenes (JPG, PNG, GIF, WEBP, SVG).']);
            exit;
        }

        // Generar nombre de archivo único
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (empty($ext)) {
            // Mapear mime type a extensión si viene vacía
            $map = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                'image/svg+xml' => 'svg'
            ];
            $ext = isset($map[$mime_type]) ? $map[$mime_type] : 'jpg';
        }
        $filename = 'img_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
        $dest_path = $upload_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $dest_path)) {
            // Devolver la ruta relativa a la raíz
            echo json_encode([
                'success' => true, 
                'url' => 'images/uploads/' . $filename
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo subido al servidor']);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

/**
 * Convierte un texto en un slug limpio para URL
 */
function slugify($text) {
    // Verificar si existe la extensión intl para transliterar de forma nativa
    if (function_exists('transliterator_transliterate')) {
        $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
    } else {
        $text = mb_strtolower($text, 'UTF-8');
        // Tabla de traducción manual para caracteres hispanos comunes con acentos
        $chars = [
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'ü'=>'u', 'ñ'=>'n',
            'ä'=>'a', 'ë'=>'e', 'ï'=>'i', 'ö'=>'o', 'ü'=>'u',
            'â'=>'a', 'ê'=>'e', 'î'=>'i', 'ô'=>'o', 'û'=>'u'
        ];
        $text = strtr($text, $chars);
    }
    // Limpiar caracteres no alfanuméricos
    $text = preg_replace('/[^a-z0-9 -]/', '', $text);
    // Cambiar espacios por guiones
    $text = preg_replace('/\s+/', '-', $text);
    // Eliminar guiones duplicados
    $text = preg_replace('/-+/', '-', $text);
    // Recortar extremos
    return trim($text, '-');
}

/**
 * Borra físicamente la carpeta del slug de manera recursiva
 */
function delete_static_folder($slug) {
    if (empty($slug)) return;
    $dir = __DIR__ . '/../' . $slug;
    
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            unlink("$dir/$file");
        }
        rmdir($dir);
    }
}

/**
 * Compila una entrada en un archivo HTML estático e independiente
 */
function compile_static_page($article, $template_file) {
    if (!file_exists($template_file)) {
        return false;
    }

    $template = file_get_contents($template_file);

    // Formatear fecha para mostrar de manera amigable
    $timestamp = strtotime($article['date']);
    $months = [
        'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo', 'April' => 'Abril',
        'May' => 'Mayo', 'June' => 'Junio', 'July' => 'Julio', 'August' => 'Agosto',
        'September' => 'Septiembre', 'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
    ];
    $formatted_date = date('j', $timestamp) . ' de ' . $months[date('F', $timestamp)] . ' de ' . date('Y', $timestamp);

    // Remplazar los marcadores de la plantilla
    // RELATIVE_PATH = "../" porque la página se aloja en una subcarpeta de un nivel
    $relative_path = '../';
    
    // Tratamiento especial de la imagen destacada
    $image_url = $article['image'];
    if (!empty($image_url)) {
        // Si no es un enlace absoluto, prefijarlo con el relative path
        if (!preg_match('/^https?:\/\//', $image_url)) {
            $image_url = $relative_path . $image_url;
        }
    } else {
        // Imagen por defecto si no se sube una
        $image_url = $relative_path . 'images/63501656a5fc5fbefd7a08f5_Mike-Vazquez-on-negro.png';
    }

    $seo_title = !empty($article['meta_title']) ? $article['meta_title'] : ($article['title'] . ' | Mike Vazquez');
    $seo_desc = !empty($article['meta_description']) ? $article['meta_description'] : $article['summary'];

    $replacements = [
        '{{TITLE}}' => htmlspecialchars($article['title']),
        '{{SUMMARY}}' => htmlspecialchars($article['summary']),
        '{{META_TITLE}}' => htmlspecialchars($seo_title),
        '{{META_DESCRIPTION}}' => htmlspecialchars($seo_desc),
        '{{CONTENT}}' => $article['content'], // Se asume que viene sanitizado de la interfaz
        '{{IMAGE}}' => $image_url,
        '{{DATE}}' => $formatted_date,
        '{{SLUG}}' => htmlspecialchars($article['slug']),
        '{{RELATIVE_PATH}}' => $relative_path
    ];

    $html = str_replace(array_keys($replacements), array_values($replacements), $template);

    // Crear directorio de destino
    $dest_dir = __DIR__ . '/../' . $article['slug'];
    if (!is_dir($dest_dir)) {
        if (!mkdir($dest_dir, 0755, true)) {
            return false;
        }
    }

    // Escribir index.html estático
    return file_put_contents($dest_dir . '/index.html', $html) !== false;
}
