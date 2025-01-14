<script setup>
import LayoutMain from "@/layout/LayoutMain.vue";
import ClasesScreen from "@/components/ClasesScreen.vue";
import {useClasesView} from "@/composable/views/useClasesView.js";
const clase = useClasesView();
</script>

<template>
  <LayoutMain>
    <template #title>
      Mis clases
    </template>

    <template #icon>
      <i class="bi bi-mortarboard"></i>
    </template>
    <template #subtitle>
      Configuración de las clases
    </template>

    <template #buttons>
      <q-btn color="primary" @click="clase.openModal()">Crear clase</q-btn>
    </template>

    <div>
      <ClasesScreen @getIdGroup="clase.getIdGrupEmit" :clases="clase.clases"/>
    </div>

  </LayoutMain>


  <q-dialog v-model="clase.modal.value" persistent>
    <q-card style="min-width: 350px">

      <q-card-section class="q-gutter-md">
        <div class="flex gap-6">
          <div class="">
            <h6>Curs</h6>
            <q-input dense v-model="clase.className.value" autofocus/>
          </div>

          <div class="">
            <h6>Lletra</h6>
            <q-input dense v-model="clase.letterOption.value" autofocus/>
          </div>
        </div>

      </q-card-section>

      <q-card-actions align="right" class="text-primary">
        <q-btn flat label="Cancel" @click="clase.closeModal"/>
        <q-btn flat label="Aceptar" @click="clase.saveData()"/>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>


<style scoped>

</style>
