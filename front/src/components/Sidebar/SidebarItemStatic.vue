<script setup>
import {ref} from "vue";
import {useSidebarContext} from "@/components/Sidebar/Sidebar.vue";
import {useRouter} from 'vue-router';

const router = useRouter();

const props = defineProps({
  icon: [Object, Function],
  text: String,
  active: Boolean,
  alert: Boolean,
  path: String,
});

const navigateTo = (path) => {
  router.push(path);
};


const {expanded} = useSidebarContext();
</script>

<template>
  <li
    :class="[
      'relative flex items-center py-2 px-3 my-1 font-medium text-cont rounded-md cursor-pointer transition-colors group',
      active
        ? 'bg-gradient-to-tr custom-gradient text-cont'
        : 'bg-hover',
    ]"
    @click="navigateTo(path)">

      <component :is="icon"/>
      <span class="ml-2">{{ text }}</span>
    <div
      v-if="alert"
    />
    <div
      v-if="!expanded"
      class="absolute left-full rounded-md px-2 py-1 ml-6 bg-indigo-100 text-indigo-800 text-sm invisible opacity-20 -translate-x-3 transition-all group-hover:visible group-hover:opacity-100 group-hover:translate-x-0"
    >
      {{ text }}
    </div>
  </li>
</template>

<style lang="sass">

.text-cont
  color: $primary-light

.custom-gradient
  background-color: #27a1bc
  color: #001732

.bg-hover:hover
  background-color: $info-dark-medium
  box-shadow: 0 4px 10px rgba(88, 196, 220, 0.2)
</style>
