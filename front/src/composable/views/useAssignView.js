import {reactive, ref} from "vue";
export function useAssignView(){
  const counter = ref(0);

  function updateCounter(newValue){
    counter.value = newValue;
  }

  return {
    counter,
    updateCounter
  }
}
