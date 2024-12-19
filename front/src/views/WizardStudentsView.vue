<script setup>
import {useWizardStudentsView} from "@/composable/views/useWizardStudentsView.js";

const props = defineProps({
  dataProps: {
    type: Object,
    required: true
  }
})

const wizardStudentsView = useWizardStudentsView(props.dataProps);

</script>

<template>

  <div class="flex items-center w-full">
    <span class="text-2xl font-bold">Formulario</span>
    <div class="flex justify-center w-full">
      <q-btn color="primary" @click="wizardStudentsView.handleSendEmail()">
        Enviar formulario a los alumnos.
      </q-btn>
    </div>
  </div>

</template>

<style scoped>

</style>
