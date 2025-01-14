import {onBeforeMount, onMounted, reactive, ref} from "vue";
import {useRouter} from 'vue-router';


export function useClasesScreen(props, emit) {

  const router = useRouter();

  const searchName = ref('');
  const clases = reactive({data: props.clases});
  const optionsFilter = reactive([
    {label: 'letter', value: 'letter'},
    {label: 'course', value: 'course'} // Añadir la opción de course

  ]);
  const selectedOption = ref(null);
  const groupId = ref(null);

  selectedOption.value = optionsFilter.find(option => option.value === "course")


  onBeforeMount(() => {
    console.log(selectedOption.value.value)
    console.log(clases.data)
  });

  function navigateToClass(dataClass) {

    router.push({
      name: 'class',
      params: {id: dataClass.code, tab: ''},
    });
  };

  function getIdGroup(id) {
    groupId.value = id
    console.log(groupId.value)
    emit('getIdGroup', groupId.value)
  }

  // Función para filtrar las clases
  function getFilteredClasses() {
    console.log("Filtrando por:", selectedOption.value.value);

    if (!searchName.value) {
      return clases.data;
    }

    return clases.data.filter((clase) => {
      const fieldValue = clase[selectedOption.value.value];

      // Si el valor a filtrar es numérico (como course), convertirlo a string
      if (typeof fieldValue === "number") {
        return String(fieldValue).includes(searchName.value);
      }

      // Si el valor es texto (como letter o name), aplicar búsqueda insensible a mayúsculas
      return fieldValue && fieldValue.toLowerCase().includes(searchName.value.toLowerCase());
    });
  }


  return {
    searchName,
    clases,
    optionsFilter,
    selectedOption,
    getFilteredClasses,
    getIdGroup,
    navigateToClass,
  }
}
