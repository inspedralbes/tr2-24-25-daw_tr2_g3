<!-- <script setup>
import { useWizardView} from "@/composable/useWizardView.js";

const wizardView = useWizardView()
</script>

<template>
    <div>HOLAAAAA</div>
</template>

<style scoped>

</style> -->

<template>
    <q-layout>
        <!-- Sidebar -->
        <q-drawer v-model="showSidebar" side="right" :width="400" bordered>
            <q-list>
                <q-item-label header class="text-h6 text-center q-mb-lg">
                    Lista de Estudiantes
                </q-item-label>

                <div class="row">
                    <div class="col-4 text-center q-mb-lg" v-for="student in students" :key="student.id"
                        draggable="true" @dragstart="onDragStart(student)">
                        <q-avatar size="lg" class="q-mb-sm">
                            <img :src="student.image" alt="Foto de Estudiante" />
                        </q-avatar>
                        <q-item-label>{{ student.name }}</q-item-label>
                    </div>
                </div>
            </q-list>
        </q-drawer>

        <!-- Prueba para respuestas -->
        <q-page-container>
            <q-page class="q-pa-md">
                <div>
                    <h4 class="text-center q-mb-md">Pregunta</h4>
                    <div class="row">
                        <div v-for="(response, index) in responses" :key="index"
                            class="col-4 text-center flex flex-center" @dragover.prevent @drop="onDrop(index)"
                            style="border: 2px dashed #ccc; min-height: 150px; padding: 10px;">
                            <div class="column items-center">
                                <q-avatar size="lg" v-if="response" class="q-mb-sm">
                                    <img :src="response.image" alt="Respuesta" />
                                </q-avatar>
                                <q-item-label v-if="response" class="q-mb-none">{{ response.name }}</q-item-label>
                                <p v-else class="text-grey q-mb-none">RESPUESTA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<script>
import { useWizardView } from '@/composable/useWizardView.js';

export default {
    setup() {
        // Usamos la lógica del composable
        const {
            showSidebar,
            students,
            responses,
            onDragStart,
            onDrop,
        } = useWizardView();

        return {
            showSidebar,
            students,
            responses,
            onDragStart,
            onDrop,
        };
    },
};
</script>

<style scoped>
.q-stepper {
    max-width: 600px;
    margin: auto;
}

.column-items {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 0;
}
</style>
