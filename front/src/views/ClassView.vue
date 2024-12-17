<script setup>
import ClassScreen from "@/components/ClassScreen.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useClassView} from "@/composable/views/useClassView.js";

const classV = useClassView();
</script>

<template>
  <!-- Mostrar siempre LayoutMain -->
  <LayoutMain>

    <template #title>
      Clase
    </template>

    <template #icon>
      <q-icon name="home" size="27px" class="q-mr-xs"/>
    </template>

    <!-- Mostrar datos de la clase solo si hay estudiantes -->
    <template #subtitle>
      <span v-if="classV.dataGroup.length > 0">
        {{ classV.dataGroup[0].course }} - {{ classV.dataGroup[0].letter.toUpperCase() }}
      </span>
      <span class="text-red" v-else>No hay estudiantes dados de alta</span>
    </template>

    <template #buttons>
      <!-- Mostrar botón de importar y archivo en ambos casos -->
      <input
        type="file"
        ref="fileInput"
        accept=".xlsx, .xls"
        @change="classV.handleFileUpload"
      />

      <q-btn color="primary"
             :disable="!classV.selectedFile.value"
             @click="classV.uploadFile">
        Importar
      </q-btn>

      <!-- Mostrar el campo de código solo si hay estudiantes -->
      <input
        v-if="classV.dataGroup.length > 0"
        type="text"
        class="w-[100px] p-1 text-center"
        v-model="classV.dataGroup[0].code"
        :disabled="true"
      />
    </template>

    <!-- Mostrar el componente ClassScreen solo si hay estudiantes -->
    <ClassScreen v-if="classV.dataGroup.length > 0" :data="classV.dataGroup[0].members"/>
  </LayoutMain>
</template>

<style scoped>
</style>
