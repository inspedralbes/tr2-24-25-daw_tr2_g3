<script setup>
import {useAssignSite} from "@/composable/components/useAssignSite.js";

const assignSite = useAssignSite();
</script>
<template>
  <div>
    <q-layout view="lHh lpr lFf" container style="height: 800px">
      <q-header elevated style="background-color: #23272F; padding: 8px;">
        <q-toolbar>
          <q-btn flat round dense icon="menu" class="q-mr-sm"/>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>

          <q-toolbar-title>Quasar Framework</q-toolbar-title>

          <q-btn flat round dense icon="account_circle"/>
        </q-toolbar>
      </q-header>

      <q-page-container>
        <q-page class="q-pa-md">
          <!-- Contenedor de recuadros -->
          <div class="q-mb-lg">
            <div class="cuadrado flex" style="gap: 10px">
              <q-btn draggable="true" @dragstart="assignSite.onDragStart('c1')"
                     :style="{width: assignSite.widhts.widhtS, height: assignSite.heightS, backgroundColor : '#000000'}"></q-btn>

              <q-btn draggable="true" @dragstart="assignSite.onDragStart('c2')"
                     :style="{width: assignSite.widhts.widhtM, height: assignSite.heightS, backgroundColor : '#000000'}"></q-btn>

              <q-btn draggable="true" @dragstart="assignSite.onDragStart('c3')"
                     :style="{width: assignSite.widhts.widhtL, height: assignSite.heightS, backgroundColor : '#000000'}"></q-btn>
            </div>
          </div>

          <!-- Área de dibujo -->
          <div
            class="drawing-area"
            @dragover.prevent
            @drop="assignSite.onDrop"
            style="border: 3px dashed gray; height: 300px; position: relative"
          >
            <span>Arrastra y suelta aquí</span>
            <q-btn v-for="item in assignSite.droppedItems" :key="item.id" draggable="true"
                 @click="assignSite.clickName(item.id)" :style="item.style" class="cuadrado"></q-btn>
          </div>
        </q-page>
      </q-page-container>


      <!--      <q-footer elevated style="background-color: #23272F">-->
      <!--        <q-toolbar>-->
      <!--          <q-toolbar-title>Footer</q-toolbar-title>-->
      <!--        </q-toolbar>-->
      <!--      </q-footer>-->

    </q-layout>
  </div>
</template>
<style scoped>

.drawing-area {
  position: relative;
  display: grid;
  grid-template-columns: repeat(6, 50px); /* Seis columnas de 50px */
  grid-template-rows: repeat(6, 50px); /* Seis filas de 50px */
  grid-gap: 5px; /* Espacio entre las celdas */
  padding: 10px;
}

</style>
