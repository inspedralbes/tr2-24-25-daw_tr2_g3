<script setup>
import {useToggleTheme} from '@/composable/useToggleTheme'

const toggleTheme = useToggleTheme()
</script>

<template>
  <q-btn
    :icon="toggleTheme.isDarkMode ? 'brightness_3' : 'brightness_7'"
    @click="toggleTheme.toggleDarkMode"
    color="primary"
    round
    dense
  />
</template>
