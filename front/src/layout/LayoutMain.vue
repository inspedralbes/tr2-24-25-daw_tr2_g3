<script>
import {ref} from 'vue';

export default {
  setup() {
    const isMini = ref(false); // Estado inicial del sidebar: contraído

    // Alternar entre expandido y contraído
    const toggleSidebar = () => {
      isMini.value = !isMini.value;
    };

    return {
      isMini,
      toggleSidebar,
    };
  },
};
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div
        :class="{
        'w-16': isMini,
        'w-64': !isMini,
        'transition-width duration-300': true
      }"
        class=" p-4 flex flex-col fixed left-0 top-0 bottom-0 z-10 shadow-lg"
        style="background-color: #4B5361"
    >
      <div class="flex justify-between items-center mb-3">
        <p v-if="!isMini" class="text-primary text-2xl font-bold mt-4">SyncBlend</p>
        <button
            @click="toggleSidebar"
            class="text-white py-2 px-3 rounded-full hover:bg-gray-700 focus:outline-none"
        >
          <span v-if="!isMini" class="material-icons">chevron_left</span>
          <span v-if="isMini" class="material-icons">chevron_right</span>
        </button>
      </div>
      <div class="flex-1 space-y-4">
        <RouterLink to="/profile" :class="{
              'w-9': isMini,
              'w-full': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">account_circle</span>
          <span v-if="!isMini">Perfil</span>
        </RouterLink>

        <button :class="{
              'w-9': isMini,
              'w-64': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">people</span>
          <span v-if="!isMini">Alumnos</span>
        </button>

        <RouterLink to="/classes" :class="{
              'w-9': isMini,
              'w-64': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">school</span>
          <span v-if="!isMini">Clases</span>
        </RouterLink>

        <button :class="{
              'w-9': isMini,
              'w-64': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">help_outline</span>
          <span v-if="!isMini">Wizard</span>
        </button>

        <RouterLink to="/messages" :class="{
              'w-9': isMini,
              'w-64': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">mail</span>
          <span v-if="!isMini">Mensajes</span>
        </RouterLink>
      </div>
      <div>
        <button :class="{
              'w-9': isMini,
              'w-64': !isMini,
            }" class="w-full text-white flex items-center p-2 hover:bg-gray-700 rounded-md">
          <span class="material-icons mr-2">exit_to_app</span>
          <span v-if="!isMini">Log out</span>
        </button>
      </div>
    </div>

    <!-- Contenedor principal -->
    <div :class="{
      'ml-10':isMini,
      'ml-big':!isMini,
    }" class="w-full">
      <!-- Slot para el subtítulo -->
      <div class="flex">
        <div class="pl-10 pt-10 header-content">
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
        <div class="buttons-content flex gap-5 items-center">
          <slot name="buttons"></slot>
        </div>
      </div>

      <!-- Contenido principal -->
      <div class="p-10 w-full">
        <slot/>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Aseguramos que no haya sombra en los botones */
.no-shadow {
  box-shadow: none !important;
}

/* Opcional: ajustar para que no haya bordes si usas 'flat' */
.q-btn.flat {
  border: none !important;
}

/* Botón flotante */
.floating-btn {
  position: absolute;
  top: 4%;
  right: -15px;
  transform: translateY(-50%);
  border: 1px solid #000000;
}

.ml-big {
  margin-left: 16rem;
}

.header-content {
  width: 70%;
}

.buttons-content {
  width: 30%;
}

</style>
