<script setup>
import ClassScreen from "@/components/ClassScreen.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useClassView} from "@/composable/views/useClassView.js";

const classV = useClassView();

// import { useRoute } from 'vue-router';

// const route = useRoute();

// Accedemos a los datos pasados mediante `state`
// const classInfo = route.query.data ? JSON.parse(route.query.data) : { name: 'Clase no encontrada' };

</script>

<template>
  <LayoutMain>

<!--    {{classInfo}}-->

    <template #title>
      Clase
    </template>

    <template #icon>
      <q-icon name="home" size="27px" class="q-mr-xs"/>
    </template>

    <template #subtitle>
      {{classV.dataGroup[0]}}
<!--      {{classInfo.course}} - {{classInfo.letter.toUpperCase()}}-->
    </template>

    <template #buttons>
<!--      cambiar el codigo por el que esta almacenado en el array del front-->
      <q-input outlined class="w-20" v-model="classV.code.value" :dense="classV.dense" disable/>

      <!-- Campo de archivo oculto -->
      <input
        type="file"
        ref="fileInput"
        accept=".xlsx, .xls"

        @change="classV.handleFileUpload"
      />

      <q-btn color="primary"
             :disable="!classV.selectedFile.value"
             @click="classV.uploadFile">Importar
      </q-btn>
    </template>
    <ClassScreen />

  </LayoutMain>

</template>

<style scoped>

</style>
