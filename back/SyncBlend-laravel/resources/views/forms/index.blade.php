<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>Formularios</h1>
    <a href="{{ route('forms.create') }}" class="btn btn-success mb-3">Crear Nuevo Formulario</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Preguntas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
                <tr>
                    <td>{{ $form->name }}</td>
                    <td>
                        <ul>
                            @foreach ($form->questions as $question)
                                <li>{{ $question->question }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
