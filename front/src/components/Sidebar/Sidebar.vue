<script>
import {ref, onMounted, onUnmounted, provide, inject} from "vue";
import SidebarItemStatic from "@/components/Sidebar/SidebarItemStatic.vue";

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
import {MoreVertical, ChevronLast, ChevronFirst, CircleUserRound, LogOut} from "lucide-vue-next";
import {onMounted, ref} from "vue";
import SidebarItemStatic from "@/components/Sidebar/SidebarItemStatic.vue";
import {useRoute} from "vue-router";

const route = useRoute()

const expanded = ref(true);
const showContent = ref(true);
const isModalVisible = ref(false);

const menuItemsStatics = ref([
  {icon: CircleUserRound, text: "Perfil", active: false, alert: false, path: '/profile'},
  {icon: LogOut, text: "Tanca sessió", active: false, alert: false, path: '/login'},
]);

const setActiveStatic = () => {
  menuItemsStatics.value.forEach(item => {
    item.active = item.path === route.path;
  });
}

const emit = defineEmits(["toggle-sidebar"]);

const toggleSidebar = () => {

  if (expanded.value) {
    showContent.value = false;
    expanded.value = false;

  } else {
    expanded.value = true;

    setTimeout(() => {
      showContent.value = true;
    }, 400);
  }

  emit("toggle-sidebar", expanded.value);
};

const modalUser = () => {
  isModalVisible.value = !isModalVisible.value;
};

const closeModal = () => {
  isModalVisible.value = false;
};

const handleClickOutside = (event) => {
  const modal = document.querySelector(".modal");
  const icon = document.querySelector(".custom-icon");

  if (modal && !modal.contains(event.target) && !icon.contains(event.target)) {
    closeModal();
  }
};

// Add and remove listener globally
onMounted(() => {
  document.addEventListener("click", handleClickOutside);
  setActiveStatic();
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});

provide(SidebarContext, {expanded, showContent});
</script>

<template>
  <div class="w-64">
    <aside class="h-screen duration-300"
           :class="[ 'h-screen transition-all duration-300',expanded ? 'w-64' : 'w-16']">
      <nav class="h-full flex flex-col bg-second border-r shadow-sm">
        <!-- Header -->
        <div class="w-full py-4 px-4 flex justify-between items-center">
          <img
            src="https://img.logoipsum.com/243.svg"
            :class="['overflow-hidden transition-all duration-300', expanded ? 'w-32' : 'w-0']"
            alt=""
          />
          <button @click="toggleSidebar" class="p-1.5 arrow rounded-lg text-cont  hover:bg-gray-100">
            <component :is="expanded ? ChevronFirst : ChevronLast"/>
          </button>
        </div>

        <!-- Content -->
        <ul class="flex-1 px-3 py-2">
          <slot/>
        </ul>

        <!-- Footer -->
        <div class=" flex p-3 w-full">
          <img
            src="https://ui-avatars.com/api/?background=c7d2fe&color=3730a3&bold=true"
            alt=""
            class="w-10 h-10 rounded-md"
          />
          <div
            v-show="showContent"
            :class="['flex justify-between items-center overflow-hidden transition-all', expanded ? 'w-46 ml-3' : 'w-0']">
            <div class="leading-4 text-cont">
              <h4 class="font-semibold">John Doe</h4>
              <span class="text-xs ">johndoe@gmail.com</span>
            </div>
            <MoreVertical @click="modalUser" class="ml-2 cursor-pointer custom-icon" size="20"/>
          </div>
          <!-- Modal -->
          <ul v-if="isModalVisible"
            class="modal absolute bottom-18 z-50 shadow-lg p-3 rounded-md text-center text-bold"
          >
            <SidebarItemStatic
              v-for="(item, index) in menuItemsStatics"
              :key="index"
              :icon="item.icon"
              :text="item.text"
              :active="item.active"
              :alert="item.alert"
              :path="item.path">
              <slot/>
            </SidebarItemStatic>
          </ul>
          <!--          <div v-if="isModalVisible" :class="[-->
          <!--            active-->
          <!--            ? 'bg-gradient-to-tr custom-gradient text-cont' : '',-->
          <!--            ]"-->
          <!--               class="modal absolute bottom-18 z-50 shadow-lg p-3 rounded-md text-center text-bold">-->
          <!--            < RouterLink to="/profile">-->
          <!--              <component :is="icon"/>-->
          <!--              <p class="text-lg mb-2 text-hover"> {{ props.text }}</p>-->
          <!--            </RouterLink>-->
          <!--            <RouterLink to="/login">-->
          <!--              <p class="text-lg mb-2 text-hover">Tanca sessió</p>-->
          <!--            </RouterLink>-->
          <!--          </div>-->
        </div>
      </nav>
    </aside>
  </div>

</template>

<style lang="sass" scoped>

.bg-second
  background-color: $secondary-light

.arrow
  color: $secondary-light
  background-color: $primary-light

.custom-icon
  color: $primary-light

.border-top
  border-top: 1px solid $primary-light

.modal
  width: 70%
  left: 20%
  border: 1px solid $primary-light
  margin-right: 0.4rem
  color: $primary-light
  box-shadow: 0 4px 10px rgba(0, 0, 0, 1)

.bottom-18
  bottom: 80px

.text-hover:hover
  background-color: $info-dark-medium
  box-shadow: 0 4px 10px rgba(88, 196, 220, 0.2)
  border-radius: 5px

.custom-gradient
  background-color: #27a1bc
  color: #001732

.bg-hover:hover
  background-color: $info-dark-medium
  box-shadow: 0 4px 10px rgba(88, 196, 220, 0.2)
</style>
