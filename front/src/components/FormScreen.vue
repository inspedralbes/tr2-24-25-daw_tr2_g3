<script setup>
import { useFormScreen } from '@/composable/components/useFormSreen';
import { ref, computed } from 'vue';

const forms = useFormScreen();
const searchQuery = ref('');
const selectedFilter = ref('name'); // Campo a filtrar (nombre o descripción)

// Computed para filtrar la lista en tiempo real
const filteredForms = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return forms.formsJSON.filter((form) =>
    form[selectedFilter.value].toLowerCase().includes(query)
  );
});
</script>

<template>
  <div>
    <!-- Zona de búsqueda -->
    <div class="search-section">
      <q-input
        filled
        v-model="searchQuery"
        placeholder="Buscar formularios..."
        label="Buscar"
      />
      <q-select
        filled
        v-model="selectedFilter"
        :options="[
          { label: 'Nombre', value: 'name' },
          { label: 'Descripción', value: 'description' }
        ]"
        label="Filtrar por"
      />
    </div>

    <!-- Tarjetas de formularios -->
    <div class="flex gap-10">
      <q-card
        v-for="(json, index) in filteredForms"
        :key="index"
        class="card-form"
      >
        <q-card-section>
          <h6>{{ json.name }}</h6>
          <p>{{ json.description }}</p>
        </q-card-section>
      </q-card>
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
</style>
