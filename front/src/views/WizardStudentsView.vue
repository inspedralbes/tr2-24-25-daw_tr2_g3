<script setup>
import {useWizardStudentsView} from "@/composable/views/useWizardStudentsView.js";
import VueGoodTable from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'

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

  <div class="modal-overlay" v-if="wizardStudentsView.showModal.value">
    <div class="modal">
      <div class="modal-header">
        <h2>Información del formulario</h2>
        <button @click="wizardStudentsView.showModal.value = false">X</button>
      </div>
      <div class="modal-body">
        <vue-good-table :columns="columns" :rows="wizards" />

        <p>Contenido del modal. Puedes poner cualquier información aquí.</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro y transparente */
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal {
  background-color: #fff;
  width: 80%;  /* El modal ocupa el 80% del ancho de la pantalla */
  height: 80%; /* El modal ocupa el 80% de la altura de la pantalla */
  border-radius: 8px;
  padding: 20px;
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.modal-header h2 {
  margin: 0;
}

.modal-header button {
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
}

.modal-body {
  flex-grow: 1;
  overflow-y: auto; /* Hace que el contenido dentro del modal sea desplazable si es necesario */
}
</style>
