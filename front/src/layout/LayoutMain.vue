<script>
import {ref} from 'vue';

export default {
  setup() {
    const isMini = ref(false); // Estado inicial del sidebar: contraído
    const leftDrawerOpen = ref(false)
    // Alternar entre expandido y contraído
    const toggleSidebar = () => {
      isMini.value = !isMini.value;
    };

    return {
      isMini,
      toggleSidebar,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
      leftDrawerOpen
    };
  },
};
</script>

<template>
  <q-layout view="hHh lpR fFf">
    <!-- Sidebar -->
    <q-drawer
        show-if-above
        v-model="leftDrawerOpen"
        :mini="isMini"
        side="left"
        bordered
        class=""
    >
      <div class="w-100 h-100">
        <!-- Header del Sidebar -->
        <div class="q-pa-md flex items-center justify-between">
          <p v-if="!isMini" class="q-ma-none text-primary" style="font-size: 2rem">
            SyncBlend
          </p>
          <q-btn v-if="isMini"
                 dense
                 round
                 flat
                 :icon="isMini ? 'arrow_forward' : 'arrow_back'"
                 @click="toggleSidebar"
                 aria-label="Toggle Sidebar"
                 class="bg-white"
          />
          <!-- Botón que sobresale -->
          <q-btn
              v-if="!isMini"
              dense
              round
              flat
              :icon="isMini ? 'arrow_forward' : 'arrow_back'"
              @click="toggleSidebar"
              aria-label="Toggle Sidebar"
              class="floating-btn bg-white"
              style="border: 1px solid #9ca3af;"
          />
        </div>

        <!-- Botón con ícono y texto -->
        <div>
          <q-btn
              class="full-width no-shadow q-pa-md"
              flat
              unelevated
              align="left"
          >
            <q-icon name="dashboard" class="q-mr-sm "/>
            <span v-if="!isMini" class="">Dashboard</span>
          </q-btn>
          <q-btn
              class="full-width no-shadow q-pa-md"
              flat
              unelevated
              align="left"
          >
            <q-icon name="settings" class="q-mr-sm"/>
            <span v-if="!isMini">Settings</span>
          </q-btn>
          <q-btn
              class="full-width no-shadow q-pa-md"
              flat
              unelevated
              align="left"
          >
            <q-icon name="settings" class="q-mr-sm"/>
            <span v-if="!isMini">Settings</span>
          </q-btn>
        </div>
      </div>
    </q-drawer>

    <!-- Contenedor principal -->
    <q-page-container>
      <div>
        <!-- Slot para el título -->
        <div class="pl-10 pt-10">
          <div class="font-bold text-3xl text-uppercase mb-3 text-primary">
            <slot name="title"></slot>
          </div>

          <!-- Slot para el subtítulo -->
          <div class="text-xl text-gray-900 flex">
            <div class="me-2">
              <slot name="icon"></slot>
            </div>
            <slot name="subtitle"></slot>
          </div>
        </div>

        <!-- Contenido principal -->
        <div class="p-10">
          <slot/>
        </div>
      </div>
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

.floating-btn {
  position: absolute;
  top: 4%;
  right: -15px; /* Hace que el botón sobresalga hacia la derecha */
  transform: translateY(-50%);
  border: 1px #000000;
}

</style>





