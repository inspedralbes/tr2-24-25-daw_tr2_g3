<script>
import {ref, provide, inject} from "vue";

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
import {MoreVertical, ChevronLast, ChevronFirst} from "lucide-vue-next";

const expanded = ref(true);
const showContent = ref(true);

const emit = defineEmits(["toggle-sidebar"]);

const toggleSidebar = () => {

  if (expanded.value) {
    showContent.value = false;
    expanded.value = false;

  } else {
    expanded.value = true;

    setTimeout(() => {
      showContent.value = true;
      console.log(showContent.value)
    }, 400);
  }

  emit("toggle-sidebar", expanded.value);
};

provide(SidebarContext, {expanded, showContent});
</script>

<template>
  <div class="w-64">
    <aside class="h-screen duration-300"
           :class="[ 'h-screen transition-all duration-300',expanded ? 'w-64' : 'w-16']">
      <nav class="h-full flex flex-col bg-white border-r shadow-sm">
        <!-- Header -->
        <div class="w-full py-4 px-4 flex justify-between items-center">
          <img
            src="https://img.logoipsum.com/243.svg"
            :class="['overflow-hidden transition-all duration-300', expanded ? 'w-32' : 'w-0']"
            alt=""
          />
          <button @click="toggleSidebar" class="p-1.5 rounded-lg bg-gray-50 hover:bg-gray-100">
            <component :is="expanded ? ChevronFirst : ChevronLast"/>
          </button>
        </div>

        <!-- Content -->
        <ul class="flex-1 px-3 py-2">
          <slot/>
        </ul>

        <!-- Footer -->
        <div class="border-t flex p-3 w-full">
          <img
            src="https://ui-avatars.com/api/?background=c7d2fe&color=3730a3&bold=true"
            alt=""
            class="w-10 h-10 rounded-md"
          />
          <div
            v-show="showContent"
            :class="['flex justify-between items-center overflow-hidden transition-all', expanded ? 'w-46 ml-3' : 'w-0']">
            <div class="leading-4">
              <h4 class="font-semibold">John Doe</h4>
              <span class="text-xs text-gray-600">johndoe@gmail.com</span>
            </div>
            <MoreVertical class="ml-2" size="20"/>
          </div>
        </div>
      </nav>
    </aside>
  </div>

</template>

<style lang="sass" scoped>

</style>
