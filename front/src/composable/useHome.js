import {onBeforeMount, onMounted, ref} from "vue";


export default function useHome(){
  const test = ref("test");
  onMounted(()=>{

  });

  onBeforeMount(()=>{

  });

  return{
    test
  }
}
