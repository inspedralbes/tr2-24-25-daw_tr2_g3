<script setup>
import { useFormScreen } from '@/composable/components/useFormSreen';
import { ref, computed } from 'vue';

const props = defineProps({
  formsJSON: {
    type: Object,
    required: true
  }
});

// Composables
const {
  forms,
  searchQuery,
  selectedFilter,
  currentPage,
  itemsPerPage,
  editingForm,
  showEditModal,
  showDetailsModal,
  viewingForm,
  filteredForms,
  paginatedForms,
  totalPages,
  changePage,
  deleteForm,
  editForm,
  saveEdit,
  addQuestion,
  deleteQuestion,
  addAnswer,
  deleteAnswer,
  viewDetails,
} = useFormScreen(props);
</script>

<template>
  <div class="form-screen">
    <!-- Zona de búsqueda -->
    <div class="search-section">
      <q-input
        filled
        v-model="searchQuery"
        placeholder="Buscar formularios..."
        label="Buscar"
        class="search-input"
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
    </div>

    <!-- Grid de tarjetas -->
    <div class="forms-grid">
      <q-card
        v-for="(form, formIndex) in paginatedForms"
        :key="formIndex"
        class="form-card"
        bordered
        flat
      >
        <q-card-section>
          <div class="text-h6 form-title">{{ form.name }}</div>
          <p class="form-description">{{ form.description }}</p>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn
            flat
            color="primary"
            label="Ver detalles"
            @click="viewDetails(formIndex)"
          />
          <q-btn
            flat
            color="negative"
            icon="delete"
            @click="deleteForm(formIndex)"
            aria-label="Eliminar formulario"
          />
          <q-btn
            flat
            color="primary"
            icon="edit"
            @click="editForm(formIndex)"
            aria-label="Editar formulario"
          />
        </q-card-actions>
      </q-card>
    </div>

    <!-- Paginación -->
    <div class="pagination-container">
      <q-pagination
        v-model="currentPage"
        :max="totalPages"
        :max-pages="6"
        boundary-numbers
        direction-links
        @update:model-value="changePage"
      />
    </div>

    <!-- Modal para editar formulario -->
    <q-dialog v-model="showEditModal" persistent maximized>
      <q-card>
        <q-card-section class="row items-center">
          <div class="text-h6">Editar Formulario</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="q-pa-md">
          <div class="row q-col-gutter-md">
            <div class="col-12 col-md-6">
              <q-input v-model="editingForm.name" label="Nombre" filled />
            </div>
            <div class="col-12 col-md-6">
              <q-input v-model="editingForm.description" label="Descripción" filled />
            </div>
          </div>

          <!-- Sección de preguntas -->
          <div class="text-h6 q-mt-lg q-mb-md">Preguntas</div>
          <div v-if="editingForm" class="questions-section">
            <div
              v-for="(question, index) in editingForm.questions"
              :key="index"
              class="question-edit-item q-mb-md"
            >
              <q-card bordered flat class="q-pa-md">
                <div class="row q-col-gutter-md">
                  <div class="col-12 col-md-6">
                    <q-input
                      v-model="question.question"
                      label="Pregunta"
                      filled
                    />
                  </div>
                  <div class="col-12 col-md-1 flex items-center">
                    <q-btn
                      flat
                      color="negative"
                      icon="delete"
                      @click="deleteQuestion(index)"
                      size="sm"
                    />
                  </div>
                  <div class="col-12">
                    <div
                      v-for="(answer, answerIndex) in question.answers"
                      :key="answerIndex"
                      class="answer-item q-mb-sm"
                    >
                      <q-input
                        v-model="question.answers[answerIndex]"
                        label="Respuesta"
                        filled
                      />
                      <q-btn
                        flat
                        color="negative"
                        icon="delete"
                        @click="deleteAnswer(index, answerIndex)"
                        size="sm"
                      />
                    </div>
                    <q-btn
                      flat
                      color="primary"
                      icon="add"
                      label="Agregar Respuesta"
                      @click="addAnswer(index)"
                    />
                  </div>
                </div>
              </q-card>
            </div>

            <div class="text-center q-mt-md">
              <q-btn
                color="primary"
                icon="add"
                label="Agregar Pregunta"
                @click="addQuestion"
              />
            </div>
          </div>
        </q-card-section>

        <q-card-actions align="right" class="q-pa-md">
          <q-btn flat label="Cancelar" v-close-popup />
          <q-btn flat color="primary" label="Guardar" @click="saveEdit" />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!-- Modal para ver detalles -->
<q-dialog v-model="showDetailsModal" persistent maximized>
  <q-card>
    <q-card-section class="row items-center">
      <div class="text-h6">{{ viewingForm?.name || 'Detalles del Formulario' }}</div>
      <q-space />
      <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>

    <q-card-section class="q-pa-md">
      <div class="row q-col-gutter-md">
        <div class="col-12">
          <div class="text-subtitle1 q-mb-md">{{ viewingForm?.description }}</div>
        </div>
      </div>

      <!-- Sección de preguntas -->
      <div class="text-h6 q-mt-lg q-mb-md">Preguntas</div>
      <div v-if="viewingForm?.questions" class="questions-section">
        <div
          v-for="(question, index) in viewingForm.questions"
          :key="index"
          class="question-detail-item q-mb-md"
        >
          <q-card bordered flat class="q-pa-md">
            <div class="row q-col-gutter-md">
              <div class="col-12">
                <div class="text-h6">{{ question.question }}</div>
              </div>
              <div class="col-12">
                <ul class="q-pl-md">
                  <li
                    v-for="(answer, answerIndex) in question.answers"
                    :key="answerIndex"
                  >
                    {{ answer }}
                  </li>
                </ul>
              </div>
            </div>
          </q-card>
        </div>
      </div>
    </q-card-section>

    <q-card-actions align="right" class="q-pa-md">
      <q-btn flat label="Cerrar" v-close-popup />
    </q-card-actions>
  </q-card>
</q-dialog>

  </div>
</template>


<style scoped>
.card-form {
  width: 100%;
  max-width: 250px;
  border-radius: 10%;
}
.search-section {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 20px;
}
.form-screen {
  padding: 20px;
}

.search-section {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
  max-width: 800px;
}

.search-input {
  flex: 2;
}

.filter-select {
  flex: 1;
}

.forms-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 24px;
  margin-bottom: 40px;
}

.form-card {
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.form-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 8px;
  color: #1976D2;
}

.form-description {
  color: #666;
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
}

.pagination-container {
  display: flex;
  justify-content: center;
  margin-top: 40px;
}

.question-item {
  border-left: 3px solid #1976D2;
  padding-left: 12px;
  margin: 12px 0;
}

.question-edit-item {
  transition: all 0.3s ease;
}

.question-edit-item:hover {
  transform: translateX(4px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .search-section {
    flex-direction: column;
    gap: 10px;
  }

  .forms-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
  }
}
</style>
