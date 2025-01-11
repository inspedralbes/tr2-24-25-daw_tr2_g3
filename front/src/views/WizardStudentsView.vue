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

  <div class=" w-full">
    <h2 class="text-2xl font-bold mb-4">Formulario</h2>
<!--    <div class="flex justify-center w-full">-->
<!--      <q-btn color="primary" @click="wizardStudentsView.handleSendEmail()">-->
<!--        Enviar formulario a los alumnos.-->
<!--      </q-btn>-->
<!--    </div>-->

    <div class="forms-grid">
      <q-card
        v-for="(form, formIndex) in wizardStudentsView.wizards"
        :key="formIndex"
        class="form-card"
        bordered
        flat
      >
        <q-card-section>
          <div class="text-h6 form-title">{{ form.name }}</div>
          <p class="form-description">{{ form.description }}</p>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn
            flat
            color="secondary"
            label="Ver detalles"
            @click="wizardStudentsView.seeDetails(form)"
          />
          <q-btn
            flat
            color="primary"
            label="Iniciar"
            @click="wizardStudentsView.activate(form)"
          />
<!--          <q-btn-->
<!--            flat-->
<!--            color="negative"-->
<!--            icon="delete"-->
<!--            @click="deleteForm(formIndex)"-->
<!--            aria-label="Eliminar formulario"-->
<!--          />-->
<!--          <q-btn-->
<!--            flat-->
<!--            color="primary"-->
<!--            icon="edit"-->
<!--            @click="editForm(formIndex)"-->
<!--            aria-label="Editar formulario"-->
<!--          />-->
        </q-card-actions>
      </q-card>
    </div>

  </div>

</template>

<style scoped>

</style>
