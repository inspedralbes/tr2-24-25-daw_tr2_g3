<script setup>
import { useFormScreen } from '@/composable/components/useFormSreen';
import { ref, computed } from 'vue';

const props = defineProps({
  formsJSON: {
    type: Object,
    required: true
  }
});

const forms = useFormScreen(props);
const searchQuery = ref('');
const selectedFilter = ref('name');
const currentPage = ref(1);
const itemsPerPage = 8;

// Computed para filtrar la lista en tiempo real
const filteredForms = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return forms.formsJSON.data.filter((form) =>
    form[selectedFilter.value].toLowerCase().includes(query)
  );
});

// Computed para paginar los resultados filtrados
const paginatedForms = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return filteredForms.value.slice(startIndex, endIndex);
});

// Computed para calcular el número total de páginas
const totalPages = computed(() =>
  Math.ceil(filteredForms.value.length / itemsPerPage)
);

// Método para cambiar de página
const changePage = (page) => {
  currentPage.value = page;
};
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
      <q-select
        filled
        v-model="selectedFilter"
        :options="[
          { label: 'Nombre', value: 'name' },
          { label: 'Descripción', value: 'description' }
        ]"
        label="Filtrar por"
        class="filter-select"
      />
    </div>

    <!-- Grid de tarjetas -->
    <div class="forms-grid">
      <q-card
        v-for="(json, index) in paginatedForms"
        :key="index"
        class="form-card"
        bordered
        flat
      >
        <q-card-section>
          <div class="text-h6 form-title">{{ json.name }}</div>
          <p class="form-description">{{ json.description }}</p>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat color="primary" label="Ver detalles" />
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
