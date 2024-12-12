import {onMounted, reactive, ref} from "vue";
import * as com from '@/services/communicationManager.js'

export function useClasesView() {
  const modal = ref(false);
  const className = ref('');
  const code = ref(123456)
  const clases = reactive([]);
  const lettersOptions = reactive([
  ]);
  const letterOption = ref(lettersOptions.find(option => option.value === 'A'))

  onMounted(async () => {
    const data = await com.getGroup(1);
    clases.push(data)

    const letters = await com.getLetters();
    console.log("A", letters)

    //lettersOptions.push(letters);
    // Transformar los datos recibidos a la estructura deseada
    const transformedLetters = letters.map(letter => ({label: letter.toLowerCase(), value: letter.toLowerCase()}));
    lettersOptions.splice(0, lettersOptions.length, ...transformedLetters);
  });


  function openModal() {
    modal.value = true
  }

  function closeModal() {
    modal.value = false;
    className.value = ''
  }

  function saveData() {
    if (className.value === '') {
      console.log('NO puede')
    } else {
      console.log("Nom", className.value)
      modal.value = false
      const data = {
        course: className.value,
        letter: letterOption.value.value,
        year: new Date().getFullYear(),
        members: []
      }
      const json = com.sendClass(data);
      clases.push(json);
      className.value = '';
    }
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
    closeModal
  }
}
