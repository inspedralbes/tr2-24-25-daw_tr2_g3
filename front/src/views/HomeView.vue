<script setup>
import useHome from "@/composables/useHome.js";

const home = useHome();
</script>

<template>
  <!-- Slots para enviar datos al layout -->
  <div>
    <slot name="title">TITULO</slot>
  </div>

  <div>
    <slot name="subtitle">subtitle</slot>
  </div>

  <div>
    <p>{{ home.test }}</p> <!-- Contenido del composable -->
    <p>Este es el contenido principal enviado al slot por defecto.</p>
  </div>
</template>

<style scoped>
/* Estilos personalizados para el hijo */
</style>
