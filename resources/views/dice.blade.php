<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice Dados</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <!-- Logo SVG de dados -->
        <img src="https://svgsilh.com/svg/152068-e91e63.svg" class="w-12 h-12 md:w-30 md:h-16 text-blue-500 mb-4"  viewBox="0 0 20 20" fill="currentColor" width="300" alt="dados">

        <h1 class="text-2xl md:text-4xl font-bold mb-4 text-center">Bienvenido a la API de Dados</h1>
        <p class="text-base md:text-lg text-gray-700 mb-8 text-center">Esta API proporciona endpoints para simular el lanzamiento de dados y obtener resultados aleatorios.</p>
        <a href="{{url('api/documentation')}}" class="text-base md:text-2xl sm:text-3xl bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-300 ease-in-out">Ver Documentación</a>
        
        <!-- Botones para abrir modales -->
        <div class="mt-4 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <button onclick="openModal('stackModal')" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-300 ease-in-out w-full md:w-auto text-sm md:text-base">Tecnologías Utilizadas</button>
            <button onclick="openModal('summaryModal')" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-300 ease-in-out w-full md:w-auto text-sm md:text-base">Resumen de la API</button>
            <button onclick="openModal('postmanModal')" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-300 ease-in-out w-full md:w-auto text-sm md:text-base">Cómo Usar con Postman</button>
        </div>

        <!-- Modales -->
        <div id="stackModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-4 md:p-8 rounded-md">
                <h2 class="text-lg md:text-2xl font-semibold mb-4">Tecnologías Utilizadas</h2>
                <div class="flex items-center mb-2">
                    <i class="fab fa-laravel text-2xl md:text-3xl mr-2"></i>
                    <p class="text-sm md:text-base">Laravel Framework</p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fab fa-mysql text-2xl md:text-3xl mr-2"></i>
                    <p class="text-sm md:text-base">MySql</p>
                </div>
                <div class="flex items-center">
                    <i class="fab fa-php text-2xl md:text-3xl mr-2"></i>
                    <p class="text-sm md:text-base">PHP</p>
                </div>
                <button onclick="closeModal('stackModal')" class="mt-4 bg-blue-500 hover:bg-red-600 text-white font-semibold px-2 md:px-4 py-1 md:py-2 rounded-md shadow-md transition duration-300 ease-in-out text-sm md:text-base">Cerrar</button>
            </div>
        </div>

        <div id="summaryModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-4 md:p-8 rounded-md">
                <h2 class="text-lg md:text-2xl font-semibold mb-4">Resumen de la API</h2>
                <p class="text-base md:text-lg">API de un juego de dados usando Laravel y PHP con Laravel Passport para los tokens y Spatie para los roles y permisos.</p>
                <button onclick="closeModal('summaryModal')" class="mt-4 bg-blue-500 hover:bg-red-600 text-white font-semibold px-2 md:px-4 py-1 md:py-2 rounded-md shadow-md transition duration-300 ease-in-out text-sm md:text-base">Cerrar</button>
            </div>
        </div>

        <div id="postmanModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-4 md:p-8 rounded-md">
                <h2 class="text-lg md:text-2xl font-semibold mb-4">Cómo Usar con Postman</h2>
                <ol class="list-decimal pl-4">
                    <li>Abre Postman.</li>
                    <li>Crea una nueva solicitud.</li>
                    <li>Selecciona el método HTTP deseado (GET, POST, etc.).</li>
                    <li>Ingresa la URL del endpoint de la API.</li>
                    <li>Agrega los parámetros necesarios en el cuerpo o la URL, según corresponda.</li>
                    <li>Agrega los encabezados necesarios, como los tokens de autenticación si es necesario.</li>
                    <li>Envía la solicitud y espera la respuesta.</li>
                </ol>
                <button onclick="closeModal('postmanModal')" class="mt-4 bg-blue-500 hover:bg-red-600 text-white font-semibold px-2 md:px-4 py-1 md:py-2 rounded-md shadow-md transition duration-300 ease-in-out text-sm md:text-base">Cerrar</button>
            </div>
        </div>

        <!-- Iconos de GitHub y LinkedIn -->
        <div class="mt-4 flex space-x-4">
            <a href="https://github.com/pupadevs" target="_blank" class="text-gray-700 hover:text-gray-900"><i class="fab fa-github text-2xl md:text-3xl"></i></a>
            <a href="https://www.linkedin.com/in/peterson-sena" target="_blank" class="text-gray-700 hover:text-gray-900"><i class="fab fa-linkedin text-2xl md:text-3xl"></i></a>
        </div>
    </div>

    <!-- JavaScript para controlar los modales -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>
</html>
