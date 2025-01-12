import {onMounted, onUnmounted, reactive, ref, computed} from 'vue'
import {useRoute} from "vue-router";
import * as com from '@/services/communicationManager.js'
import {useAuthStore} from "@/stores/authStore.js";

export function useClassView() {

  const route = useRoute();

  const dense = ref(false);
  const selectedFile = ref(null);
  const recuperateCode = ref(null)
  const dataGroup = reactive( []);

  function sendExcel(event) {

  }

  // Manejar selección del archivo
  function handleFileUpload(event) {
    const file = event.target.files[0];
    if (!file) {
      console.log("No file selected");
      return;
    }
    selectedFile.value = file;
    console.log("Archivo seleccionado:", file.name);
  }

  // Subir el archivo al servidor
  async function uploadFile() {
    if (!selectedFile.value) {
      console.error("No se ha seleccionado ningún archivo");
      return;
    }
    const authStore = useAuthStore();

    console.log(dataGroup[0].id)
    const formData = new FormData();
    formData.append("file", selectedFile.value);
    formData.append("group_id", dataGroup[0].id);
    try {
      const response = await fetch("http://localhost:8000/api/import/students", {
        method: "POST",
        headers: {
          'Accept': 'application/json',
          'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
        },
        body: formData
      });

      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }

      const data = await response.json();
      console.log(data)
      console.log("Archivo subido correctamente:", data);
    } catch (error) {
      console.error("Error al subir el archivo:", error);
    }
  }

  onMounted(async () => {
    recuperateCode.value = route.params.id
    console.log(recuperateCode.value)
    const data = await com.getGroup(recuperateCode.value)
    console.log(data)
    dataGroup.push(data[0])
    console.log(dataGroup)
  })

  onUnmounted(() => {

  })


  return {
    dataGroup,
    dense,
    selectedFile,
    handleFileUpload,
    uploadFile
  }
}
