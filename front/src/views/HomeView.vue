<script setup>
import useHome from "@/composables/useHome.js";

const home = useHome();
</script>

<template>
  <div>
    <p>{{ home.test }}</p> <!-- Muestra datos desde el composable -->
  </div>
</template>

<style scoped>
</style>
