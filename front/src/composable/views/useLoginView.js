import {computed, reactive} from 'vue'
import {RouterView, useRoute, useRouter} from 'vue-router'

export function useLoginView(){
  const $router = useRouter()
  const $route = useRoute()

  const user = reactive({})

  return{

  }
}
