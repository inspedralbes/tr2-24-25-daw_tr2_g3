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
  <div>

  </div>
  <div class="flex gap-10">
    <q-card v-for="(clase, index) in clases.clases.data" class="card-student">
      <q-card-section>
        <p>Clase {{clase.name}}</p>
        <p>{{clase.numAlumnos}} estudiantes</p>
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
</style>
