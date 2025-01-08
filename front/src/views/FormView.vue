<script setup>
import FormScreen from '@/components/FormScreen.vue';
import LayoutMain from '@/layout/LayoutMain.vue';
import { useFormScreen } from '@/composable/views/useFormView';

const forms = useFormScreen();
</script>

<template>
<LayoutMain>
  <template #title>
    Forms
  </template>
  <template #subtitle>
    subtitle
  </template>
  <template #icon>
  </template>
  <template #buttons>
    <q-btn @click="forms.openModal">Crear Formulario</q-btn>
  </template>
  <FormScreen />
</LayoutMain>
<q-dialog v-model="forms.isModalOpen.value" persistent>
    <q-card>
      <q-card-section>
        <div class="text-h6">Crear Formulario</div>
      </q-card-section>

      <q-card-section>
        <q-input filled v-model="forms.name" label="Nombre del Formulario" />
      </q-card-section>

      <q-card-section>
        <q-input filled v-model="forms.description" label="Descripcion del Formulario" />
      </q-card-section>

      <q-card-actions>
        <q-btn flat label="Cancelar" color="negative" @click="forms.closeModal" />
        <q-btn flat label="Guardar" color="positive" @click="forms.closeModal" />
      </q-card-actions>
    </q-card>
  </q-dialog>
  <div></div>
</template>

<style scoped>

</style>
