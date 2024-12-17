<script setup>
import {useClassScreen} from "@/composable/components/useClassScreen.js";
import AssignSiteView from "@/views/AssignSiteView.vue";
import PageTest from "@/views/PageTest.vue";
import StudentListView from "@/views/StudentsListView.vue";

const classroom = useClassScreen();

const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})

</script>

<template>

  <q-tabs  @update:model-value="classroom.onTabChange" v-model="classroom.tab.value" class="my-4">
    <q-tab name="test" label="Sociograma"/>
    <q-tab name="assign" label="Asientos"/>
    <q-tab name="list" label="Lista"/>
    <!--    <q-tab name="history" label="Historial" />-->
  </q-tabs>


  <div v-if="classroom.tab.value !== null">
    <div v-show="classroom.tab.value === 'test'">
      <PageTest/>
    </div>
    <div v-show="classroom.tab.value === 'assign'">
      <AssignSiteView :dataProps="props.data"/>
    </div>
    <div v-show="classroom.tab.value === 'list'">
      <StudentListView :dataProps="props.data"/>
    </div>
    <!--    <div v-show="classroom.tab.vale === 'history'">Contenido de Historial</div>-->
  </div>
</template>

<style scoped></style>
