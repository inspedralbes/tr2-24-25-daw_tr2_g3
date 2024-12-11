import {ref} from 'vue'
export function useClassView(){
  const dense = ref(false);
  const code = ref(123456);
  const selectedFile = ref(null);
  function sendExcel(event){

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

      const formData = new FormData();
      formData.append("file", selectedFile.value);

      try {
        const response = await fetch("http://localhost:8000/api/import/students", {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`);
        }

        const data = await response.json();
        console.log("Archivo subido correctamente:", data);
      } catch (error) {
        console.error("Error al subir el archivo:", error);
      }
    }

  return {
    dense,
    code,
    selectedFile,
    handleFileUpload,
    uploadFile
  }
}
