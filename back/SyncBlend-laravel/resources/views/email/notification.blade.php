<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? 'Syncblend App' }}</title>
    <style>
        /* Estilos generales del body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F4F4F4; /* Gris más claro */
            color: #333; /* Color oscuro para el texto general */
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #e3e3e3; /* Fondo blanco para el contenido */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); /* Sutil sombra para efecto de elevación */
            text-align: center;
        }

        /* Título principal */
        h4 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #58C4DC; /* Azul para el título */
            margin-bottom: 20px;
        }

        /* Texto de bienvenida */
        p {
            margin-bottom: 15px;
            color: #555; /* Gris oscuro para el texto */
        }

        /* Enlace con efecto hover */
        /*a {*/
        /*    text-decoration: none;*/
        /*    color: #58C4DC;*/
        /*    font-weight: bold;*/
        /*}*/

        /*a:hover {*/
        /*    text-decoration: underline; !* Subrayado al pasar el cursor *!*/
        /*}*/

        /* Footer */
        footer {
            margin-top: 30px;
            font-size: 0.875rem;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h4>{{ $subject ?? 'Syncblend App' }}</h4>
    <p>Bienvenido: <strong>{{ $name ?? 'User' }} {{$lastname ?? 'User' }}</strong></p>
    <p>Pulsa en el siguiente enlace para acceder al cuestionario:</p>
    <p>
        <a href="{{ $quizUrl ?? '#' }}" style="text-decoration: none; color: #58C4DC; font-weight: bold;"
           onmouseover="this.style.textDecoration='underline'"
           onmouseout="this.style.textDecoration='none'">
            Acceder al cuestionario
        </a>
    </p>

    <footer>
        <p>&copy; {{ date('Y') }} Syncblend App. Todos los derechos reservados.</p>
    </footer>
</div>
</body>
</html>
