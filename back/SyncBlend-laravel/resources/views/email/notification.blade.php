<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? 'Syncblend App' }}</title>
    <style>
        /* Estilos generales del body */
        .container {
            max-width: 768px;
            margin-left: auto;
            margin-right: auto;
            padding: 1rem;
            color: #58C4DC;
            background-color: #4D525C;
            text-align: center;
            font-family: 'Perpetua', sans-serif;
        }

        /* Título principal */
        h4 {
            font-size: 1.25rem; /* text-xl */
            font-weight: bold; /* font-bold */
        }

        /* Texto de bienvenida */
        p {
            margin-top: 1rem; /* mt-4 */
            text-align: center;
        }

        /* Enlace con efecto hover */
        a {
            text-decoration: none;
            color: #58C4DC;
        }

        a:hover {
            border-bottom: 1px solid #58C4DC; /* hover:border-b border-solid border-[#58C4DC] */
        }

        /* Footer */
        footer {
            margin-top: 2rem;
            font-size: 0.875rem;
        }

    </style>
</head>
<body>
<div class="container">
    <h4>{{ $subject ?? 'Syncblend App' }}</h4>
    <p>Bienvenido: <strong>{{ $name ?? 'User' }}</strong></p>
    <p>Pulsa en el siguiente enlace para acceder al cuestionario:
        <a href="{{ $quizUrl ?? '#' }}">Acceder al cuestionario</a>
    </p>

    <footer>
        <p>&copy; {{ date('Y') }} Syncblend App. Todos los derechos reservados.</p>
    </footer>
</div>
</body>
</html>
