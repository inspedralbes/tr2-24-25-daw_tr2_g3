<template>
    <Sidebar>
      <SidebarItem
        v-for="(item, index) in menuItems"
        :key="index"
        :icon="item.icon"
        :text="item.text"
        :active="item.active"
        :alert="item.alert"
      />
    </Sidebar>
</template>

<script setup>
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import SidebarItem from "@/components/Sidebar/SidebarItem.vue";
import {Home, Info, Settings} from "lucide-vue-next";

const menuItems = [
  {icon: Home, text: "Dashboard", active: true, alert: false},
  {icon: Settings, text: "Settings", active: false, alert: true},
  {icon: Info, text: "About", active: false, alert: false},
];
</script>
