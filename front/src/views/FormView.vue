<script setup>
import FormScreen from '@/components/FormScreen.vue';
import LayoutMain from '@/layout/LayoutMain.vue';
import { useFormView } from '@/composable/views/useFormView';
import { ref, reactive } from 'vue';

const forms = useFormView();
const currentStep = ref(1); // Paso actual (1: Información del formulario, 2: Preguntas y respuestas)
const questions = reactive([{ question: '', answers: [''] }]); // Lista de preguntas
const currentQuestionIndex = ref(0); // Índice de la pregunta visible
const showModal = ref(false); // Controlar la visibilidad del modal

// Funciones para manejar preguntas y respuestas
const addQuestion = () => {
  questions.push({ question: '', answers: [''] });
  currentQuestionIndex.value = questions.length - 1; // Mover a la nueva pregunta
};

const removeQuestion = (index) => {
  if (questions.length > 1) {
    questions.splice(index, 1);
    currentQuestionIndex.value = Math.min(currentQuestionIndex.value, questions.length - 1); // Ajustar índice actual
  }
};

const addAnswer = () => {
  questions[currentQuestionIndex.value].answers.push('');
};

const removeAnswer = (aIndex) => {
  if (questions[currentQuestionIndex.value].answers.length > 1) {
    questions[currentQuestionIndex.value].answers.splice(aIndex, 1);
  }
};

// Navegación entre preguntas
const nextQuestion = () => {
  if (currentQuestionIndex.value < questions.length - 1) {
    currentQuestionIndex.value++;
  }
};

const prevQuestion = () => {
  if (currentQuestionIndex.value > 0) {
    currentQuestionIndex.value--;
  }
};

// Guardar formulario completo
const saveFullForm = () => {
  const newForm = {
    name: forms.name.value,
    description: forms.description.value,
    questions: JSON.parse(JSON.stringify(questions)), // Clonar para evitar referencias reactivas
  };
  forms.formsJSON.push(newForm);
  forms.name.value = '';
  forms.description.value = '';
  questions.splice(0, questions.length, { question: '', answers: [''] }); // Resetear preguntas
  currentStep.value = 1; // Reiniciar pasos
  currentQuestionIndex.value = 0; // Reiniciar navegación
  showModal.value = false; // Cerrar modal
};

const goToNextStep = () => {
  if (currentStep.value === 1) currentStep.value = 2;
};

const goToPreviousStep = () => {
  if (currentStep.value === 2) currentStep.value = 1;
};

// Ir a la pregunta seleccionada
const goToQuestion = (index) => {
  currentQuestionIndex.value = index; // Actualizar el índice de la pregunta actual
};
const cancelForm = () => {
  showModal.value = false;
  forms.name.value = '';
  forms.description.value = '';
  questions.splice(0, questions.length, { question: '', answers: [''] });
  currentStep.value = 1;
  currentQuestionIndex.value = 0;
};
</script>

<template>
  <LayoutMain>
    <template #title>Forms</template>
    <template #subtitle>subtitle</template>
    <template #icon></template>
    <template #buttons>
      <q-btn color="primary" @click="showModal = true">Crear Formulario</q-btn>
    </template>
    <FormScreen :formsJSON="forms.formsJSON" />

    <!-- Modal para crear formulario en dos pasos -->
    <q-dialog v-model="showModal" persistent>
      <q-card :class="currentStep === 2 ? 'wide-card elevated-card' : 'elevated-card'">
        <q-card-section>
          <div class="text-h6">
            {{ currentStep === 1 ? 'Información del Formulario' : 'Preguntas y Respuestas' }}
          </div>
        </q-card-section>

        <q-card-section v-if="currentStep === 1">
          <q-input v-model="forms.name.value" label="Nombre del formulario" filled />
          <q-input v-model="forms.description.value" label="Descripción" filled />
        </q-card-section>

        <q-card-section v-else>
          <!-- Renderizar solo la pregunta actual -->
          <div>
            <q-input
              v-model="questions[currentQuestionIndex].question"
              label="Pregunta"
              filled
            />
            <div v-for="(answer, aIndex) in questions[currentQuestionIndex].answers" :key="aIndex">
              <q-input v-model="questions[currentQuestionIndex].answers[aIndex]" label="Respuesta" filled />
              <q-btn flat icon="remove" @click="removeAnswer(aIndex)" />
            </div>
            <q-btn flat label="Agregar respuesta" @click="addAnswer" />
          </div>

          <!-- Controles de navegación -->
          <div class="pagination-controls">
            <q-btn flat label="Atrás" icon="arrow_back" @click="prevQuestion" :disable="currentQuestionIndex === 0" />
            <q-btn flat label="Siguiente" icon="arrow_forward" @click="nextQuestion" :disable="currentQuestionIndex === questions.length - 1" />
          </div>

          <!-- Botón para agregar nueva pregunta -->
          <q-btn flat color="primary" label="Agregar pregunta" @click="addQuestion" />
        </q-card-section>

        <q-card-actions align="right">
          <q-btn v-if="currentStep === 2" flat label="Atrás" @click="goToPreviousStep" />
          <q-btn v-if="currentStep === 1" flat color="primary" label="Siguiente" @click="goToNextStep" />
          <q-btn v-if="currentStep === 2" flat color="primary" label="Guardar" @click="saveFullForm" />
          <q-btn flat label="Cancelar" @click="cancelForm"/>
        </q-card-actions>
      </q-card>

      <!-- Resumen de preguntas (siempre visible y centrado) -->
      <q-card-section v-if="currentStep === 2" class="question-summary">
        <div v-for="(question, qIndex) in questions" :key="qIndex" class="question-card" @click="goToQuestion(qIndex)">
          <q-card>
            <q-card-section>
              <div> {{ question.question || 'Pregunta sin título' }}</div>
            </q-card-section>
          </q-card>
        </div>
      </q-card-section>
    </q-dialog>
  </LayoutMain>
</template>

<style scoped>
/* Clase para ampliar el modal en el segundo paso */
.wide-card {
  width: 80vw; /* Ancho del modal */
  max-width: 1000px;
  max-height: 80vh; /* Evitar que el modal se haga más grande de lo necesario */
}

/* Clase para elevar el modal hacia arriba */
.elevated-card {
  margin-top: 10px;
}

/* Controles de paginación */
.pagination-controls {
  display: flex;
  justify-content: space-between;
  margin-top: 1px;
}

/* Estilo para el resumen de preguntas centrado */
.question-summary {
  width: 80vw;
  margin-top: 1px;
  display: flex;
  justify-content: center;
  flex-direction: row;
  align-items: center;
  max-width: 1000px;
}

.question-card {
  margin-bottom: 8px;
  width: 50%;
  max-width: 600px;
  padding: 10px;
  cursor: pointer; /* Cursor para indicar que la tarjeta es interactiva */
}

/* Estilo para la card general */
.q-card {
  width: 100%;
}
</style>
