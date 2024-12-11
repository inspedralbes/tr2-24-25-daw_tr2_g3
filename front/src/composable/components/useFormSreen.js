import { reactive, ref } from 'vue';

export function useFormScreen() {
  const name = ref('');
  const description = ref ('');
  const isModalOpen = ref(false);
  const formsJSON = reactive([
    {
          "id": 1,
          "name": "Formulario de Inscripción",
          "description": "Formulario utilizado para registrar nuevos estudiantes en el sistema."
        },
        {
          "id": 2,
          "name": "Formulario de Encuesta",
          "description": "Encuesta para evaluar la satisfacción de los usuarios con el servicio."
        },
        {
          "id": 3,
          "name": "Formulario de Contacto",
          "description": "Formulario para recopilar información de contacto de clientes potenciales."
        },
        {
          "id": 4,
          "name": "Formulario de Feedback",
          "description": "Formulario para obtener retroalimentación sobre un producto o servicio."
        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        }
  ]);

  const openModal = () => {
    isModalOpen.value = true;
  };

  const closeModal = () => {
    isModalOpen.value = false;
  };

  return {
    name,
    description,
    isModalOpen,
    openModal,
    closeModal,
    formsJSON,
  };
}
