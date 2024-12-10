import {onMounted, reactive, ref} from "vue";

export function useClasesScreen(props){
  const name  = ref('Hola');
  const clases = reactive({data: props.clases});

onMounted(()=>{
  console.log("JSON", clases)
});

  return {
    name,
    clases
  }
}
