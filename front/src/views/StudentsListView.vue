<script setup>

import Pagination from "@/components/Pagination.vue";
import {useStudentsListView} from "@/composable/views/useStudentsListView.js";

const props = defineProps({
  dataProps: {
    type: Object,
    required: true
  }
})

const studentView = useStudentsListView(props.dataProps);

</script>

<template>
  <span class="text-2xl font-bold ">Lista de estudiantes</span>
  <div>
<!--  {{dataProps[0]}}-->
<!--  {{dataProps[0].user.name}}-->
<!--  {{dataProps[0].role}}-->

<!--    {{dataProps.length}}-->

      <div class="grid mt-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 ">
        <div
          class="p-4 border rounded-lg shadow-md flex items-center max-w-xs transform transition-transform duration-200 hover:scale-105"
          v-for="student in dataProps"
          :key="student.id"
        >
          <img :src="student.image" :alt="student.user.name" class="w-16 h-16 rounded-full mr-6"/>
          <div class="flex flex-col">
            <!-- Add lastname -->
            <h6 class="line-clamp-1 break-all w-[170px] mb-1">{{ student.user.name }} {{ student.user.lastname }}</h6>
            <div class="line-clamp-1 break-all w-[170px]"><span class="font-bold">Email:  </span>{{ student.user.email }}</div>
            <div class="line-clamp-1 break-all w-[170px]">
            </div>
          </div>
        </div>
      </div>
  </div>
<!--  <StudentsListGrid/>-->
  <Pagination
      :totalItems="studentView.nStudents.value"
      :currentPage="studentView.currentPage.value"
      @goToPage="studentView.goToPage"
      @nextPage="studentView.nextPage"
      @previousPage="studentView.previousPage"
  />
</template>

<style scoped>

</style>
