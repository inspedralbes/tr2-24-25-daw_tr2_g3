<script setup>
import LayoutMain from "@/layout/LayoutMain.vue";
import StudentsGrid from "@/components/StudentsGrid.vue";
import { useStudentsView } from '@/composable/useStudentsView.js';

const { students, nStudents } = useStudentsView();
</script>

<template>
    <LayoutMain>

      <template #title>
        <p>Estudiants</p>
      </template>

      <template #subtitle>
        <p>{{ nStudents }}</p>
      </template>

      <StudentsGrid :students="students" :nStudents="nStudents" />

    </LayoutMain>
</template>