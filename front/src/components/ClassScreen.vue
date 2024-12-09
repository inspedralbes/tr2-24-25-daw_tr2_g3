<script setup>
import {useClassScreen} from "@/composable/components/useClassScreen.js";
const classroom = useClassScreen();

</script>

<template>

  <q-tabs v-model="classroom.tab"@update:model-value="classroom.onTabChange">
      <q-tab name="sociogram" label="Socio grama" />
      <q-tab name="seating" label="Asientos" />
      <q-tab name="list" label="Lista" />
      <q-tab name="history" label="Historial" />
  </q-tabs>

</template>

<style scoped>

</style>
