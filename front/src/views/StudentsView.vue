<script setup>
import LayoutMain from "@/layout/LayoutMain.vue";
import StudentsGrid from "@/components/StudentsGrid.vue";
import Pagination from "@/components/Pagination.vue";
import { useStudentsView } from '@/composable/useStudentsView.js';
import BreadCrumbs from "@/components/BreadCrumbs.vue";
import { useRoute } from 'vue-router';

const route = useRoute();


const stu = useStudentsView();

</script>

<template>
  <LayoutMain>
    <template #breadcrumbs>
      <div class="flex justify-between items-center w-full">
        <BreadCrumbs :crumbs="stu.crumbs" />
      </div>
    </template>

    <template #buttons>
      <button
        @click="stu.exportStudents()"
        class="absolute right-6 px-4 py-2 bg-primary text-white rounded-md hover:!bg-[#7FD3E6]"
      >
        Exportar
      </button>
    </template>

    <template #title>
      <p>Estudiants</p>
    </template>

    <template #subtitle>
      <span class="font-bold mr-2">Nº Estudiants: </span> <p>{{ stu.nStudents }}</p>
    </template>

    <div class="flex items-center gap-6 mb-8">
      <!-- Search -->
      <div class="relative flex items-stretch search-container">
        <input
          type="text"
          placeholder="Buscar..."
          v-model="stu.search.value"
          @keyup.enter="stu.searchStudents"
          class="block px-3 py-1.5 text-base font-normal leading-6 text-gray-900 bg-white bg-clip-padding border border-gray-300 rounded-l-md focus:outline-none"
        />
        <span
          v-if="stu.search.value"
          @click="stu.clearSearch"
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
          <span v-if="stu.selectedOption.value" @click="stu.clearOption" class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-red-500 text-white border border-gray-300 border-r-0 rounded-l-md cursor-pointer">
            <i class="bi bi-trash"></i>
          </span>
          <span v-else class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-gray-100 border border-gray-300 border-r-0 rounded-l-md">
            <i class="bi bi-funnel"></i>
          </span>

          <!-- DropDown -->
          <div class="relative w-[130px]">
            <button
              @click="stu.toggleDropdown"
              class="block h-[38px] w-full cursor-pointer rounded-r-md bg-white py-2 px-3 text-left text-gray-900 border border-gray-300 focus:outline-none"
              aria-haspopup="listbox"
              :aria-expanded="stu.dropdownOpen.value"
              aria-labelledby="listbox-label"
            >
              <span class="flex items-center gap-3">
                <span class="block truncate">{{ stu.selectedOption.value }}</span>
              </span>
            </button>

            <ul
              v-if="stu.dropdownOpen.value"
              class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none"
              tabindex="-1"
              role="listbox"
            >
              <li
                v-for="option in stu.optionsFilter"
                :key="option.id"
                @click="stu.selectOption(option)"
                class="cursor-pointer select-none py-2 px-3 text-gray-900 hover:bg-indigo-600 hover:text-white"
              >
                {{ option.value }}
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <div>
      <StudentsGrid :students="stu.paginatedStudents" :nStudents="stu.nStudents"/>
    </div>

    <Pagination
      :totalItems="stu.nStudents.value"
      :itemsPerPage="stu.itemsPerPage"
      :currentPage="stu.currentPage.value"
      @goToPage="stu.goToPage"
      @nextPage="stu.nextPage"
      @previousPage="stu.previousPage"
    />
  </LayoutMain>
</template>

<style scoped>


</style>
