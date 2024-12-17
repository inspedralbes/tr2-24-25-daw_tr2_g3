<script setup>
import AssignSite from "@/components/AssignSite.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useAssignView} from "@/composable/views/useAssignView.js";

const assignView = useAssignView();
</script>

<template>

  <div class="justify-end w-full">

    <div class="q-pa-md q-gutter-md row items-center justify-between">
      <div class="flex items-center">
        <q-icon name="groups" size="md" class="q-mr-xs"/>
        {{ assignView.counter }} students
      </div>

      <div class="flex items-end">
        <q-btn icon="compare_arrows" color="info" class="q-mr-sm">Aleatorio</q-btn>
        <q-btn icon="save" color="positive" @click="assignView.saveSeats()">Guardar</q-btn>
      </div>
    </div>

  </div>
  <AssignSite @counter="assignView.updateCounter" @save-seats="assignView.updateSeats"/>

</template>

<style scoped>

</style>
