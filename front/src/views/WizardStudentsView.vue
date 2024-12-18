<script setup>
import {useWizardStudentsView} from "@/composable/views/useWizardStudentsView.js";

const wizardStudentsView = useWizardStudentsView();

</script>

<template>
<h4> Formulario</h4>
<!--  Add style for better view and position on the right side of the view -->
  <q-btn class="" color="primary" @click="wizardStudentsView.handleSendEmail()">
    Enviar formulario a los alumnos.
  </q-btn>
</template>

<style scoped>

</style>
