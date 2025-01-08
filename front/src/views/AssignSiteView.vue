<script setup>
import AssignSite from "@/components/AssignSite.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useAssignView} from "@/composable/views/useAssignView.js";

const assignView = useAssignView();
</script>

<template>
  <LayoutMain>
    <!-- Título -->
    <template #title>
      Class 2 - A
    </template>

    <!-- Ícono -->
    <template #icon>
      <q-icon name="groups" size="md" class="q-mr-xs"></q-icon>
    </template>

    <!-- Subtítulo -->
    <template #subtitle>
      {{assignView.counter}} students
    </template>

    <template #buttons>

      <q-btn icon="compare_arrows" color="info">Aleatorio</q-btn>
      <q-btn icon="save" color="positive" @click="assignView.saveSeats()">Guardar</q-btn>

    </template>
    <!-- Contenidor principal -->
      <AssignSite @counter="assignView.updateCounter" @save-seats="assignView.updateSeats" />

  </LayoutMain>
</template>

<style scoped>

</style>
