import {onMounted, reactive, ref} from "vue";
import * as com from '@/services/communicationManager.js'
import {GroupIcon} from "lucide-vue-next";
import {getGroupByTeacher} from "@/services/communicationManager.js";
import {useAuthStore} from "@/stores/authStore.js"

export function useClasesView() {
  const modal = ref(false);
  const className = ref('');
  const code = ref(123456)
  const clases = reactive([]);
  const lettersOptions = reactive([]);
  const letterOption = ref('')
  const groupId = ref(null)

  onMounted(async () => {
    const data = await com.getGroupByTeacher(useAuthStore().user.id);
    const combinedData = [].concat(...data);
    clases.push(...combinedData); // Agrega los elementos del array combinado al estado reactivo
    console.log(clases)
  });

  function getIdGrupEmit(id) {
    groupId.value = id
    console.log(groupId.value)
  }

  function openModal() {
    modal.value = true
  }

  function closeModal() {
    modal.value = false;
    className.value = '';
    letterOption.value = '';
  }

  async function saveData() {
    if (validateFieldsNoEmpty()) {
      alert('Campo nombre y letra no pueden estar vacios');
    } else {
      if (validateLetter()) {
        alert('Campo letra solo admite letras y solo un digito')
        emptyFields();
      } else {
        modal.value = false;
        if (validateFields()) {
          alert('Esta clase ya está creada');
          emptyFields();
        } else {
          const data = {
            course: className.value,
            letter: letterOption.value.toUpperCase(),
            members: [],
            user_id: useAuthStore().user.id
          }

          const json = await com.sendClass(data);
          clases.push(json);
          emptyFields();
        }
      }
    }
  }

  function validateFields() {
    // Verifica si el curso con esta letra ya existe en clases
    const existingClass = clases.find(cls => cls.letter === letterOption.value.toUpperCase() && cls.course === className.value);
    return existingClass ? true : false;
  }

  function validateFieldsNoEmpty() {
    const validate = ref(false);
    if (className.value.trim() === '' || letterOption.value.trim() === '') {
      validate.value = true;
    }
    return validate.value;
  }

  function validateLetter() {
    const validate = ref(false);
    if (letterOption.value.length > 1) {
      validate.value = true;
    }

    return validate.value;
  }

  function emptyFields() {
    letterOption.value = '';
    className.value = '';
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
    closeModal,
    getIdGrupEmit,
  }
}
