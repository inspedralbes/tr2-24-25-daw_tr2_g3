import {reactive, ref} from "vue";

export function useClasesView(){
  const modal = ref(false);
  const className = ref('');
  const code = ref(123456)
  const clases = reactive([
    {
      "name": "1-B",
      "numAlumnos": 28
    },
    {
      "name": "2-A",
      "numAlumnos": 32
    },
    {
      "name": "2-B",
      "numAlumnos": 27
    },
    {
      "name": "3-A",
      "numAlumnos": 29
    },
    {
      "name": "3-B",
      "numAlumnos": 31
    },
    {
      "name": "3-B",
      "numAlumnos": 31
    },
  ]);

  function openModal(){
    modal.value = true
  }

  function closeModal(){
    modal.value = false;
    className.value = ''
  }

  function saveData(){
    if(className.value === ''){
      console.log('NO puede')
    }else{
      console.log("Nom", className.value)
      modal.value = false
      const data = {
        name: className.value,
        numAlumnos: 0,
      }
      clases.push(data);
      className.value = '';
    }
  }
  return {
    modal,
    className,
    code,
    clases,
    openModal,
    saveData,
    closeModal
  }
}
