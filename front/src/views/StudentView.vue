<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import LayoutMain from '@/layout/LayoutMain.vue';
import BreadCrumbs from '@/components/BreadCrumbs.vue';

const route = useRoute();
const router = useRouter();
const studentId = route.params.id;

const student = ref({});
const originalStudent = ref({});

onMounted(() => {
    //Fetch a la bd para obtener la información del estudiante

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

const editingSection = ref(null);

const editSection = (section) => {
  if (editingSection.value === section) {
    student.value = { ...originalStudent.value }; // Discard changes
    editingSection.value = null;
  } else {
    originalStudent.value = { ...student.value }; // Save original data
    editingSection.value = section;
  }
};

const saveSection = () => {
  // Logic to save the edited information
  editingSection.value = null;

  //Fetch a la base de datos para guardar los cambios
};

const crumbs = [
    { text: 'Home', href: '/', icon: 'bi bi-house-fill' },
    { text: 'Estudiants', href: '/students', icon:''},
    { text: 'Estudiant', href: `/students/${studentId}` }
];
</script>

<template>
    <LayoutMain>
        <template #breadcrumbs>
            <BreadCrumbs :crumbs=crumbs />
        </template>

        <template #title>
            <div class="flex justify-between items-center">
                <div class="flex flex-row items-center">
                    <div class="flex flex-row items-center mr-4">
                        <img :src="student.image" :alt="student.name" class="w-32 h-32 rounded-full" />
                        <div class="flex flex-col ml-4">
                            <div class="text-3xl font-bold">{{ student.name }} {{ student.surname }}</div>
                            <span class="text-xl font-semibold">{{ student.grade }} - {{ student.group }}</span> 
                        </div>
                    </div>
                </div>
            </div>
        </template>
            

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border p-8 rounded-lg shadow-md bg-white relative">
                <button @click="editSection('personal')" class="edit-button absolute top-4 right-4 bg-cyan-400 text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
                    <i class="bi bi-pencil"></i>
                </button>
                <div class="font-bold text-3xl mb-6"><i class="bi bi-person mr-4"></i>Información Personal</div>
                <div v-if="editingSection === 'personal'">
                    <div class="text-lg leading-loose"><span class="font-bold">Fecha de Nacimiento: </span><input v-model="student.birthDate" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Género: </span><input v-model="student.gender" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Seguridad Social: </span><input v-model="student.socialSecurity" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Nacionalidad: </span><input v-model="student.nationality" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">DNI: </span><input v-model="student.dni" class="editable-input" /></div>
                    <button @click="saveSection" class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">Guardar</button>
                </div>
                <div v-else>
                    <div class="text-lg leading-loose"><span class="font-bold">Fecha de Nacimiento: </span>{{ student.birthDate }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Género: </span>{{ student.gender }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Seguridad Social: </span>{{ student.socialSecurity }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Nacionalidad: </span>{{ student.nationality }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">DNI: </span>{{ student.dni }}</div>
                </div>
            </div>
            <div class="border p-8 rounded-lg shadow-md bg-white relative">
                <button @click="editSection('academic')" class="edit-button absolute top-4 right-4 bg-cyan-400 text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
                    <i class="bi bi-pencil"></i>
                </button>
                <div class="font-bold text-3xl mb-6"><i class="bi bi-mortarboard"></i> Información Académica</div>
                <div v-if="editingSection === 'academic'">
                    <div class="text-lg leading-loose"><span class="font-bold">Tutor: </span><input v-model="student.tutor" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Fecha de Matrícula: </span><input v-model="student.enrollmentDate" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Grado: </span><input v-model="student.grade" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Grupo: </span><input v-model="student.group" class="editable-input" /></div>
                    <button @click="saveSection" class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">Guardar</button>
                </div>
                <div v-else>
                    <div class="text-lg leading-loose"><span class="font-bold">Tutor: </span>{{ student.tutor }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Fecha de Matrícula: </span>{{ student.enrollmentDate }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Grado: </span>{{ student.grade }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Grupo: </span>{{ student.group }}</div>
                </div>
            </div>
            <div class="border p-8 rounded-lg shadow-md bg-white relative">
                <button @click="editSection('contact')" class="edit-button absolute top-4 right-4 bg-cyan-400 text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
                    <i class="bi bi-pencil"></i>
                </button>
                <div class="font-bold text-3xl mb-6"><i class="bi bi-telephone"></i> Información de Contacto</div>
                <div v-if="editingSection === 'contact'">
                    <div class="text-lg leading-loose"><span class="font-bold">Dirección: </span><input v-model="student.address" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Código Postal: </span><input v-model="student.postalCode" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Ciudad: </span><input v-model="student.city" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Provincia: </span><input v-model="student.province" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Teléfono: </span><input v-model="student.phone" class="editable-input" /></div>
                    <div class="text-lg leading-loose"><span class="font-bold">Email: </span><input v-model="student.email" class="editable-input" /></div>
                    <div class="h-[40px]"></div>
                    <button @click="saveSection" class="save-button bg-green-400 text-white px-4 py-2 rounded-full shadow-md mt-2">Guardar</button>
                </div>
                <div v-else>
                    <div class="text-lg leading-loose"><span class="font-bold">Dirección: </span>{{ student.address }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Código Postal: </span>{{ student.postalCode }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Ciudad: </span>{{ student.city }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Provincia: </span>{{ student.province }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Teléfono: </span>{{ student.phone }}</div>
                    <div class="text-lg leading-loose"><span class="font-bold">Email: </span>{{ student.email }}</div>
                    <div class="h-[40px]"></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="p-8 border rounded-lg shadow-md bg-white relative">
                <button @click="editSection('observations')" class="edit-button absolute top-4 right-4 bg-cyan-400 text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
                    <i class="bi bi-pencil"></i>
                </button>
                <div class="font-bold text-xl mb-2"><i class="bi bi-sticky"></i> Observaciones</div>
                <div v-if="editingSection === 'observations'">
                    <textarea v-model="student.observations" class="w-full text-lg editable-input"></textarea>
                    <button @click="saveSection" class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">Guardar</button>
                </div>
                <div v-else class="text-lg">
                    {{ student.observations }}
                    <button @click="saveSection" class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2" style="visibility: hidden;">Guardar</button>
                </div>
            </div>
            <div class="p-8 border rounded-lg shadow-md bg-white">
                <div class="font-bold text-xl mb-2"><i class="bi bi-bar-chart"></i> Gráfico</div>
                <!-- Aquí va el gráfico -->
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">El grafico de mi pana</span>
                </div>
            </div>
        </div>
    </LayoutMain>
</template>

<style scoped>
.save-button {
    position: absolute;
    bottom: 16px;
    left: 32px;
}

.edit-button {
    transition: background-color 0.3s;
}

.edit-button:hover {
    background-color: #007BFF;
}

.editable-input {
    line-height:10px;
    margin-left: 5px;
    border: 1px solid black;   
    border-radius: 5px;
}
</style>