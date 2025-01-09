
<template>
  <div id="content-pdf" class="container">
    <!-- Información del Estudiante -->
    <div class="student-info">
      <div class="student-photo">
        <img :src="pdf.student.photo" alt="Foto del estudiante" class="rounded-full" />
      </div>
      <div class="student-details">
        <h2 class="text-2xl font-bold">{{ pdf.student.name }} {{ pdf.student.lastname }}</h2>
        <p><strong>Fecha de Nacimiento:</strong> {{ pdf.student.birthdate }}</p>
        <p><strong>Género:</strong> {{ pdf.student.gender }}</p>
        <p><strong>Seguridad Social:</strong> {{ pdf.student.social_security_number }}</p>
        <p><strong>Nacionalidad:</strong> {{ pdf.student.nationality }}</p>
        <p><strong>DNI:</strong> {{ pdf.student.id_document }}</p>
      </div>
    </div>

    <!-- Grupo -->
    <div class="group-info">
      <h3 class="text-xl font-semibold">Grupo</h3>
      <p><strong>Curso:</strong> {{ pdf.groups.course }} - <strong>Letra:</strong> {{ pdf.groups.letter }}</p>
      <p><strong>Código:</strong> {{ pdf.groups.code }}</p>
    </div>

    <!-- Información de Contacto -->
    <div class="contact-info">
      <h3 class="text-xl font-semibold">Información de Contacto</h3>
      <p><strong>Dirección:</strong> {{ pdf.student.address }}</p>
      <p><strong>Código Postal:</strong> {{ pdf.student.postal_code }}</p>
      <p><strong>Ciudad:</strong> {{ pdf.student.city }}</p>
      <p><strong>Provincia:</strong> {{ pdf.student.province }}</p>
      <p><strong>Teléfono:</strong> {{ pdf.student.phone }}</p>
      <p><strong>Email:</strong> {{ pdf.student.email }}</p>
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
  </div>
</template>

<script setup>
import {usePlantillaPDF} from "@/composable/views/usePlantillaPDF.js";

const props = defineProps({
  student:{
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
</style>
