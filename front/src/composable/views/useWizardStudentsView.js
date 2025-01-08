import {reactive, ref} from "vue";
import {Notify} from "quasar";
import * as com from '@/services/communicationManager.js'

export function useWizardStudentsView(props) {

  const emailsArray = reactive({email: []});

  const handleSendEmail = async () => {
    const subject = 'Syncblend App';
    const message = 'Esto es un correo con copia oculta';

    props.map(user => emailsArray.email.push(user.user.email));

    console.log(emailsArray.email)

    const response = await com.sendEmail(subject, message, emailsArray.email);

    if (response !== null) {
      customAlert("Correo enviado correctamente.", "positive", "info", "top-right", 2000);
    } else {
      customAlert("Error al enviar el correo.", "negative", "info", "top-right", 2000);
    }
    console.log(response)
  };

  const customAlert = (text, color, icon, position, time) => {
    Notify.create({
      message: text,
      color: color,
      icon: icon,
      position: position,
      timeout: time
    });
  }

  return {
    handleSendEmail,
  }

}