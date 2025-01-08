<script setup>
import { RouterLink } from 'vue-router';

</script>

<template>
  <div class="grid place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8" style="height: 100vh;">
    <div class="text-center">
      <p class="text-4xl font-semibold text-primary">404</p>
      <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Pagina no encontrada</h1>
      <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Perdon,no hemos encontrado esta pagina</p>
      <div class="mt-10 flex items-center justify-center gap-x-6">
        <RouterLink to="/" class="rounded-md btn-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Volver al inicio</RouterLink>
        <a href="#" class="text-sm font-semibold text-gray-900">Contact support <span aria-hidden="true">&rarr;</span></a>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
