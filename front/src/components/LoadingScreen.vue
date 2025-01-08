<script setup>
import { useLoadingScreen} from '@/composable/useLoadingScreen'

const loadingScreen = useLoadingScreen()

</script>
<template>
  <div class="q-pa-md">
    <q-btn color="teal" @click="loadingScreen.showLoading" label="Show Loading" />
  </div>
</template>
