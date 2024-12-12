<script setup>
import {useSidebarContext} from "@/components/Sidebar/Sidebar.vue";
import {useRouter} from 'vue-router';

const props = defineProps({
  icon: [Object, Function],
  text: String,
  active: Boolean,
  alert: Boolean,
  path: String,
});


const router = useRouter();

const navigateTo = (path) => {
  router.push(path);
};

const {expanded, showContent} = useSidebarContext();
</script>

<template>
  <li
    :class="[
      'relative flex items-center py-2 px-3 my-1 font-medium rounded-md cursor-pointer transition-colors group',
      active
        ? 'bg-gradient-to-tr from-indigo-200 to-indigo-100 text-indigo-800'
        : 'hover:bg-indigo-50 text-gray-600',
    ]">

    <span @click="navigateTo(path)">
      <component :is="icon"/>
    </span>

    <RouterLink :to="path" :class="[
     'overflow-hidden ml-3 transition-all',
      showContent ? '' : 'hidden',
      expanded ? 'w-54' : 'w-16 hidden',
      ]">
      <span>{{ text }}</span>
    </RouterLink>
    <div
      v-if="alert"
      :class="[
            'absolute right-2 w-2 h-2 rounded bg-amber-400',
            expanded ? '' : 'top-2',
          ]"
    />
    <div
      v-if="!expanded"
      class="absolute left-full rounded-md px-2 py-1 ml-6 bg-indigo-100 text-indigo-800 text-sm invisible opacity-20 -translate-x-3 transition-all group-hover:visible group-hover:opacity-100 group-hover:translate-x-0"
    >
      {{ text }}
    </div>
  </li>
</template>
