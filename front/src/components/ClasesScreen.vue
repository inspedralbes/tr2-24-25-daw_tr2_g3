<script setup>
import {useClasesScreen} from "@/composable/components/useClasesScreen.js";


const props = defineProps({
  clases: {
    type: Object,
    required: true
  },
});
const clases = useClasesScreen(props);
</script>

<template>
  <div class="flex gap-6 p-2">
    <q-input borderless dense class="w-56" v-model="clases.searchName.value" placeholder="Buscar">
        <template v-slot:append>
          <q-icon name="search" class="cursor-pointer" />
        </template>
    </q-input>
    <q-select
      borderless
      class="w-40"
      v-model="clases.seletecdOption.value"
      :options="clases.optionsFilter">
    </q-select>
  </div>
  <div class="flex gap-10">
    <q-card v-for="(clase, index) in clases.getFilteredClasses()" class="card-student">
      <q-card-section>
        <h6>Clase {{clase.curs}} - {{clase.lletra}}</h6>
        <p>{{clase.numAlumnos}} estudiantes</p>
        <p>Any {{clase.year}}</p>
      </q-card-section>
    </q-card>
  </div>
</template>

<style scoped>
.card-student {
  width: 100%;
  max-width: 150px; /* Tamaño máximo para pantallas grandes */
  border-radius: 10%;
}
.card-student:hover{
  transform: scale(1.1); /* Escala y mueve hacia arriba */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Añade sombra para resaltar */
  cursor: pointer;
}
</style>
