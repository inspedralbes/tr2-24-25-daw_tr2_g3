import {onBeforeMount, onMounted, reactive, ref} from "vue";
import {useRouter} from 'vue-router';


export function useClasesScreen(props, emit) {

  const router = useRouter();

  const searchName = ref('');
  const clases = reactive({data: props.clases});
  const optionsFilter = reactive([
    {label: 'year', value: 'year'},
    {label: 'name', value: 'name'}
  ]);
  const selectedOption = ref(null);
  const groupId = ref(null);

  selectedOption.value = optionsFilter.find(option => option.value === "name")


  console.log(selectedOption.value)
  onBeforeMount(() => {
  });

  function navigateToClass(dataClass) {

    router.push({
      name: 'class',
      params: {id: dataClass.code, tab: ''},
      // query: {data: JSON.stringify(dataClass.code)}
    });
  };

  function getIdGroup(id) {
    groupId.value = id
    console.log(groupId.value)
    emit('getIdGroup', groupId.value)
  }

  // Función para filtrar las clases
  function getFilteredClasses() {

    if (!searchName.value) {
      return clases.data;
    }
    return clases.data.filter((clase) => {
      const fieldValue = clase[seletecdOption.value.value];

      // Si es un número (como year), convertirlo a string
      if (typeof fieldValue === "number") {
        return String(fieldValue).includes(searchName.value);
      }

      // Si es texto (como name), aplicar búsqueda insensible a mayúsculas
      return fieldValue.toLowerCase().includes(searchName.value.toLowerCase());
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
