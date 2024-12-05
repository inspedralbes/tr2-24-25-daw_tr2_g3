<script>
import {useWizardView} from '@/composable/useWizardView.js';

export default {
  setup() {
    const {
      showSidebar,
      students,
      responses,
      currentQuestionIndex,
      onDragStart,
      onDrop,
      onDropReturn,
      calculateProgress,
      nextQuestion,
      previousQuestion,
      templateData,
      wordCount,
      openModal,
      closeModal,
      isModalOpen,
    } = useWizardView();

    // Retornamos las propiedades necesarias para el template
    return {
      showSidebar,
      students,
      responses,
      currentQuestionIndex,
      onDragStart,
      onDrop,
      onDropReturn,
      calculateProgress,
      nextQuestion,
      previousQuestion,
      templateData,
      wordCount,
      openModal,
      closeModal,
      isModalOpen,
    };
  },
};
</script>


<template>
  <q-layout>
    <!-- Sidebar -->
    <q-drawer v-model="showSidebar" side="right" :width="400" bordered @dragover.prevent @drop="onDropReturn()"
              class="bg-[#4B5361]">
      <q-list>
        <h6 class="header-sidebar text-center q-mb-lg mt-4 border-b">
          Llista d'Estudiants
        </h6>
        <div class="row">
          <div class="col-4 text-center q-mb-lg" v-for="student in students" :key="student.id" draggable="true"
               @dragstart="onDragStart(student)">
            <q-avatar size="lg" class="q-mb-sm">
              <img :src="student.image" alt="Foto de Estudiante"/>
            </q-avatar>
            <p class="p-sidebar">{{ student.name }}</p>
          </div>
        </div>
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page class="flex flex-center q-pa-lg-lg">
        <!-- Contenedor centrado -->
        <div class="questions-div absolute q-pa-md">
          <!-- Título centrado -->
          <q-icon name="help_outline" size="lg" color="primary-light" label="Rotate">
            <q-tooltip class="text-body2 bg-blue text-cian shadow-4" anchor="center right" self="center left" transition-show="scale"
                       transition-hide="scale">
              {{ templateData.questions[currentQuestionIndex].description }}
            </q-tooltip>
          </q-icon>

          <div class="flex">
            <!-- Tooltip -->
            <!--            <div class="group relative">-->
            <!--              <q-icon-->
            <!--                name="help_outline"-->
            <!--                size="lg"-->
            <!--                color="primary-light"-->
            <!--                class="cursor-pointer group relative"-->
            <!--              />-->

            <!--              <div-->
            <!--                id="tooltip-default"-->
            <!--                role="tooltip"-->
            <!--                class="absolute bottom-6 truncate left-0 mb-4 opacity-0 group-hover:opacity-100 px-4 py-2 text-white bg-blue-600 rounded-lg shadow-lg tooltip dark:bg-blue-700 transition-opacity duration-300">-->
            <!--                <p class="mb-0">{{ wordCount().firstPart }}</p>-->
            <!--                <p class="mb-0" v-if="wordCount().secondPart">{{ wordCount().secondPart }}</p>-->
            <!--                <div class="tooltip-arrow-left" data-popper-arrow></div>-->
            <!--              </div>-->
            <!--            </div>-->

            <!--            <div>-->
            <!--              &lt;!&ndash; Button to open the modal &ndash;&gt;-->
            <!--              <button @click="openModal"-->
            <!--                      class="focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">-->
            <!--                <q-icon @click="openModal" name="help_outline" size="lg" color="primary-light"-->
            <!--                        class="cursor-pointer group relative"/>-->
            <!--              </button>-->

            <!--              &lt;!&ndash; Modal Background &ndash;&gt;-->
            <!--              <div v-if="isModalOpen"-->
            <!--                   class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">-->
            <!--                &lt;!&ndash; Modal Content &ndash;&gt;-->
            <!--                <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 relative">-->
            <!--                  <button @click="closeModal" class="text-gray-600 hover:text-gray-800">-->
            <!--                    <q-icon name="close" size="xs" color="primary-light" class="mb-0"/>-->
            <!--                  </button>-->
            <!--                  <div>-->
            <!--                    <p class="mb-0 text-black text-sm">{{-->
            <!--                        templateData.questions[currentQuestionIndex].description-->
            <!--                      }}</p>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->
          </div>

          <!-- Question and progress bar -->
          <div class="mt-10">
            <div>
              <div class="flex items-center w-[90%] bg-gray-200 rounded-full mb-3 mx-auto">
                <div class="bg-blue-500 h-4 rounded-full" :style="{ width: calculateProgress() + '%' }"></div>
              </div>

              <h4 class="text-center mt-4">{{ templateData.questions[currentQuestionIndex].question }}</h4>
            </div>

            <div class="flex flex-center items-center justify-center my-9">
              <div class="row q-gutter-md">
                <div v-for="(response, index) in responses" :key="index" class="response text-center flex flex-center"
                     @dragover.prevent @drop="onDrop(index)">
                  <div class="flex flex-col items-center" draggable="true" @dragstart="onDragStart(response)">
                    <q-avatar size="lg" v-if="response" class="q-mb-sm">
                      <img :src="response.image" alt="Respuesta"/>
                    </q-avatar>
                    <p v-else class="text-grey q-mb-none">RESPOSTA</p>
                    <q-item-label v-if="response" class="q-mb-none">{{ response.name }}</q-item-label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Buttons prev & next-->

            <div class="btn-question absolute-bottom bottom-0 flex flex-center justify-center mt-5 mb-5 gap-96">
              <button @click="previousQuestion()" class="bg-blue-500 text-white py-2 px-4 rounded">
                Anterior Pregunta
              </button>
              <button @click="nextQuestion()" class="bg-blue-500 text-white py-2 px-4 rounded">
                Següent Pregunta
              </button>
            </div>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>


<style lang="sass" scoped>
.questions-div
  align-items: center
  border: 1px solid #ccc
  background-color: $tertiary-light-medium
  border-radius: 10px
  color: $primary-light
  width: 800px
  height: 500px

.response
  border: 2px dashed #ccc
  min-height: 150px
  padding: 20px
  background-color: #fff
  border-radius: 8px

.tooltip-info
  font-size: 24px

.tooltip-arrow-left
  position: absolute
  left: 10px
  bottom: -8px
  border-left: 8px solid transparent
  border-right: 8px solid transparent
  border-top: 8px solid transparent
  border-bottom: 8px solid #1e40af

.drawer
  background-color: $tertiary-light-medium

.header-sidebar
  color: $primary-light
  border-bottom-color: $primary-light


.p-sidebar
  color: $primary-light

</style>
