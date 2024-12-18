import {ref} from "vue";
import {Notify} from "quasar";
import * as com from '@/services/communicationManager.js'

export function useWizardStudentsView() {



  const handleSendEmail = async () => {
    const subject = 'Notificación';
    const message = 'Enhorabuena, has podido enviar un correo desde la App';
    const recipientEmail = 'a23brijaemed@inspedralbes.cat';

    await com.sendEmail(subject, message, recipientEmail);
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

  return{
    handleSendEmail,
  }

}
