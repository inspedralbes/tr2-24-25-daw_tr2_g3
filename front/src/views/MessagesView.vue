<script setup>

import LayoutMain from "@/layout/LayoutMain.vue";
</script>

<template>
  <LayoutMain>
    <template #title>
      Mis mensajes
    </template>

    <template #icon>
      <i class="bi bi-chat-left-fill"></i>
    </template>
    <template #subtitle>
      Contendor de mensajes
    </template>

    <div>
      <span class="text-xl font-bold text-red">No hay mensajes</span>
    </div>

  </LayoutMain>
</template>

<style scoped>

</style>
