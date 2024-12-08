<script setup>
import useWizardView from "@/composable/useWizardView.js";

const wizardView = useWizardView()
</script>

<template>
  <q-layout>
    <!-- Sidebar -->
    <q-drawer v-model="wizardView.showSidebar.value" side="right" :width="400" bordered @dragover.prevent
              @drop="wizardView.onDropReturn()"
              class="bg-[#4B5361]">
      <q-list>
        <h6 class="header-sidebar text-center q-mb-lg mt-4 border-b">
          Llista d'Estudiants
        </h6>
        <div class="row">
          <div class="col-4 text-center q-mb-lg" v-for="student in wizardView.students.value" :key="student.id"
               draggable="true"
               @dragstart="wizardView.onDragStart(student)"
              @click="wizardView.selectStudent(student)">
            <q-avatar size="lg" class="q-mb-sm">
              <img :src="student.image" alt="Student image"/>
            </q-avatar>
            <p class="p-sidebar">{{ student.name }}</p>
          </div>
        </div>
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page class="flex flex-center q-pa-lg-lg">
        <div class="questions-div absolute q-pa-md">
          <q-icon name="help_outline" size="lg" color="primary-light" label="Rotate">
            <q-tooltip class="text-body2 bg-blue text-cian shadow-4" anchor="center right" self="center left"
                       transition-show="scale"
                       transition-hide="scale">
              {{
                wizardView.templateData.questions[wizardView.currentQuestionIndex.value]?.description || "Carregant descripció..."
              }}
            </q-tooltip>
          </q-icon>

          <!-- Question and progress bar -->
          <div class="mt-10">
            <div>
              <div class="flex items-center w-[90%] bg-gray-200 rounded-full mb-3 mx-auto">
                <div class="bg-blue-500 h-4 rounded-full"
                     :style="{ width: wizardView.calculateProgress() + '%' }"></div>
              </div>
              <h4 class="text-center mt-4">{{
                  wizardView.templateData.questions[wizardView.currentQuestionIndex.value]?.question || "Carregant pregunta..."
                }}</h4>
            </div>

            <div class="flex flex-center items-center justify-center my-9">
              <div class="row q-gutter-md">
                <div v-for="(response, index) in wizardView.responses.value" :key="index"
                     class="response text-center flex flex-center"
                     @dragover.prevent @drop="wizardView.onDrop(index)">
                  <div
                    class="flex flex-col items-center" draggable="true"
                    @dragstart="wizardView.onDragStart(response)"
                    :draggable="!wizardView.isStudentAssigned(student)"
                    @click="wizardView.dropStudent(index)"
                    :class="{ 'cell-busy': response }">
                    <q-avatar size="lg" v-if="response" class="q-mb-sm" @click.stop="wizardView.returnStudent(index)">
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
              <button @click="wizardView.previousQuestion()" class="bg-blue-500 text-white py-2 px-4 rounded">
                Anterior Pregunta
              </button>
              <button @click="wizardView.nextQuestion()" class="bg-blue-500 text-white py-2 px-4 rounded">
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
  border: 1px solid $info-dark-medium
  background-color: $tertiary-light
  border-radius: 10px
  color: $primary-light
  width: 800px
  height: 500px
  filter: drop-shadow(0 0 5px rgba(166, 228, 241, 1.0))

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
  background-color: $tertiary-light

.header-sidebar
  color: $primary-light
  border-bottom-color: $primary-light


.p-sidebar
  color: $primary-light

</style>
