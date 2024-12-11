<script>
import { ref, provide, inject } from "vue";

const SidebarContext = Symbol("SidebarContext");

export function useSidebarContext() {
  const context = inject(SidebarContext);
  if (!context) {
    throw new Error("useSidebarContext must be used within SidebarContextProvider");
  }
  return context;
}
</script>

<script setup>
import { MoreVertical, ChevronLast, ChevronFirst } from "lucide-vue-next";

const expanded = ref(true);

function toggleSidebar() {
  expanded.value = !expanded.value;
}

provide(SidebarContext, {expanded});
</script>

<template>
  <aside class="h-screen">
    <nav class="h-full flex flex-col bg-white border-r shadow-sm">
      <!-- Header -->
      <div class="p-4 pb-2 flex justify-between items-center">
        <img
          src="https://img.logoipsum.com/243.svg"
          :class="[
            'overflow-hidden transition-all',
            expanded ? 'w-32' : 'w-0',
          ]"
          alt=""
        />
        <button
          @click="toggleSidebar"
          class="p-1.5 rounded-lg bg-gray-50 hover:bg-gray-100"
        >
          <component :is="expanded ? 'ChevronFirst' : 'ChevronLast'"/>
        </button>
      </div>

      <!-- Content -->
      <ul class="flex-1 px-3">
        <slot/>
      </ul>

      <!-- Footer -->
      <div class="border-t flex p-3">
        <img
          src="https://ui-avatars.com/api/?background=c7d2fe&color=3730a3&bold=true"
          alt=""
          class="w-10 h-10 rounded-md"
        />
        <div
          :class="[
            'flex justify-between items-center overflow-hidden transition-all',
            expanded ? 'w-52 ml-3' : 'w-0',
          ]"
        >
          <div class="leading-4">
            <h4 class="font-semibold">John Doe</h4>
            <span class="text-xs text-gray-600">johndoe@gmail.com</span>
          </div>
          <MoreVertical size="20"/>
        </div>
      </div>
    </nav>
  </aside>
</template>
