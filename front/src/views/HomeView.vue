<script setup>
import useHome from "@/composable/useHome.js";
import LayoutMain from "@/layout/LayoutMain.vue"; // Importamos el layout

const home = useHome();
</script>

<template>
  <LayoutMain>
    <template #title>
      dashboard
    </template>

    <template #icon>
      <i class="bi bi-1-circle-fill"></i>
    </template>
    <template #subtitle>
      Visualizar y configurar
    </template>

<!--    <div>-->
<!--    -->
<!--    </div>-->
  </LayoutMain>
</template>


