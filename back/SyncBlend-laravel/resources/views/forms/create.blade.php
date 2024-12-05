<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>Crear Formulario</h1>
    <form action="{{ route('forms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Formulario</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <h2>Preguntas</h2>
        <div id="questions-container">
            <div class="question-item">
                <div class="mb-3">
                    <label for="questions[0][question]" class="form-label">Pregunta</label>
                    <input type="text" class="form-control" name="questions[0][question]" required>
                </div>
                <div class="mb-3">
                    <label for="questions[0][answers]" class="form-label">Respuestas (separadas por comas)</label>
                    <input type="text" class="form-control" name="questions[0][answers][]" placeholder="Respuesta 1" required>
                    <input type="text" class="form-control mt-2" name="questions[0][answers][]" placeholder="Respuesta 2" required>
                </div>
                <button type="button" class="btn btn-danger remove-question">Eliminar Pregunta</button>
                <hr>
            </div>
        </div>
        <button type="button" id="add-question" class="btn btn-secondary mb-3">Agregar Pregunta</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script>
    let questionIndex = 1;

    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const questionTemplate = `
            <div class="question-item">
                <div class="mb-3">
                    <label for="questions[${questionIndex}][question]" class="form-label">Pregunta</label>
                    <input type="text" class="form-control" name="questions[${questionIndex}][question]" required>
                </div>
                <div class="mb-3">
                    <label for="questions[${questionIndex}][answers]" class="form-label">Respuestas (separadas por comas)</label>
                    <input type="text" class="form-control" name="questions[${questionIndex}][answers][]" placeholder="Respuesta 1" required>
                    <input type="text" class="form-control mt-2" name="questions[${questionIndex}][answers][]" placeholder="Respuesta 2" required>
                </div>
                <button type="button" class="btn btn-danger remove-question">Eliminar Pregunta</button>
                <hr>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', questionTemplate);
        questionIndex++;
    });

    document.getElementById('questions-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-question')) {
            event.target.closest('.question-item').remove();
        }
    });
</script>
</body>
</html>
