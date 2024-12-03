<script>
import {ref} from 'vue'

export default {
  setup() {
    const leftDrawerOpen = ref(false)

    return {
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
}
</script>

<template>
  <q-layout view="hHh lpR fFf">

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <!-- drawer content -->
      <div class="w-100 h-100">
        <div class="q-pa-md">
          <p class="q-ma-none text-primary" style="font-size: 2rem">SyncBlend</p>
        </div>

        <div class="">
          <q-btn
            class="full-width no-shadow"
            flat
            unelevated
          >
            Dashboard
          </q-btn>
        </div>
      </div>
    </q-drawer>

    <q-page-container>
      <router-view/>
    </q-page-container>

  </q-layout>
</template>

<style scoped>
/* Clase personalizada para asegurar que no haya sombra */
.no-shadow {
  box-shadow: none !important;
}

/* Opcional: ajustar para que no haya bordes si usas 'flat' */
.q-btn.flat {
  border: none !important;
}
</style>
