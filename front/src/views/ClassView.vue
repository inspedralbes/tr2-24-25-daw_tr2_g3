<script setup>
import ClassScreen from "@/components/ClassScreen.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
</script>

<template>
  <LayoutMain>

    <template #title>
      <p>Class 1-A</p>
    </template>

    <template #icon>
      <q-icon name="fa-solid fa-user" size="md" class="q-mr-xs"></q-icon>
      <q-icon name="fa-solid fa-user" />
    </template>


    <template #subtitle>
      Subtitle
    </template>

    <template #buttons>
      <q-btn color="primary">Codigo</q-btn>
    </template>


    <template #content>
      <ClassScreen/>
    </template>
  </LayoutMain>

</template>

<style scoped>

</style>
