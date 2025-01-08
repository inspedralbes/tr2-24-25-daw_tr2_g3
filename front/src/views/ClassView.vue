<script setup>
import ClassScreen from "@/components/ClassScreen.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useClassView} from "@/composable/views/useClassView.js";
const classV = useClassView();
</script>

<template>
  <LayoutMain>

    <template #title>
      Clase
    </template>

    <template #icon>
      <q-icon name="home" size="27px" class="q-mr-xs"/>
    </template>

    <template #subtitle>
      1 -A
    </template>

    <template #buttons>
      <q-input outlined class="w-20" v-model="classV.code.value" :dense="classV.dense" disable />

      <!-- Campo de archivo oculto -->
      <input
        type="file"
        ref="fileInput"
        accept=".xlsx, .xls"

        @change="classV.handleFileUpload"
      />

      <q-btn color="primary"
             :disable="!classV.selectedFile.value"
             @click="classV.uploadFile" >Importar</q-btn>
    </template>
      <ClassScreen/>

  </LayoutMain>

</template>

<style scoped>

</style>
