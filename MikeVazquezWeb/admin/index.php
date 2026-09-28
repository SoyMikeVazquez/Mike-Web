<?php
/**
 * Interfaz del Panel de Administración - Mike Vazquez Web
 */

// Si se accede como /admin sin barra diagonal al final, redirigir a /admin/ para evitar problemas con rutas relativas
if (preg_match('/^\/admin(\?.*)?$/', $_SERVER['REQUEST_URI'])) {
    $queryString = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: /admin/' . $queryString);
    exit;
}

require_once 'config.php';

// Si no está logueado, mostrar la pantalla de Login
if (!is_admin_logged_in()):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Iniciar Sesión | Mike Vazquez Admin</title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f8fc;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1e2022;
            overflow: hidden;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            padding: 45px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-img {
            max-width: 180px;
            height: auto;
            margin-bottom: 30px;
            filter: brightness(0); /* Invertir logo blanco a negro */
        }
        .title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e2022;
            letter-spacing: -0.5px;
        }
        .subtitle {
            font-size: 0.9rem;
            color: #676a79;
            margin-bottom: 35px;
        }
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }
        .input-label {
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555566;
            display: block;
            margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #88889a;
            transition: color 0.3s;
        }
        .login-input {
            width: 100%;
            background: #f8f9fa;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 14px 20px 14px 50px;
            color: #1e2022;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
            outline: none;
        }
        .login-input:focus {
            border-color: #333333;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .login-input:focus + .input-icon {
            color: #333333;
        }
        .login-btn {
            width: 100%;
            background: #222222;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
            filter: brightness(1.1);
        }
        .login-btn:active {
            transform: translateY(0);
        }
        .error-message {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            color: #333333;
            padding: 10px 15px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: none;
            text-align: left;
        }
        .footer-text {
            margin-top: 40px;
            font-size: 0.75rem;
            color: #555566;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img class="logo-img" src="../images/6368361aca5ec482e0c84cbf_bymike.png" alt="Mike Vazquez Logo"/>
        <h1 class="title">Panel de Control</h1>
        <p class="subtitle">Ingresa tu correo autorizado para acceder</p>
        
        <div id="error-box" class="error-message"></div>
        
        <form id="login-form">
            <div class="input-group">
                <label class="input-label">Correo Electrónico</label>
                <div class="input-wrapper">
                    <input type="email" id="email" class="login-input" placeholder="tu@correo.com" required autofocus/>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>

            <button type="submit" id="submit-btn" class="login-btn">
                <span id="btn-text">Entrar</span>
            </button>
        </form>
        
        <p class="footer-text">&copy; 2026 Mike Vazquez. Todos los derechos reservados.</p>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = '';
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const errorBox = document.getElementById('error-box');

            btnText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
            submitBtn.disabled = true;
            errorBox.style.display = 'none';

            fetch('api.php?action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: email, password: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    errorBox.textContent = data.message || 'Error al iniciar sesión';
                    errorBox.style.display = 'block';
                    btnText.textContent = 'Entrar';
                    submitBtn.disabled = false;
                }
            })
            .catch(err => {
                errorBox.textContent = 'Ocurrió un error de red. Intenta de nuevo.';
                errorBox.style.display = 'block';
                btnText.textContent = 'Entrar';
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>
<?php
// Si está logueado, mostrar el Dashboard de Administración
else:
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Dashboard | Mike Vazquez Admin</title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    
    <!-- Quill.js Editor Rich Text -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #f6f8fc;
            --card-dark: #ffffff;
            --border-color: rgba(0, 0, 0, 0.08);
            --primary-blue: #333333;
            --primary-glow: rgba(0, 0, 0, 0.08);
            --accent-purple: #111111;
            --text-light: #1e2022;
            --text-muted: #676a79;
        }

        /* Switch Toggle Premium */
        .switch input:checked + .slider-toggle {
            background-color: #222222 !important;
        }
        .switch .slider-toggle:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        .switch input:checked + .slider-toggle:before {
            transform: translateX(20px);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout general */
        .wrapper {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        /* Header del Dashboard */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 25px;
            margin-bottom: 40px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .brand-logo {
            max-width: 140px;
            height: auto;
            filter: brightness(0); /* Invertir logo blanco a negro */
        }

        .brand-divider {
            width: 1px;
            height: 30px;
            background-color: var(--border-color);
        }

        .dashboard-title {
            font-size: 1.15rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Botones del Sistema */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: #222222;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            filter: brightness(1.1);
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--text-light);
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #f8f9fa;
            color: #333333;
            border: 1px solid var(--border-color);
        }

        .btn-danger:hover {
            background: #e0e0e0;
            color: #111111;
            transform: translateY(-1px);
        }

        /* Tarjetas de Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
            animation: fadeIn 0.5s ease-out;
        }

        .stat-card {
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(0, 0, 0, 0.15);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            background: #f0f0f0;
            color: #333333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.purple {
            background: #e8e8e8;
            color: #222222;
        }

        .stat-icon.green {
            background: #e0e0e0;
            color: #111111;
        }

        .stat-details h3 {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.1;
            color: var(--text-light);
        }

        .stat-details p {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Tabla de Publicaciones */
        .main-card {
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
        }

        .card-title i {
            color: var(--primary-blue);
        }

        /* Buscador */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #88889a;
        }

        .search-input {
            width: 100%;
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 15px 10px 42px;
            color: var(--text-light);
            font-family: inherit;
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            background: #ffffff;
        }

        /* Tabla */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            font-size: 0.92rem;
            vertical-align: middle;
            color: var(--text-light);
        }

        tr {
            transition: background-color 0.2s;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        .empty-row {
            text-align: center;
            color: var(--text-muted);
            padding: 50px 0;
            font-size: 1rem;
        }

        /* Elementos en Tabla */
        .row-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .row-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f5;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .row-title {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .row-slug {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-family: monospace;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-article {
            background: #f0f0f0;
            color: #333333;
            border: 1px solid var(--border-color);
        }

        .badge-page {
            background: #e8e8e8;
            color: #222222;
            border: 1px solid var(--border-color);
        }

        .badge-published {
            background: #f4f4f4;
            color: #333333;
            border: 1px solid var(--border-color);
        }

        .badge-draft {
            background: #eeeeee;
            color: #555555;
            border: 1px solid var(--border-color);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            outline: none;
            font-size: 0.9rem;
        }

        .btn-edit {
            background: #f0f0f0;
            color: #333333;
        }

        .btn-edit:hover {
            background: #333333;
            color: #ffffff;
            transform: scale(1.05);
        }

        .btn-view {
            background: #e8e8e8;
            color: #222222;
        }

        .btn-view:hover {
            background: #222222;
            color: #ffffff;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #e0e0e0;
            color: #111111;
        }

        .btn-delete:hover {
            background: #111111;
            color: #ffffff;
            transform: scale(1.05);
        }

        /* --- EDITOR / FORM DRAWER --- */
        .drawer-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(4px);
            z-index: 1500;
            display: none;
            animation: fadeInFast 0.2s ease-out;
        }

        .drawer {
            position: fixed;
            top: 0; right: -100%; width: 100%; max-width: 820px; height: 100%;
            background: #ffffff;
            border-left: 1px solid var(--border-color);
            z-index: 1501;
            box-shadow: -15px 0 45px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 30px;
        }

        .drawer.active {
            right: 0;
        }

        @keyframes fadeInFast {
            from { opacity: 0; } to { opacity: 1; }
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .drawer-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .drawer-title i {
            color: var(--primary-blue);
        }

        .drawer-close {
            background: transparent;
            color: var(--text-muted);
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .drawer-close:hover {
            color: var(--text-light);
        }

        .form-body {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 10px;
            margin-bottom: 25px;
        }

        /* Campos de Formulario */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-col {
            flex: 1;
            min-width: 0; /* Evita desborde en flex */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--text-light);
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
        }

        /* Upload de Imagen */
        .upload-area {
            border: 2px dashed rgba(0,0,0,0.12);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            background: #f8f9fa;
            transition: border-color 0.3s, background-color 0.3s;
            position: relative;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: var(--primary-blue);
            background: rgba(0, 123, 255, 0.02);
        }

        .upload-icon {
            font-size: 2.2rem;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .upload-text h5 {
            font-size: 0.92rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-light);
        }

        .upload-text p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .image-preview-box {
            position: relative;
            margin-top: 15px;
            display: none;
            border-radius: 12px;
            overflow: hidden;
            max-height: 200px;
            border: 1px solid var(--border-color);
        }

        .image-preview-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .image-remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.85);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .image-remove-btn:hover {
            background: #dc3545;
        }

        /* Override estilos de Quill */
        .ql-toolbar.ql-snow {
            background: #f8f9fa !important;
            border: 1px solid var(--border-color) !important;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .ql-container.ql-snow {
            background: #ffffff !important;
            border: 1px solid var(--border-color) !important;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            min-height: 250px;
            max-height: 350px;
            overflow-y: auto;
            color: var(--text-light) !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.98rem !important;
        }

        .ql-editor.ql-blank::before {
            color: #88889a !important;
            font-style: normal !important;
        }

        .drawer-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        /* Notificación Toast */
        .toast-notif {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #ffffff;
            border: 1px solid var(--primary-blue);
            color: var(--text-light);
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2000;
            transform: translateY(150%);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .toast-notif.active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Header del Dashboard -->
        <header>
            <div class="brand-section">
                <img class="brand-logo" src="../images/6368361aca5ec482e0c84cbf_bymike.png" alt="Mike Vazquez Logo"/>
                <div class="brand-divider"></div>
                <div class="dashboard-title">Panel de Artículos y Páginas</div>
            </div>
            
            <div class="user-actions">
                <button class="btn btn-secondary" onclick="window.open('../', '_blank')">
                    <i class="fas fa-external-link-alt"></i> Ver Web
                </button>
                <button class="btn btn-primary" onclick="openNewDrawer()">
                    <i class="fas fa-plus"></i> Nueva Entrada
                </button>
                <button class="btn btn-danger" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </button>
            </div>
        </header>

        <!-- Sección de Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-details">
                    <h3 id="stat-articles">0</h3>
                    <p>Artículos</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-details">
                    <h3 id="stat-pages">0</h3>
                    <p>Páginas Estáticas</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-details">
                    <h3 id="stat-published">0</h3>
                    <p>Publicadas</p>
                </div>
            </div>
        </div>

        <!-- Panel de Listado Principal -->
        <div class="main-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list"></i> Entradas del Sitio
                </h2>
                
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search-input" class="search-input" placeholder="Buscar entrada..."/>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Entrada</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="entries-table-body">
                        <tr>
                            <td colspan="5" class="empty-row">
                                <i class="fas fa-circle-notch fa-spin"></i> Cargando entradas...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- --- FORM DRAWER LATERAL --- -->
    <div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>
    <div class="drawer" id="drawer">
        <div class="drawer-header">
            <h3 class="drawer-title" id="drawer-title-text">
                <i class="fas fa-plus-circle"></i> Nueva Entrada
            </h3>
            <button class="drawer-close" onclick="closeDrawer()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="form-body">
            <input type="hidden" id="entry-id"/>
            <input type="hidden" id="entry-image-url"/>

            <!-- Fila Título y Slug -->
            <div class="form-row">
                <div class="form-col" style="flex: 2;">
                    <div class="form-group">
                        <label class="form-label">Título</label>
                        <input type="text" id="entry-title" class="form-control" placeholder="Ej: Las ventajas de integrar IA..." required/>
                    </div>
                </div>
                <div class="form-col" style="flex: 1.5;">
                    <div class="form-group">
                        <label class="form-label">Ruta (Slug)</label>
                        <input type="text" id="entry-slug" class="form-control" placeholder="las-ventajas-de-ia"/>
                    </div>
                </div>
            </div>

            <!-- Fila Tipo, Estado y Fecha -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Tipo</label>
                        <select id="entry-type" class="form-control">
                            <option value="articulo">Artículo (Blog)</option>
                            <option value="pagina">Página Estática</option>
                        </select>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select id="entry-status" class="form-control">
                            <option value="publicado">Publicado</option>
                            <option value="borrador">Borrador</option>
                        </select>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Fecha de Publicación</label>
                        <input type="datetime-local" id="entry-date" class="form-control"/>
                    </div>
                </div>
            </div>

            <!-- Opción Mostrar en el Home -->
            <div class="form-group" style="margin-bottom: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid var(--border-color); padding: 14px 18px; border-radius: 14px;">
                    <div style="display: flex; flex-direction: column; gap: 4px; padding-right: 12px;">
                        <span style="font-size: 0.95rem; font-weight: 600; color: var(--text-light); font-family: 'Poppins', sans-serif;">Mostrar en la Página de Inicio (Home)</span>
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.3;">Si está activado, se mostrará en la sección de "Últimas entradas" del Home. Máximo 4.</span>
                    </div>
                    <label class="switch" style="position: relative; display: inline-block; width: 44px; height: 24px; min-width: 44px; margin: 0;">
                        <input type="checkbox" id="entry-show-on-home" style="opacity: 0; width: 0; height: 0; margin: 0;">
                        <span class="slider-toggle" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px;"></span>
                    </label>
                </div>
            </div>

            <!-- Resumen / Introducción -->
            <div class="form-group">
                <label class="form-label">Resumen / Introducción (Vista previa en el blog)</label>
                <textarea id="entry-summary" class="form-control" rows="2" placeholder="Escribe 1 o 2 líneas para el resumen del artículo o página." style="resize: none;"></textarea>
            </div>

            <!-- Campos SEO Personalizados -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Título SEO (Meta Title)</label>
                        <input type="text" id="entry-meta-title" class="form-control" placeholder="Opcional. Si se deja vacío, se usará el Título principal."/>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Descripción SEO (Meta Description)</label>
                        <input type="text" id="entry-meta-desc" class="form-control" placeholder="Opcional. Si se deja vacío, se usará el Resumen principal."/>
                    </div>
                </div>
            </div>

            <!-- Subida de Imagen Destacada -->
            <div class="form-group">
                <label class="form-label">Imagen Destacada</label>
                
                <input type="file" id="file-uploader" style="display:none;" accept="image/*"/>
                <div class="upload-area" id="upload-zone" onclick="document.getElementById('file-uploader').click()">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">
                        <h5>Haz clic para seleccionar o arrastra una imagen aquí</h5>
                        <p>Formatos admitidos: JPG, PNG, GIF, WEBP, SVG. Máx 5MB.</p>
                    </div>
                </div>

                <!-- Previsualización de Imagen -->
                <div class="image-preview-box" id="preview-box">
                    <img src="" id="preview-img" class="image-preview-img" alt="Vista previa"/>
                    <button class="image-remove-btn" onclick="removeFeaturedImage(event)" title="Quitar imagen">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Editor de Contenido Quill -->
            <div class="form-group">
                <label class="form-label">Contenido de la Entrada</label>
                <div id="quill-editor"></div>
            </div>
        </div>

        <div class="drawer-footer">
            <button class="btn btn-secondary" onclick="closeDrawer()">Cancelar</button>
            <button class="btn btn-primary" id="save-btn" onclick="saveEntry()">
                <i class="fas fa-save"></i> Guardar Entrada
            </button>
        </div>
    </div>

    <!-- Toast de Notificaciones -->
    <div class="toast-notif" id="toast-el">
        <i class="fas fa-check-circle" style="color: #28a745; font-size: 1.2rem;"></i>
        <span id="toast-text">Cambios guardados con éxito</span>
    </div>

    <!-- Scripts y Librerías -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inicializar Editor Quill con opciones premium de formateo
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Escribe tu historia aquí...',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Estado Global
        let allEntries = [];
        let isEditing = false;
        let isUploading = false;
        let manualSlug = false;

        // Cargar entradas al inicio
        document.addEventListener('DOMContentLoaded', function() {
            fetchEntries();
            setupAutoSlug();
            setupDragAndDrop();
        });

        // Evento de búsqueda
        document.getElementById('search-input').addEventListener('input', function(e) {
            renderTable(e.target.value);
        });

        function fetchEntries() {
            fetch('api.php?action=list')
            .then(res => res.json())
            .then(data => {
                allEntries = data;
                renderTable();
                updateStats();
            })
            .catch(err => {
                console.error("Error cargando entradas: ", err);
                showToast("Error al cargar las entradas del sitio", "error");
            });
        }

        function updateStats() {
            const articles = allEntries.filter(e => e.type === 'articulo').length;
            const pages = allEntries.filter(e => e.type === 'pagina').length;
            const published = allEntries.filter(e => e.status === 'publicado').length;

            document.getElementById('stat-articles').textContent = articles;
            document.getElementById('stat-pages').textContent = pages;
            document.getElementById('stat-published').textContent = published;
        }

        function renderTable(searchTerm = '') {
            const tbody = document.getElementById('entries-table-body');
            const search = searchTerm.toLowerCase().trim();
            
            const filtered = allEntries.filter(e => {
                return e.title.toLowerCase().includes(search) || 
                       e.slug.toLowerCase().includes(search) ||
                       e.summary.toLowerCase().includes(search);
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="empty-row">
                            <i class="fas fa-folder-open" style="font-size: 2rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                            ${searchTerm ? 'No se encontraron entradas coincidentes' : 'No hay entradas creadas todavía.'}
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = '';
            filtered.forEach(e => {
                const dateStr = formatDate(e.date);
                const typeBadge = e.type === 'articulo' 
                    ? `<span class="badge badge-article"><i class="fas fa-newspaper"></i> Artículo</span>`
                    : `<span class="badge badge-page"><i class="fas fa-file-alt"></i> Página</span>`;
                
                const statusBadge = e.status === 'publicado'
                    ? `<span class="badge badge-published"><i class="fas fa-check"></i> Publicado</span>`
                    : `<span class="badge badge-draft"><i class="fas fa-pen-nib"></i> Borrador</span>`;

                const thumb = e.image 
                    ? `../${e.image}` 
                    : `../images/63501656a5fc5fbefd7a08f5_Mike-Vazquez-on-negro.png`;

                tbody.innerHTML += `
                    <tr>
                        <td>
                            <div class="row-info">
                                <img src="${thumb}" class="row-thumb" alt="Thumbnail"/>
                                <div>
                                    <div class="row-title">${escapeHtml(e.title)}</div>
                                    <div class="row-slug">/${e.slug}/</div>
                                </div>
                            </div>
                        </td>
                        <td>${typeBadge}</td>
                        <td>${statusBadge}</td>
                        <td style="color: var(--text-muted);">${dateStr}</td>
                        <td>
                            <div class="actions-cell">
                                <button class="btn-icon btn-edit" onclick="editEntry('${e.id}')" title="Editar entrada">
                                    <i class="fas fa-edit"></i>
                                </button>
                                ${e.status === 'publicado' ? `
                                    <button class="btn-icon btn-view" onclick="window.open('../${e.slug}/', '_blank')" title="Ver página estática">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                ` : ''}
                                <button class="btn-icon btn-delete" onclick="deleteEntry('${e.id}', '${escapeHtml(e.title)}')" title="Eliminar entrada">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }

        // Helpers de Formateo
        function formatDate(dateStr) {
            try {
                const d = new Date(dateStr.replace(' ', 'T'));
                return d.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
            } catch(e) {
                return dateStr;
            }
        }

        function escapeHtml(text) {
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Lógica de URLs Dinámicas (Auto Slug)
        function setupAutoSlug() {
            const titleInput = document.getElementById('entry-title');
            const slugInput = document.getElementById('entry-slug');

            titleInput.addEventListener('input', function() {
                if (!manualSlug) {
                    slugInput.value = slugify(titleInput.value);
                }
            });

            slugInput.addEventListener('input', function() {
                manualSlug = true;
                slugInput.value = slugify(slugInput.value);
                if (slugInput.value === '') {
                    manualSlug = false;
                }
            });
        }

        function slugify(text) {
            // Conversión básica a minúsculas, eliminación de acentos y caracteres raros
            return text
                .toString()
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "") // Quitar acentos
                .replace(/[^a-z0-9 -]/g, "") // Quitar no permitidos
                .replace(/\s+/g, "-") // Reemplazar espacios por -
                .replace(/-+/g, "-") // Quitar dobles -
                .trim();
        }

        // Subida de imagen y arrastre
        function setupDragAndDrop() {
            const uploader = document.getElementById('file-uploader');
            const uploadZone = document.getElementById('upload-zone');

            uploader.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    uploadImage(e.target.files[0]);
                }
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    uploadZone.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    uploadZone.classList.remove('dragover');
                }, false);
            });

            uploadZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    uploadImage(files[0]);
                }
            }, false);
        }

        function uploadImage(file) {
            if (isUploading) return;
            isUploading = true;

            const uploadZone = document.getElementById('upload-zone');
            const originalHTML = uploadZone.innerHTML;
            
            uploadZone.innerHTML = `
                <div class="upload-icon"><i class="fas fa-spinner fa-spin" style="color: var(--primary-blue)"></i></div>
                <div class="upload-text"><h5>Subiendo imagen al servidor...</h5></div>
            `;

            const formData = new FormData();
            formData.append('image', file);

            fetch('api.php?action=upload_image', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                isUploading = false;
                uploadZone.innerHTML = originalHTML;

                if (data.success) {
                    setFeaturedImage(data.url);
                    showToast("Imagen subida con éxito", "success");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de subida',
                        text: data.message || 'No se pudo subir la imagen'
                    });
                }
            })
            .catch(err => {
                isUploading = false;
                uploadZone.innerHTML = originalHTML;
                console.error(err);
                showToast("Error de conexión al subir la imagen", "error");
            });
        }

        function setFeaturedImage(url) {
            document.getElementById('entry-image-url').value = url;
            document.getElementById('preview-img').src = `../${url}`;
            document.getElementById('upload-zone').style.display = 'none';
            document.getElementById('preview-box').style.display = 'block';
        }

        function removeFeaturedImage(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('entry-image-url').value = '';
            document.getElementById('file-uploader').value = '';
            document.getElementById('upload-zone').style.display = 'block';
            document.getElementById('preview-box').style.display = 'none';
        }

        // Abrir y Cerrar Drawer
        function openNewDrawer() {
            isEditing = false;
            manualSlug = false;
            
            document.getElementById('drawer-title-text').innerHTML = '<i class="fas fa-plus-circle"></i> Nueva Entrada';
            document.getElementById('entry-id').value = '';
            document.getElementById('entry-title').value = '';
            document.getElementById('entry-slug').value = '';
            document.getElementById('entry-summary').value = '';
            document.getElementById('entry-meta-title').value = '';
            document.getElementById('entry-meta-desc').value = '';
            document.getElementById('entry-type').value = 'articulo';
            document.getElementById('entry-status').value = 'publicado';
            document.getElementById('entry-show-on-home').checked = false;
            
            // Establecer fecha y hora local actual
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('entry-date').value = now.toISOString().slice(0, 16);
            
            // Limpiar imagen
            document.getElementById('entry-image-url').value = '';
            document.getElementById('file-uploader').value = '';
            document.getElementById('upload-zone').style.display = 'block';
            document.getElementById('preview-box').style.display = 'none';
            
            // Limpiar contenido editor
            quill.setContents([]);

            document.getElementById('drawer-overlay').style.display = 'block';
            setTimeout(() => {
                document.getElementById('drawer').classList.add('active');
            }, 50);
        }

        function editEntry(id) {
            const entry = allEntries.find(e => e.id === id);
            if (!entry) return;

            isEditing = true;
            manualSlug = true;

            document.getElementById('drawer-title-text').innerHTML = '<i class="fas fa-edit"></i> Editar Entrada';
            document.getElementById('entry-id').value = entry.id;
            document.getElementById('entry-title').value = entry.title;
            document.getElementById('entry-slug').value = entry.slug;
            document.getElementById('entry-summary').value = entry.summary || '';
            document.getElementById('entry-meta-title').value = entry.meta_title || '';
            document.getElementById('entry-meta-desc').value = entry.meta_description || '';
            document.getElementById('entry-type').value = entry.type;
            document.getElementById('entry-status').value = entry.status;
            document.getElementById('entry-show-on-home').checked = !!entry.show_on_home;
            
            // Formatear fecha para datetime-local
            const d = new Date(entry.date.replace(' ', 'T'));
            d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
            document.getElementById('entry-date').value = d.toISOString().slice(0, 16);

            // Cargar imagen
            if (entry.image) {
                setFeaturedImage(entry.image);
            } else {
                document.getElementById('entry-image-url').value = '';
                document.getElementById('upload-zone').style.display = 'block';
                document.getElementById('preview-box').style.display = 'none';
            }

            // Cargar contenido en Quill
            quill.clipboard.dangerouslyPasteHTML(entry.content);

            document.getElementById('drawer-overlay').style.display = 'block';
            setTimeout(() => {
                document.getElementById('drawer').classList.add('active');
            }, 50);
        }

        function closeDrawer() {
            document.getElementById('drawer').classList.remove('active');
            setTimeout(() => {
                document.getElementById('drawer-overlay').style.display = 'none';
            }, 300);
        }

        // Guardar Entrada (Crear / Editar)
        function saveEntry() {
            const id = document.getElementById('entry-id').value;
            const title = document.getElementById('entry-title').value.trim();
            const slug = document.getElementById('entry-slug').value.trim();
            const summary = document.getElementById('entry-summary').value.trim();
            const meta_title = document.getElementById('entry-meta-title').value.trim();
            const meta_description = document.getElementById('entry-meta-desc').value.trim();
            const type = document.getElementById('entry-type').value;
            const status = document.getElementById('entry-status').value;
            const show_on_home = document.getElementById('entry-show-on-home').checked;
            const image = document.getElementById('entry-image-url').value;
            const dateVal = document.getElementById('entry-date').value;
            const content = quill.root.innerHTML;

            if (!title) {
                Swal.fire({ icon: 'warning', title: 'Campos incompletos', text: 'Por favor, introduce un título para la entrada' });
                return;
            }

            // Formatear fecha a formato MySQL/estándar Y-m-d H:i:s
            let date = '';
            if (dateVal) {
                const d = new Date(dateVal);
                date = d.getFullYear() + '-' + 
                       String(d.getMonth() + 1).padStart(2, '0') + '-' + 
                       String(d.getDate()).padStart(2, '0') + ' ' + 
                       String(d.getHours()).padStart(2, '0') + ':' + 
                       String(d.getMinutes()).padStart(2, '0') + ':00';
            } else {
                const d = new Date();
                date = d.getFullYear() + '-' + 
                       String(d.getMonth() + 1).padStart(2, '0') + '-' + 
                       String(d.getDate()).padStart(2, '0') + ' ' + 
                       String(d.getHours()).padStart(2, '0') + ':' + 
                       String(d.getMinutes()).padStart(2, '0') + ':00';
            }

            const payload = { id, title, slug, summary, meta_title, meta_description, type, status, image, date, content, show_on_home };
            const saveBtn = document.getElementById('save-btn');
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

            fetch('api.php?action=save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar Entrada';

                if (data.success) {
                    closeDrawer();
                    fetchEntries();
                    showToast(data.message, "success");
                } else {
                    Swal.fire({ icon: 'error', title: 'Error al guardar', text: data.message });
                }
            })
            .catch(err => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar Entrada';
                console.error(err);
                showToast("Error de conexión al guardar entrada", "error");
            });
        }

        // Eliminar Entrada
        function deleteEntry(id, title) {
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¿Quieres eliminar la entrada <b>"${title}"</b>?<br>Esta acción eliminará su página estática y no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('api.php?action=delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            fetchEntries();
                            showToast("Entrada eliminada correctamente", "success");
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error al eliminar', text: data.message });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast("Error de conexión al eliminar la entrada", "error");
                    });
                }
            });
        }

        // Cerrar sesión
        function handleLogout() {
            fetch('api.php?action=logout')
            .then(() => {
                window.location.reload();
            });
        }

        // Sistema de Toast simple
        function showToast(message, type = "success") {
            const toast = document.getElementById('toast-el');
            const toastText = document.getElementById('toast-text');
            
            toastText.textContent = message;
            
            if (type === "error") {
                toast.style.borderColor = "#dc3545";
                toast.querySelector('i').className = "fas fa-exclamation-circle";
                toast.querySelector('i').style.color = "#dc3545";
            } else {
                toast.style.borderColor = "var(--primary-blue)";
                toast.querySelector('i').className = "fas fa-check-circle";
                toast.querySelector('i').style.color = "#28a745";
            }

            toast.classList.add('active');
            setTimeout(() => {
                toast.classList.remove('active');
            }, 3500);
        }
    </script>
</body>
</html>
<?php endif; ?>
