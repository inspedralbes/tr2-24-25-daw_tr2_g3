import {reactive, ref} from "vue";

export function useClasesView(){
  const modal = ref(false);
  const className = ref('');
  const code = ref(123456)
  const clases = reactive([
    {
      "curs": "1",
      "lletra": "B",
      "numAlumnos": 28,
      "year": 2023
    },
    {
      "curs": "2",
      "lletra": "A",
      "numAlumnos": 32,
      "year": 2023
    },
    {
      "curs": "2",
      "lletra": "B",
      "numAlumnos": 27,
      "year": 2024
    },
    {
      "curs": "3",
      "lletra": "A",
      "numAlumnos": 29,
      "year": 2023
    },
    {
      "curs": "3",
      "lletra":"E",
      "numAlumnos": 31,
      "year": 2022
    },
    {
      "curs": "3",
      "lletra": "B",
      "numAlumnos": 31,
      "year": 2021
    },
  ]);
  const lettersOptions = reactive([
    {label: 'A', value: 'A'},
    {label: 'B', value: 'B'},
    {label: 'C', value: 'C'},
    {label: 'D', value: 'D'},
    {label: 'E', value: 'E'}
  ]);
  const letterOption = ref(lettersOptions.find(option => option.value === 'A'))

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
        curs: className.value,
        numAlumnos: 0,
        lletra: letterOption.value.value,
        year: new Date().getFullYear()
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
    lettersOptions,
    letterOption,
    openModal,
    saveData,
    closeModal
  }
}
