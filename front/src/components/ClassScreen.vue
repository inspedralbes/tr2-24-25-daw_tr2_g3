<script setup>
import {useClassScreen} from "@/composable/components/useClassScreen.js";
import AssignSiteView from "@/views/AssignSiteView.vue";
import PageTest from "@/views/PageTest.vue";
import StudentListView from "@/views/StudentsListView.vue";
import HistorialStudentsView from "@/views/HistorialStudentsView.vue";
import WizardStudentsView from "@/views/WizardStudentsView.vue";

const classroom = useClassScreen();

const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  wizards: {
    type:Object,
    required:true
  }
})

console.log(props)
</script>

<template>

  <q-tabs @update:model-value="classroom.onTabChange" v-model="classroom.tab.value" class="my-4">
    <q-tab name="test" label="Sociograma"/>
    <q-tab name="assign" label="Asientos"/>
    <q-tab name="list" label="Lista"/>
    <q-tab name="history" label="Historial"/>
    <q-tab name="wizard" label="Formulario"/>
  </q-tabs>


  <div v-if="classroom.tab.value !== null">
    <div v-show="classroom.tab.value === 'test'">
      <PageTest/>
    </div>
    <div v-show="classroom.tab.value === 'assign'">
      <AssignSiteView :dataProps="data"/>
    </div>
    <div v-show="classroom.tab.value === 'list'">
      <StudentListView :dataProps="data"/>
    </div>
    <div v-show="classroom.tab.value === 'history'">
      <HistorialStudentsView/>
    </div>
    <div v-show="classroom.tab.value === 'wizard'">
      <WizardStudentsView :dataProps="wizards"/>
    </div>
  </div>
</template>

<style scoped></style>
