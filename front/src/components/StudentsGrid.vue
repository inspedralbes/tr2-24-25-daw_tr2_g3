<template>
<!--  <h1 class="text-xl font-bold mb-4">Lista de Estudiantes</h1>-->
<!--  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 ">-->
<!--    <div-->
<!--      class="p-4 border rounded-lg shadow-md flex items-center max-w-xs transform transition-transform duration-200 hover:scale-105"-->
<!--      v-for="student in student.students"-->
<!--      :key="student.id"-->
<!--      @click="$router.push({ name: 'student', params: { id: student.id, teacherId: studentGrid.teacherId} })"-->
<!--    >-->
<!--      <img :src="student.image" :alt="student.name" class="w-16 h-16 rounded-full mr-6"/>-->
<!--      <div class="flex flex-col">-->
<!--        <h6 class="line-clamp-1 break-all w-[170px] mb-1">{{ student.name }} {{ student.lastname }}</h6>-->
<!--        <div class="line-clamp-1 break-all w-[170px]"><span class="font-bold">Email:  </span>{{ student.email }}</div>-->
<!--        <div class="line-clamp-1 break-all w-[170px]"><span class="font-bold">{{-->
<!--            student.type_document.toUpperCase()-->
<!--          }}:</span> {{ student.id_document }}-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->

  {{props.students}}
  <h1 class="text-xl font-bold mb-4">Lista de Estudiantes</h1>

  <div class="flex gap-10">
    <q-card v-for="(student, index) in studentGrid.students.data" class="card-student"
            @click="studentGrid.infoCard(student.id)">
      <q-card-section>
        <img src="https://cdn-icons-png.flaticon.com/512/4792/4792929.png" :alt="student.name"
             class="w-16 h-16 rounded-full mr-6"/>

        <h6 class="line-clamp-1 break-all w-[170px] mb-3">{{ student.name }} {{ student.lastname }}</h6>

        <div class="mb-3">
          <span class="font-bold">Email: </span>
          <span>{{ student.email }}</span>
        </div>

        <div>
          <span class="font-bold uppercase">{{ student.type_document }}: </span>
          <span>{{ student.id_document }}</span>
        </div>

      </q-card-section>
    </q-card>
  </div>

</template>

<script setup>
import {useStudentGrid} from "@/composable/components/useStudentGrid.js";

const props = defineProps({
  students: {
    type: Object,
    required: true
  },
  nStudents: {
    type: Number,
    required: true
  },
});

const studentGrid = useStudentGrid(props);
</script>


<style scoped>
.card-student {
  width: 100%;
  max-width: 250px; /* Tamaño máximo para pantallas grandes */
  border-radius: 5%;
}

.card-student:hover {
  transform: scale(1.1); /* Escala y mueve hacia arriba */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Añade sombra para resaltar */
  cursor: pointer;
}
</style>
