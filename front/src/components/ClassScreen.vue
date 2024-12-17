<script setup>
import { useClassScreen } from "@/composable/components/useClassScreen.js";
import AssignSiteView from "@/views/AssignSiteView.vue";
import PageTest from "@/views/PageTest.vue";

const classroom = useClassScreen();
</script>

<template>
  <q-tabs v-model="classroom.tab.value" @update:model-value="classroom.onTabChange">
    <q-tab name="test" label="Sociograma" />
    <q-tab name="assign" label="Asientos" />
    <!--    <q-tab name="list" label="Lista" />-->
    <!--    <q-tab name="history" label="Historial" />-->
  </q-tabs>


  <div v-if="classroom.tab.value !== null">
    Actual tab {{ classroom.tab.value }}
    <div v-show="classroom.tab.value === 'test'"><PageTest :key="0"/></div>
    <div v-show="classroom.tab.value === 'assign'"><AssignSiteView :key="1"/></div>
    <!--    <div v-show="classroom.tab === 'list'">Contenido de Lista</div>-->
    <!--    <div v-show="classroom.tab === 'history'">Contenido de Historial</div>-->
  </div>
</template>

<style scoped></style>
