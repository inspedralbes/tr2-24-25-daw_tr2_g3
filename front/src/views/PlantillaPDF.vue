<template>
  <div id="content-pdf" class="container">
    <!-- Información del Estudiante -->
    <div class="student-info" v-for="stu in pdf.student.data">
      <div class="student-photo">
        <img :src="stu.photo_pic" alt="Foto del estudiante" class="rounded-full" />
      </div>
      <div class="student-details">
        <h2 class="text-2xl font-bold">{{ stu.name }} {{ stu.lastname }}</h2>
        <p><strong>Fecha de Nacimiento:</strong> {{ stu.birthdate }}</p>
        <p><strong>Género:</strong> {{ stu.gender }}</p>
        <p><strong>Seguridad Social:</strong> {{ stu.social_security_number }}</p>
        <p><strong>Nacionalidad:</strong> {{ stu.nationality }}</p>
        <p><strong>DNI:</strong> {{ stu.id_document }}</p>
      </div>
    </div>

    <!-- Grupo -->
    <div class="group-info" v-for="grp in pdf.groups.data">
      <h3 class="text-xl font-semibold">Grupo</h3>
      <p><strong>Curso:</strong> {{ grp.course }} - <strong>Letra:</strong> {{ grp.letter }}</p>
      <p><strong>Código:</strong> {{ grp.code }}</p>
    </div>

    <!-- Información de Contacto -->
    <div class="contact-info" v-for="stu in pdf.student.data">
      <h3 class="text-xl font-semibold">Información de Contacto</h3>
      <p><strong>Dirección:</strong> {{ stu.address }}</p>
      <p><strong>Código Postal:</strong> {{ stu.postal_code }}</p>
      <p><strong>Ciudad:</strong> {{ stu.city }}</p>
      <p><strong>Provincia:</strong> {{ stu.province }}</p>
      <p><strong>Teléfono:</strong> {{ stu.phone }}</p>
      <p><strong>Email:</strong> {{ stu.email }}</p>
    </div>

    <!-- Observaciones -->
    <div class="observations">
      <h3 class="text-xl font-semibold">Observaciones</h3>
      <textarea v-model="pdf.student.observations" class="w-full text-lg p-2 border rounded-md"></textarea>
    </div>

    <!-- Sociograma -->
    <div class="sociogram">
      <h3 class="text-xl font-semibold">Sociograma</h3>
      <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
        <span class="text-gray-500">Gráfico del sociograma aquí</span>
      </div>
    </div>

    <!-- Botón de Exportación -->
    <button @click="pdf.exportPDF()" class="btn-export">Exportar a PDF</button>
  </div>
</template>

<script setup>
import { usePlantillaPDF } from "@/composable/views/usePlantillaPDF.js";

const props = defineProps({
  student: {
    type: Object,
    required: true
  },
  group: {
    type: Object,
    required: true
  }
});

const pdf = usePlantillaPDF(props);

</script>

<style scoped>
.container {
  padding: 20px;
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

.student-info {
  display: flex;
  gap: 20px;
}

.student-photo img {
  width: 150px;
  height: 150px;
  object-fit: cover;
}

.student-details {
  flex: 1;
}

.group-info,
.contact-info,
.observations,
.sociogram {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
}

textarea {
  resize: vertical;
}

h3 {
  margin-bottom: 10px;
}

textarea {
  margin-top: 10px;
}

.btn-export {
  margin-top: 20px;
  padding: 10px 15px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-export:hover {
  background-color: #0056b3;
}
</style>
