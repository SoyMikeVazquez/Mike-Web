const { exec, spawn } = require('child_process');

console.log('\x1b[35m%s\x1b[0m', '=== Entorno de Desarrollo Local - Mike Vazquez ===');

// Verificar si PHP está instalado
exec('which php || php -v', (err, stdout, stderr) => {
    if (err) {
        console.error('\x1b[31m%s\x1b[0m', '\nError: PHP no está instalado en este sistema.');
        console.log('\x1b[36m%s\x1b[0m', 'Para ejecutar este sitio web (que utiliza archivos .php) localmente, necesitas PHP.');
        console.log('\x1b[36m%s\x1b[0m', 'Dado que estás en Mac con Homebrew disponible, puedes instalarlo ejecutando:');
        console.log('\x1b[33m%s\x1b[0m', '  brew install php');
        console.log('\x1b[36m%s\x1b[0m', 'Una vez instalado, vuelve a ejecutar "npm run dev".\n');
        process.exit(1);
    }

    const port = 8000;
    const url = `http://localhost:${port}`;

    console.log('\x1b[36m%s\x1b[0m', `Iniciando servidor local PHP en ${url} ...`);

    // Iniciar servidor PHP
    const phpServer = spawn('php', ['-S', `localhost:${port}`]);

    phpServer.stdout.on('data', (data) => {
        process.stdout.write(`[PHP] ${data}`);
    });

    phpServer.stderr.on('data', (data) => {
        // El servidor PHP de desarrollo escribe logs de peticiones en stderr
        process.stdout.write(`[PHP Log] ${data}`);
    });

    phpServer.on('error', (spawnError) => {
        console.error('\x1b[31m%s\x1b[0m', `Error al iniciar el servidor PHP: ${spawnError.message}`);
        process.exit(1);
    });

    // Esperar 1 segundo para abrir el navegador y dar tiempo a que el puerto se levante
    setTimeout(() => {
        console.log('\x1b[32m%s\x1b[0m', `Abriendo ${url} en tu navegador predeterminado...`);
        exec(`open ${url}`);
    }, 1000);

    // Manejo de salida limpia (Ctrl+C)
    process.on('SIGINT', () => {
        console.log('\x1b[33m%s\x1b[0m', '\nDeteniendo servidor de desarrollo PHP...');
        phpServer.kill();
        process.exit();
    });
});
