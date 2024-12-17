<script setup>
import AssignSite from "@/components/AssignSite.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useAssignView} from "@/composable/views/useAssignView.js";

const assignView = useAssignView();
</script>

<template>

  <!-- Ícono -->
  <q-icon name="groups" size="md" class="q-mr-xs"></q-icon>

  {{ assignView.counter }} students

  <q-btn icon="compare_arrows" color="info">Aleatorio</q-btn>
  <q-btn icon="save" color="positive" @click="assignView.saveSeats()">Guardar</q-btn>

  <AssignSite @counter="assignView.updateCounter" @save-seats="assignView.updateSeats"/>

</template>

<style scoped>

</style>
