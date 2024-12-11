<script setup>
import FormScreen from '@/components/FormScreen.vue';
import LayoutMain from '@/layout/LayoutMain.vue';
import { useFormView } from '@/composable/views/useFormView';
import { ref, reactive, computed } from 'vue';

const forms = useFormView();
const currentStep = ref(1); // Paso actual (1: Información del formulario, 2: Preguntas y respuestas)

const questions = reactive([
  { question: '', answers: [''] },
]);

// Paginación
const questionsPerPage = 2; // Número de preguntas por página
const currentPage = ref(1); // Página actual

// Número total de páginas
const totalPages = computed(() =>
  Math.ceil(questions.length / questionsPerPage)
);

// Preguntas de la página actual
const currentQuestions = computed(() =>
  questions.slice(
    (currentPage.value - 1) * questionsPerPage,
    currentPage.value * questionsPerPage
  )
);

// Navegar entre páginas
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

// Añadir nueva pregunta
const addQuestion = () => {
  questions.push({ question: '', answers: [''] });
};

// Añadir respuesta
const addAnswer = (index) => {
  questions[index].answers.push('');
};

// Guardar formulario completo
const saveFullForm = () => {
  const newForm = {
    name: forms.name.value,
    description: forms.description.value,
    questions: JSON.parse(JSON.stringify(questions)), // Clonar preguntas para evitar referencias reactivas
  };

  forms.formsJSON.push(newForm);
  forms.name.value = '';
  forms.description.value = '';
  questions.splice(0, questions.length); // Resetear preguntas
  addQuestion(); // Añadir la primera pregunta
  forms.closeModal();
};
</script>

<template>
  <LayoutMain>
    <template #title>Forms</template>
    <template #subtitle>subtitle</template>
    <template #icon></template>
    <template #buttons>
      <q-btn color="primary" @click="forms.openModal()">Crear Formulario</q-btn>
    </template>
    <FormScreen :formsJSON="forms.formsJSON" />
  </LayoutMain>

  <!-- Diálogo para creación de formularios -->
  <q-dialog
    v-model="forms.isModalOpen.value"
    persistent
    class="large-dialog"
  >
    <q-card class="large-card">
      <q-card-section>
        <div class="text-h5 text-center">
          {{ currentStep === 1 ? 'Crear Formulario' : 'Añadir Preguntas y Respuestas' }}
        </div>
      </q-card-section>

      <!-- Paso 1: Información del formulario -->
      <div v-if="currentStep === 1">
        <q-card-section>
          <q-input filled v-model="forms.name.value" label="Nombre del Formulario" />
        </q-card-section>
        <q-card-section>
          <q-input filled v-model="forms.description.value" label="Descripcion del Formulario" />
        </q-card-section>
      </div>

      <!-- Paso 2: Preguntas y respuestas -->
      <div v-else-if="currentStep === 2">
        <q-card-section v-for="(q, index) in currentQuestions" :key="index">
          <q-input
            filled
            v-model="q.question"
            label="Pregunta"
            placeholder="Escribe una pregunta"
          />
          <div class="answers">
            <div
              v-for="(answer, aIndex) in q.answers"
              :key="aIndex"
              class="answer"
            >
              <q-input
                filled
                v-model="q.answers[aIndex]"
                label="Respuesta"
                placeholder="Escribe una respuesta"
              />
            </div>
            <q-btn flat label="Añadir Respuesta" color="primary" @click="addAnswer(index)" />
          </div>
        </q-card-section>
        <q-btn flat label="Añadir Pregunta" color="primary" @click="addQuestion" />

        <!-- Controles de paginación -->
        <div class="pagination">
          <q-btn
            flat
            label="Anterior"
            color="secondary"
            @click="prevPage"
            :disable="currentPage === 1"
          />
          <span>Página {{ currentPage }} de {{ totalPages }}</span>
          <q-btn
            flat
            label="Siguiente"
            color="secondary"
            @click="nextPage"
            :disable="currentPage === totalPages"
          />
        </div>
      </div>

      <!-- Acciones -->
      <q-card-actions>
        <q-btn flat label="Cancelar" color="negative" @click="forms.closeModal" />
        <q-btn
          flat
          label="Anterior"
          color="secondary"
          v-if="currentStep > 1"
          @click="currentStep--"
        />
        <q-btn
          flat
          label="Siguiente"
          color="primary"
          v-if="currentStep === 1"
          @click="currentStep++"
        />
        <q-btn
          flat
          label="Guardar"
          color="positive"
          v-if="currentStep === 2"
          @click="saveFullForm"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<style scoped>
.large-dialog {
  max-width: 80vw;
  max-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.large-card {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.answers {
  margin-top: 10px;
}
.answer {
  margin-bottom: 10px;
}

.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}
</style>
