import {ref} from 'vue'
export function useClassView(){
  const dense = ref(false);
  const code = ref(123456)
  return {
    dense,
    code
  }
}
