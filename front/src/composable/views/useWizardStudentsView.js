import {onMounted, reactive, ref} from "vue";
import {Notify} from "quasar";
import * as com from '@/services/communicationManager.js'
import {useNotifications} from "@/composable/useNotifications.js";
import {useAuthStore} from "@/stores/authStore.js";

export function useWizardStudentsView(props) {

  const emailsArray = reactive({email: []});
  const wizards = props
  const showModal = ref(false);
  const columns = reactive([
    { field: 'total_agresivitat', label: 'Total Agresivitat' },
    { field: 'agresivitat_fisica', label: 'Agresivitat Física' },
    { field: 'agresivitat_verbal', label: 'Agresivitat Verbal' },
    { field: 'agresivitat_relacional', label: 'Agresivitat Relacional' },
    { field: 'prosocialitat', label: 'Prosocialitat'},
    { field: 'total_victimizacion', label: 'Total Victimizació'},
    { field: 'victimizacion_fisica', label: 'Victimizació Física'},
    { field: 'victimizacion_verbal', label: 'Victimizació Verbal'},
    { field: 'victimizacion_relacional', label: 'Victimizació Relacional'},
    { field: 'popular', label: 'Popular'},
    { field: 'rebutjat', label: 'Rebutjat'},
    { field: 'ignorat', label: 'Ignorat'},
    { field: 'controvertit', label: 'Controvertit'},
    { field: 'normatiu', label: 'Normatiu'},

  ]);

  const rows = reactive({data:[]});

  const formSelected = reactive({data:{}})

  // const handleSendEmail = async () => {
  //   const subject = 'Syncblend App';
  //   const message = 'Esto es un correo con copia oculta';
  //
  //   props.map(user => emailsArray.email.push(user.user.email));
  //
  //   console.log(emailsArray.email)
  //
  //   const response = await com.sendEmail(subject, message, emailsArray.email);
  //
  //   if (response !== null) {
  //     customAlert("Correo enviado correctamente.", "positive", "info", "top-right", 2000);
  //   } else {
  //     customAlert("Error al enviar el correo.", "negative", "info", "top-right", 2000);
  //   }
  //   console.log(response)
  // };

  const customAlert = (text, color, icon, position, time) => {
    Notify.create({
      message: text,
      color: color,
      icon: icon,
      position: position,
      timeout: time
    });
  }

  const seeDetails = async(form)=>{
    console.log(form)
    showModal.value = true;
    const response = await com.getResultsForm(form.id, form.group_id);
    console.log(response)
    formSelected.data = form
    useNotifications().showNotification(response.message, response.status)
  }

  const activate = async(form)=>{
    console.log(form)
    const response = await com.initForm(form.group_id, form.id);
    console.log(response)
    const { showNotification } = useNotifications();

    if (response.status==="success")
    {
      showNotification(response.message, "success");
      console.log(response)
    }else{
      showNotification(response.message, 'error')
      console.log("error")
    }
  }

  const calculate = async()=>{
    console.log(formSelected.data)
    const response = await com.calculateCESC(formSelected.data.id);
    console.log(response);
  }

  onMounted(()=>{

  })

  return {
    // handleSendEmail,
    wizards,
    seeDetails,
    activate,
    showModal,
    columns,
    rows,
    calculate
  }

}
