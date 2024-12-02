import {ref} from 'vue'

export function useAssignSite(){
  const name = ref('Kevin')
  return{
    name
  }
}
