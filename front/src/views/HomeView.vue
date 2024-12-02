<script setup>
import LoadingScreen from "@/components/LoadingScreen.vue";
import ToggleTheme from "@/components/ToggleTheme.vue";
import LoadingBar from "@/components/LoadingBar.vue";
import {useNotifications} from "@/composable/useNotifications.js";

const notifications = useNotifications()
</script>

<template>
  <LoadingScreen />
  <ToggleTheme />
  <LoadingBar />
  <q-btn
    label="Mostrar Notificación"
    color="primary"
    @click="notifications.showNotification()"
  />
</template>

<style scoped>
</style>
