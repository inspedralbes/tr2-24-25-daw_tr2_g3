<script setup>
import {ref, onMounted} from "vue";
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import SidebarItem from "@/components/Sidebar/SidebarItem.vue";
import {Home, Settings, User, MessageSquare} from "lucide-vue-next";
import {useRoute} from "vue-router";

const route = useRoute();

const menuItems = ref([
  {icon: Home, text: "Home", active: false, alert: false, path: '/'},
  {icon: Settings, text: "Clases", active: false, alert: false, path: '/classes'},
  {icon: User, text: "Alumnos", active: false, alert: false, path: '/students'},
  {icon: MessageSquare, text: "Mensajes", active: false, alert: false, path: '/messages'},
]);

const setActive = () => {
  menuItems.value.forEach(item => {
    item.active = item.path === route.path;
  });
};

onMounted(setActive);

</script>

<template>
  <Sidebar>
    <SidebarItem
      v-for="(item, index) in menuItems"
      :key="index"
      :icon="item.icon"
      :text="item.text"
      :active="item.active"
      :alert="item.alert"
      :path="item.path"
    />
  </Sidebar>
</template>

