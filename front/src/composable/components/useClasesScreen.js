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
  const seletecdOption = ref(optionsFilter.find(option => option.value === "name"));
  const groupId = ref(null);


  onBeforeMount(() => {
  });

  function navigateToClass(dataClass) {

    router.push({
      name: 'class',
      params: {id: dataClass.id, tab: ''},
      query: {data: JSON.stringify(dataClass)}
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
    seletecdOption,
    getFilteredClasses,
    getIdGroup,
    navigateToClass,
  }
}
