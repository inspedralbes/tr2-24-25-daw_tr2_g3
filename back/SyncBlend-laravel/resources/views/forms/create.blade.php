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
                    <label class="form-label">Respuestas</label>
                    <div class="answers-container">
                        <input type="text" class="form-control mb-2" name="questions[0][answers][]" placeholder="Respuesta 1" required>
                        <input type="text" class="form-control mb-2" name="questions[0][answers][]" placeholder="Respuesta 2" required>
                    </div>
                    <button type="button" class="btn btn-secondary add-answer">Agregar Respuesta</button>
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

    // Función para agregar una nueva pregunta
    document.getElementById('add-question').addEventListener('click', function () {
        const container = document.getElementById('questions-container');
        const questionTemplate = `
            <div class="question-item">
                <div class="mb-3">
                    <label for="questions[${questionIndex}][question]" class="form-label">Pregunta</label>
                    <input type="text" class="form-control" name="questions[${questionIndex}][question]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Respuestas</label>
                    <div class="answers-container">
                        <input type="text" class="form-control mb-2" name="questions[${questionIndex}][answers][]" placeholder="Respuesta 1" required>
                        <input type="text" class="form-control mb-2" name="questions[${questionIndex}][answers][]" placeholder="Respuesta 2" required>
                    </div>
                    <button type="button" class="btn btn-secondary add-answer">Agregar Respuesta</button>
                </div>
                <button type="button" class="btn btn-danger remove-question">Eliminar Pregunta</button>
                <hr>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', questionTemplate);
        questionIndex++;
    });

    // Delegación de eventos para manejar las respuestas dinámicas
    document.getElementById('questions-container').addEventListener('click', function (event) {
        if (event.target.classList.contains('add-answer')) {
            const answersContainer = event.target.previousElementSibling;
            const inputCount = answersContainer.querySelectorAll('input').length;
            const questionIndex = Array.from(document.getElementsByClassName('question-item')).indexOf(event.target.closest('.question-item'));
            const newAnswerInput = `
                <input type="text" class="form-control mb-2" name="questions[${questionIndex}][answers][]" placeholder="Respuesta ${inputCount + 1}" required>
            `;
            answersContainer.insertAdjacentHTML('beforeend', newAnswerInput);
        }

        if (event.target.classList.contains('remove-question')) {
            event.target.closest('.question-item').remove();
        }
    });
</script>
</body>
</html>
