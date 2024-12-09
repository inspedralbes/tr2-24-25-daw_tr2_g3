<script setup>
import LayoutMain from "@/layout/LayoutMain.vue";
import StudentsGrid from "@/components/StudentsGrid.vue";
import { useStudentsView } from '@/composable/useStudentsView.js';

const { 
  students, 
  nStudents,
  search,
  dropdownOpen,
  options,
  selectedOption,
  toggleDropdown,
  selectOption,
} = useStudentsView();
</script>

<template>
  <LayoutMain>
    <template #title>
      <p>Estudiants</p>
    </template>

    <template #subtitle>
      <p>{{ nStudents }}</p>
    </template>
    <div class="flex items-center">
      <!-- Search -->
      <div class="relative flex items-stretch search-container">
        <input
          type="text"
          placeholder="Buscar..."
          v-model="search"
          class="block px-3 py-1.5 text-base font-normal leading-6 text-gray-900 bg-white bg-clip-padding border border-gray-300 rounded-l-md focus:outline-none"
        />
        <span class="flex items-center px-3 py-1.5 text-base font-normal leading-6 text-current text-center whitespace-nowrap bg-gray-100 border border-gray-300 border-l-0 rounded-r-md">
          <i class="bi bi-search"></i>
        </span>
      </div>
      <!-- DropDown -->
      <div class="relative ml-8">
        <button
          @click="toggleDropdown"
          class="grid w-full cursor-pointer grid-cols-1 rounded-md bg-white py-2 px-3 text-left text-gray-900 border-2 border-gray-300 focus:outline-none"
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

    <StudentsGrid :students="students" :nStudents="nStudents" />
  </LayoutMain>
</template>

<style scoped>
/* Delete focus blue*/
.search-container input:focus,
.search-container span:focus,
button:focus,
ul:focus {
  outline: none;
  box-shadow: none;
  border-color: inherit;
}
</style>