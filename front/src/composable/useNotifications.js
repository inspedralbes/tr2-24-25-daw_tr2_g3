import {useQuasar} from 'quasar';

export function useNotifications() {

  const $q = useQuasar();

  const showNotification = () => {
    $q.notify({
      message: '¡Esta es una notificación!',
      color: 'positive',
      timeout: 3000,
      position: 'top-right',
      icon: 'notifications',
    });
  };

  return {
    showNotification
  }
}
