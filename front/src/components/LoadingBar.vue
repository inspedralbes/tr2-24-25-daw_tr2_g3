<script setup>
import { useLoadingBar} from "@/composable/useLoadingBar.js";

const loadingBar = useLoadingBar()
</script>

<template>
  <q-btn
    label="Iniciar Carga"
    @click="loadingBar.startLoading"
    color="primary"
    round
    dense
  />
</template>
