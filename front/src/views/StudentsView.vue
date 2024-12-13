<script setup>
import LayoutMain from "@/layout/LayoutMain.vue";
import StudentsGrid from "@/components/StudentsGrid.vue";
import Pagination from "@/components/Pagination.vue";
import { useStudentsView } from '@/composable/useStudentsView.js';
import BreadCrumbs from "@/components/BreadCrumbs.vue";
import { useRoute } from 'vue-router';

const route = useRoute();
const teacherId = parseInt(route.params.teacherId);

const { 
  crumbs,
  students, 
  nStudents,
  search,
  dropdownOpen,
  options,
  selectedOption,
  toggleDropdown,
  selectOption,
  paginatedStudents,
  searchStudents,
  currentPage,
  goToPage,
  nextPage,
  previousPage,
  clearSearch,
  clearOption,
  applyFilter
} = useStudentsView(teacherId);

const exportData = () => {
  // Logic to export data
  
};

</script>

<template>
  <LayoutMain>
    <template #breadcrumbs>
      <div class="flex justify-between items-center w-full">
        <BreadCrumbs :crumbs="crumbs" />
      </div>
    </template>
    
    <template #buttons>
      <button 
        @click="exportData"
        class="absolute right-6 px-4 py-2 bg-primary text-white rounded-md hover:!bg-[#7FD3E6]"
      >
        Exportar
      </button>
    </template>

    <template #title>
      <p>Estudiants</p>
    </template>
    
    <template #subtitle>
      <span class="font-bold mr-2">Nº Estudiants: </span> <p>{{ nStudents }}</p>
    </template>
    <div class="flex items-center gap-6 mb-8">
      <!-- Search -->
      <div class="relative flex items-stretch search-container">
        <input
          type="text"
          placeholder="Buscar..."
          v-model="search"
          @keyup.enter="searchStudents"
          class="block px-3 py-1.5 text-base font-normal leading-6 text-gray-900 bg-white bg-clip-padding border border-gray-300 rounded-l-md focus:outline-none"
        />
        <span 
          v-if="search"
          @click="clearSearch"
          class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-red-500 text-white border border-gray-300 border-l-0 rounded-r-md cursor-pointer"
        >
          <i class="bi bi-trash3"></i>
        </span>
        <span 
          v-else
          class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-gray-100 border border-gray-300 border-l-0 rounded-r-md"
        >
          <i class="bi bi-search"></i>
        </span>
      </div>

      <div class="relative flex items-stretch dropdown-container">
        <!-- Filter -->
        <div class="relative flex items-stretch">
          <span v-if="selectedOption" @click="clearOption" class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-red-500 text-white border border-gray-300 border-r-0 rounded-l-md cursor-pointer">
            <i class="bi bi-trash"></i>
          </span>
          <span v-else class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-gray-100 border border-gray-300 border-r-0 rounded-l-md">
            <i class="bi bi-funnel"></i>
          </span>
          
          <!-- DropDown -->
          <div class="relative w-[130px]">
            <button
              @click="toggleDropdown"
              class="block h-[38px] w-full cursor-pointer rounded-r-md bg-white py-2 px-3 text-left text-gray-900 border border-gray-300 focus:outline-none"
              aria-haspopup="listbox"
              :aria-expanded="dropdownOpen"
              aria-labelledby="listbox-label"
            >
              <span class="flex items-center gap-3">
                <span class="block truncate">{{ selectedOption.name }}</span>
              </span>
            </button>

            <ul
              v-if="dropdownOpen"
              class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none"
              tabindex="-1"
              role="listbox"
            >
              <li
                v-for="option in options"
                :key="option.id"
                @click="selectOption(option)"
                class="cursor-pointer select-none py-2 px-3 text-gray-900 hover:bg-indigo-600 hover:text-white"
              >
                {{ option.name }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div>
      <StudentsGrid :students="paginatedStudents" :nStudents="nStudents" :teacherId="teacherId"/>
    </div>

    <Pagination
      :totalItems="nStudents"
      :currentPage="currentPage"
      @goToPage="goToPage"
      @nextPage="nextPage"
      @previousPage="previousPage"
    />
  </LayoutMain>
</template>

<style scoped>


</style>