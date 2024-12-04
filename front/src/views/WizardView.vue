<script>
import {useWizardView} from '@/composable/useWizardView.js';

export default {
  setup() {
    // Usamos la lógica del composable
    const {
      showSidebar,
      students,
      responses,
      onDragStart,
      onDrop,
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
      onDragStart,
      onDrop,
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
    <q-drawer v-model="showSidebar" side="right" :width="400" bordered>
      <q-list>
        <q-item-label header class="text-h6 text-center q-mb-lg">
          Llista d'Estudiants
        </q-item-label>
        <div class="row">
          <div class="col-4 text-center q-mb-lg" v-for="student in students" :key="student.id"
               draggable="true" @dragstart="onDragStart(student)">
            <q-avatar size="lg" class="q-mb-sm">
              <img :src="student.image" alt="Foto de Estudiante"/>
            </q-avatar>
            <q-item-label>{{ student.name }}</q-item-label>
          </div>
        </div>
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page class="flex flex-center q-pa-lg-lg">
        <div class="questions-div q-pa-md">
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

            <div>
              <!-- Button to open the modal -->
              <!--              <q-icon-->
              <!--                @click="openModal"-->
              <!--                name="help_outline"-->
              <!--                size="lg"-->
              <!--                color="primary-light"-->
              <!--                class="cursor-pointer group relative"-->
              <!--              />-->
              <button @click="openModal"
                      class="focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <q-icon
                  @click="openModal"
                  name="help_outline"
                  size="lg"
                  color="primary-light"
                  class="cursor-pointer group relative"
                />
              </button>

              <!-- Modal Background -->
              <div v-if="isModalOpen"
                   class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <!-- Modal Content -->
                <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 relative">
                  <!-- Modal Header -->
                  <div class="flex justify-between items-center">
                    <!--                    <h3 class="text-xl font-semibold">Modal Title</h3>-->
                    <button @click="closeModal" class="text-gray-600 hover:text-gray-800 ">
                      <q-icon name="close" size="xs" color="primary-light"/>
                    </button>
                    <p>{{ templateData.questions[2].description }}</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <h3 class="text-center mt-3">{{ templateData.questions[9].question }}</h3>
          <div class="flex flex-center items-center justify-center">
            <div class="row q-gutter-md">
              <div v-for="(response, index) in responses" :key="index"
                   class="response col-12 col-sm-4 col-md-3 text-center flex flex-center"
                   @dragover.prevent @drop="onDrop(index)">
                <div class="flex flex-column items-center">
                  <q-avatar size="lg" v-if="response" class="q-mb-sm">
                    <img :src="response.image" alt="Respuesta"/>
                  </q-avatar>
                  <p v-else class="text-grey q-mb-none">RESPUESTA</p>
                  <q-item-label v-if="response" class="q-mb-none">{{ response.name }}</q-item-label>
                </div>
              </div>
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


.tooltip-arrow-left
  position: absolute
  left: 10px
  // Ajusta esto para controlar la distancia de la flecha desde el borde izquierdo
  bottom: -8px
  border-left: 8px solid transparent
  border-right: 8px solid transparent
  border-top: 8px solid transparent
  border-bottom: 8px solid #1e40af
// Color de la flecha, asegúrate de que coincida con el fondo del tooltip

</style>
