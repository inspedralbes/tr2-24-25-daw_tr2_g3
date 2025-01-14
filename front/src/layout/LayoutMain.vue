<script setup>
import {ref} from 'vue';
import Sidebartest from "@/components/Sidebar/Sidebartest.vue";

const isSidebarExpanded = ref(true);

const handleSidebarToggle = (expanded) => {
  console.log(expanded)
  isSidebarExpanded.value = expanded;
};
</script>

<template>

    <Sidebartest @toggle-sidebar="handleSidebarToggle" class="fixed"/>

    <div :class="{
        'ml-16': !isSidebarExpanded,
        'ml-64': isSidebarExpanded,
      }" class="duration-300">
      <!-- Slot para el subtítulo -->
      <div class="flex">
        <div class="pl-10 pt-10 header-content">
          <div >
            <slot name="breadcrumbs"></slot>
          </div>
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

      <div class="mt-2">
          <div >
            <slot name="footer"></slot>
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
