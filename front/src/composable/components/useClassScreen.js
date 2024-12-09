import {ref, reactive, onMounted, watch} from "vue";
import {useRoute, useRouter} from "vue-router";

export function useClassScreen(){

  const route = useRoute();
  const router = useRouter();

  const name = ref('Kevin');
  const tab = ref(route.params.tab || "images"); // Inicializa desde la URL o un valor por defecto

  // Sincroniza el tab inicial cuando el componente se monta
  onMounted(() => {
    if (route.params.tab) {
      tab.value = route.params.tab;
    }
  });

  // Cambiar la URL al cambiar de tab
  function onTabChange(newTab) {
    console.log("NUEVO", newTab)

    if (newTab !== tab.value) {
      tab.value = newTab; // Actualiza el valor local
      //push newTab
      router.push({ name: "class", params: { tab: newTab } }); // Actualiza la URL
    }
  }

  return{
    name,
    tab,
    onTabChange
  }
}
