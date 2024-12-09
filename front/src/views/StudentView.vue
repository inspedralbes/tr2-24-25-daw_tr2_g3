<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import LayoutMain from '@/layout/LayoutMain.vue';

const route = useRoute();
const router = useRouter();
const studentId = route.params.id;

const student = ref({});

onMounted(() => {
  // Mock student data for testing
  student.value = {
    id: studentId,
    tutor: 'John Doe',
    name: 'Jane',
    surname: 'Smith',
    birthDate: '2005-06-15',
    grade: '10',
    group: 'A',
    gender: 'Female',
    socialSecurity: '123-45-6789',
    nationality: 'American',
    address: '123 Main St',
    postalCode: '12345',
    city: 'Anytown',
    province: 'Anystate',
    country: 'USA',
    phone: '555-1234',
    email: 'jane.smith@example.com',
    dni: 'A12345678',
    image: 'https://via.placeholder.com/150',
    observations: 'No observations',
    enrollmentDate: '2020-09-01'
  };
});

const goBack = () => {
  router.back();
};
</script>

<template>
    <LayoutMain>
        <template #title>
            <div class="flex justify-between items-center">
                <div class="flex flex-row items-center">
                    <div class="flex flex-col items-center mr-4">
                        <img :src="student.image" :alt="student.name" class="w-32 h-32 rounded-full" />
                        <span class="text-xl font-semibold">{{ student.grade }} - {{ student.group }}</span> 
                    </div>
                    <div class="text-3xl font-bold">{{ student.name }} {{ student.surname }}</div>
                </div>
                <div>
                    <button @click="goBack" class="bg-cyan-400 text-white px-4 py-2 rounded-lg shadow-md mr-4">
                        Volver
                    </button>
                </div>
            </div>
        </template>
        <template #subtitle>
            <button class="bg-yellow-400 text-white px-4 py-2 rounded-lg shadow-md">
                <i class="bi bi-pencil"></i> Editar
            </button>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border p-4 rounded-lg shadow-md bg-white">
                <div class="font-bold text-xl mb-2"><i class="bi bi-person"></i> Información Personal</div>
                <div><span class="font-bold">Fecha de Nacimiento: </span>{{ student.birthDate }}</div>
                <div><span class="font-bold">Género: </span>{{ student.gender }}</div>
                <div><span class="font-bold">Seguridad Social: </span>{{ student.socialSecurity }}</div>
                <div><span class="font-bold">Nacionalidad: </span>{{ student.nationality }}</div>
                <div><span class="font-bold">DNI: </span>{{ student.dni }}</div>
            </div>
            <div class="border p-4 rounded-lg shadow-md bg-white">
                <div class="font-bold text-xl mb-2"><i class="bi bi-mortarboard"></i> Información Académica</div>
                <div><span class="font-bold">Tutor: </span>{{ student.tutor }}</div>
                <div><span class="font-bold">Fecha de Matrícula: </span>{{ student.enrollmentDate }}</div>
                <div><span class="font-bold">Grado: </span>{{ student.grade }}</div>
                <div><span class="font-bold">Grupo: </span>{{ student.group }}</div>
            </div>
            <div class="border p-4 rounded-lg shadow-md bg-white">
                <div class="font-bold text-xl mb-2"><i class="bi bi-telephone"></i> Información de Contacto</div>
                <div><span class="font-bold">Dirección: </span>{{ student.address }}</div>
                <div><span class="font-bold">Código Postal: </span>{{ student.postalCode }}</div>
                <div><span class="font-bold">Ciudad: </span>{{ student.city }}</div>
                <div><span class="font-bold">Provincia: </span>{{ student.province }}</div>
                <div><span class="font-bold">País: </span>{{ student.country }}</div>
                <div><span class="font-bold">Teléfono: </span>{{ student.phone }}</div>
                <div><span class="font-bold">Email: </span>{{ student.email }}</div>
            </div>
        </div>
        <div class="p-4 border rounded-lg shadow-md bg-white mt-4">
            <div class="font-bold text-xl mb-2"><i class="bi bi-sticky"></i> Observaciones</div>
            <div>{{ student.observations }}</div>
        </div>
    </LayoutMain>
</template>

<style scoped>
</style>