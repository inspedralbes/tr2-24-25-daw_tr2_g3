<template>
    <h1 class="text-xl font-bold mb-4">Lista de Estudiantes</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 ">
        <div 
            class="p-4 border rounded-lg shadow-md flex items-center max-w-xs transform transition-transform duration-200 hover:scale-105" 
            v-for="student in students" 
            :key="student.id"
            @click="$router.push({ name: 'student', params: { id: student.id } })"
        >
            <img :src="student.image" :alt="student.name" class="w-16 h-16 rounded-full mr-6" />
            <div class="flex flex-col">
                <h6 class="mb-1">{{ student.name }}</h6>
                <div><span class="font-bold">Email:  </span>{{ student.email }}</div>
                <div><span class="font-bold">Tel.:  </span>{{ student.phone }}</div>    
            </div>
        </div>
    </div>
</template>

<script>    

export default {
    name: 'StudentsGrid',
    props: {
        students: {
            type: Array,
            required: true
        },
        nStudents: {
            type: Number,
            required: true
        }
    }
};
</script>