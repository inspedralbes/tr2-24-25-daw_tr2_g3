<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>{{ $subject ?? 'Syncblend App' }}</title>
</head>
<body>
<div class="container mx-auto p-4">
    <h4 class="text-xl font-bold">{{ $subject ?? 'Syncblend App' }}</h4>
    <p>Bienvenido: {{ $name ?? 'User' }}</p>
    <p>Pulsa en el siguiente enlace para acceder al cuestionario: <a href="{{ $quizUrl ?? '#' }}" class="text-blue-500">Acceder al cuestionario</a></p>
    <p>Gracias por tu participación {{ $name ?? 'User' }}</p>

    <footer>
        <p>&copy; {{ date('Y') }} Syncblend App. Todos los derechos reservados.</p>
    </footer>
</div>
</body>
</html>
