<script setup>
import { useLoadingScreen} from '@/composable/useLoadingScreen'

const loadingScreen = useLoadingScreen()
</script>
<template>
  <div class="loading-overlay">
    <div class="loading-spinner"></div>
    <p class="loading">Loading...</p>
  </div>
</template>


<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.loading-spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid #fff;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

.loading {
  margin-top: 15px;
  margin-left: 5px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
