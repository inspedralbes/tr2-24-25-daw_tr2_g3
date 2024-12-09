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
        <div class="tooltip-sidebar absolute top-2 ml-1">
          <q-icon name="help_outline" size="lg" color="primary-light" label="Rotate">
            <q-tooltip class="text-body2 bg-blue text-cian shadow-4" anchor="center left" self="center right"
                       transition-show="scale"
                       transition-hide="scale">
              Per respondre les preguntes pots arrossegar al company o seleccionar i polsar en la resposta
            </q-tooltip>
          </q-icon>
        </div>
        <h6 class="header-sidebar text-center q-mb-lg mt-3 border-b pb-1">
          Llista d'Estudiants
        </h6>
        <div class="row">
          <div class="col-4 text-center q-mb-lg cursor-pointer"
               v-for="student in wizardView.students.value"
               :key="student.id"
               draggable="true"
               @dragstart="wizardView.onDragStart(student)"
               @click="wizardView.selectStudent(student)"
               :class="{ 'selected-student': wizardView.selectedStudent.value && wizardView.selectedStudent.value.id === student.id }">

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
          <q-icon name="help_outline" size="lg" label="Rotate">
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
                <!-- Response div -->
                <div v-for="(response, index) in wizardView.responses.value" :key="index"
                     :class="{
         'availableCell': wizardView.selectedStudent.value != null && response == null,
         'cell-busy': response && wizardView.isStudentAssigned(response),
         'deselectedCell': wizardView.selectedStudent.value == null && response == null
          }"
                     class="response text-center flex flex-center"
                     @dragover.prevent @drop="wizardView.onDrop(index)">
                  <div
                    class="flex flex-col items-center" draggable="true"
                    @dragstart="wizardView.onDragStart(response)"
                    :draggable="!wizardView.isStudentAssigned(response)"
                    @click="wizardView.dropStudent(index)">
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
            <div class="absolute-bottom bottom-0 flex flex-center justify-center mt-5 mb-5 gap-96">
              <button @click="wizardView.previousQuestion()"
                      class="bg-blue-500 focus:bg-blue-600 text-white py-2 px-4 rounded">
                Anterior Pregunta
              </button>
              <button
                class="btnSendQuestion bg-blue-500 text-white py-2 px-4 rounded  focus:bg-blue-600"
                :class="{'sendQuestion': wizardView.currentQuestionIndex.value + 1 === wizardView.templateData.questions.length}"
                @click="wizardView.openModalSendQuestion()">
                Envia respostes
              </button>
              <button @click="wizardView.nextQuestion()"
                      class="bg-blue-500  focus:bg-blue-600 text-white py-2 px-4 rounded"
                      :class="{'hiddenBtnNext': wizardView.currentQuestionIndex.value + 1 === wizardView.templateData.questions.length}">
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
  position: relative
  overflow: hidden
  border: 2px dashed #ccc
  min-height: 150px
  padding: 20px
  background-color: #fff
  border-radius: 8px

.tooltip-info
  font-size: 24px

.tooltip-sidebar
  color: $primary-light

.drawer
  background-color: $tertiary-light

.header-sidebar
  color: $primary-light
  border-bottom-color: $primary-light


.p-sidebar
  color: $primary-light

.selected-student
  filter: drop-shadow(0 0 15px $primary-light)

.availableCell
  transition: transform 0.3s ease
  transform: scale(1.1)

.deselectedCell
  transition: transform 0.3s ease
  transform: scale(1)

.btnSendQuestion
  display: none

.sendQuestion
  display: block

.hiddenBtnNext
  display: none

</style>
