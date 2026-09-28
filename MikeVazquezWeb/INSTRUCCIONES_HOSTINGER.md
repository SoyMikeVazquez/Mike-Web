# Mike Vazquez Web - Producción

Esta carpeta contiene la versión optimizada y local de tu sitio web personal.

## Instrucciones para subir a Hostinger:
1. Comprime los archivos y carpetas de esta carpeta (`MikeVazquezWeb`) en un archivo `.zip`.
2. Sube el `.zip` a tu administrador de archivos en Hostinger, específicamente dentro de la carpeta `public_html`.
3. Extrae el contenido. Asegúrate de que el archivo `.htaccess` esté presente en la raíz de `public_html`.
4. **Archivo de Configuración (.env):**
   - Asegúrate de que tu archivo `.env` esté en `public_html/.env` con tus credenciales seguras.
   - El archivo `.htaccess` ya está configurado para bloquear cualquier intento de acceso web a tu `.env` y archivos sensibles.

## Subida a GitHub:
- El archivo `.gitignore` ya está configurado para **ignorar automáticamente** el archivo `.env` y cualquier archivo de credenciales.
- En GitHub solo se subirá el archivo de plantilla `.env.example`, manteniendo tus claves, correos y contraseñas 100% protegidos.

## Optimizaciones y Seguridad incluidas:
- **Protección de Secretos:** Credenciales separadas en `.env` no versionado.
- **Bloqueo Web:** `.htaccess` deniega acceso a archivos de entorno, archivos ocultos y listado de directorios.
- **Redirección 404:** Cualquier URL mal escrita redirigirá automáticamente al Home.
- **Gzip Compression:** Compresión activa para carga ultrarrápida.
- **Browser Caching:** Servidor configurado para almacenamiento en caché de imágenes y fuentes.
- **Independencia de CDNs:** Recursos locales sin dependencias externas críticas.
