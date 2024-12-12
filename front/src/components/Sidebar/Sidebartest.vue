<script setup>
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import SidebarItem from "@/components/Sidebar/SidebarItem.vue";
import {Home, Settings, User, MessageSquare} from "lucide-vue-next";

const menuItems = [
  {icon: Home, text: "Home", active: true, alert: false, path: '/'},
  {icon: Settings, text: "Clases", active: false, alert: false, path: '/classes'},
  {icon: User, text: "Alumnos", active: false, alert: false, path: '/profile'},
  {icon: MessageSquare, text: "Mensajes", active: false, alert: false, path: '/messages'},
];

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

