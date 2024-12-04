<script>
import { useWizardView } from '@/composable/useWizardView.js';

export default {

  setup() {
    // Usamos la lógica del composable
    const {
      students,
      responses,
      currentQuestionIndex,
      onDragStart,
      onDrop,
      onDropReturn,
      calculateProgress,
      nextQuestion,
      templateData,
    } = useWizardView();

    return {
      students,
      responses,
      currentQuestionIndex,
      onDragStart,
      onDrop,
      onDropReturn,
      calculateProgress,
      nextQuestion,
      templateData,
    };
  },
};
</script>

<template>
  <q-layout>
    <!-- Sidebar -->
    <q-drawer side="right" :width="400" bordered @dragover.prevent @drop="onDropReturn()">
      <q-list>
        <q-item-label header class="text-h6 text-center q-mb-lg">
          Llista d'Estudiants
        </q-item-label>
        <div class="row">
          <div class="col-4 text-center q-mb-lg" v-for="student in students" :key="student.id" draggable="true"
            @dragstart="onDragStart(student)">
            <q-avatar size="lg" class="q-mb-sm">
              <img :src="student.image" alt="Foto de Estudiante" />
            </q-avatar>
            <q-item-label>{{ student.name }}</q-item-label>
          </div>
        </div>
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page class="flex flex-center q-pa-lg-lg">
        <!-- Contenedor centrado -->
        <div class="questions-div q-pa-md">
          <!-- Título centrado -->
          <q-icon name="help_outline" size="lg" color="primary" class="q-icon">
            <q-tooltip>
              {{ templateData.questions[9].description }}
            </q-tooltip>
          </q-icon>

          <div>
            <h4 class="text-center q-mb-md">Pregunta {{ currentQuestionIndex + 1 }}</h4>
            <div class="w-full bg-gray-200 rounded-full h-4">
              <div class="bg-blue-500 h-4 rounded-full" :style="{ width: calculateProgress() + '%' }"></div>
            </div>
          </div>

          <h3 class="text-center">{{ templateData.questions[9].question }}
          </h3>
          <div class="flex flex-center items-center justify-center">
            <div class="row q-gutter-md">
              <div v-for="(response, index) in responses" :key="index"
                class="response col-12 col-sm-4 col-md-3 text-center flex flex-center" @dragover.prevent
                @drop="onDrop(index)">
                <div class="flex flex-col items-center" draggable="true" @dragstart="onDragStart(response)">
                  <q-avatar size="lg" v-if="response" class="q-mb-sm">
                    <img :src="response.image" alt="Respuesta" />
                  </q-avatar>
                  <p v-else class="text-grey q-mb-none">RESPUESTA</p>
                  <q-item-label v-if="response" class="q-mb-none">{{ response.name }}</q-item-label>
                </div>
              </div>
            </div>
          </div>

          <!-- Botón para avanzar a la siguiente pregunta -->
          <button @click="nextQuestion()" class="bg-blue-500 text-white py-2 px-4 rounded">
            Siguiente Pregunta
          </button>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<style lang="sass" scoped>
.questions-div
  align-items: center
  border: 1px solid #ccc
  background-color: $tertiary-light
  border-radius: 10px
  color: $primary-light
  height: auto
  max-height: 80vh

.response
  border: 2px dashed #ccc
  min-height: 150px
  padding: 20px
  background-color: #fff
  border-radius: 8px

.q-icon
  float: right
</style>
