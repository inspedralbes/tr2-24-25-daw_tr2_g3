<script setup>
import ClassScreen from "@/components/ClassScreen.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import {useClassView} from "@/composable/views/useClassView.js";

const classV = useClassView();

</script>

<template >
  <LayoutMain>

      <template #title>
        Clase
      </template>

    <template #icon>
      <q-icon name="home" size="27px" class="q-mr-xs"/>
    </template>

    <template #subtitle>
        <span v-if="classV.dataGroup.length > 0">{{ classV.dataGroup[0].course }} - {{ classV.dataGroup[0].letter.toUpperCase()}} </span>
    </template>

    <template #buttons>
      <input
        v-if="classV.dataGroup.length > 0"
        type="text"
        class="w-[100px] p-1 text-center"
        v-model="classV.dataGroup[0].code"
        :disabled="true"
      />

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
    <ClassScreen v-if="classV.dataGroup.length > 0" :data="classV.dataGroup[0].members"/>

  </LayoutMain>

</template>

<style scoped>

</style>
