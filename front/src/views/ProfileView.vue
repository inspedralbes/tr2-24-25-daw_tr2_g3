<script setup>
import { ref, onMounted } from 'vue';
import { getUserData, updateUserData, changePassword } from '@/services/communicationManager';
import LayoutMain from "@/layout/LayoutMain.vue";

const userData = ref({
  name: '',
  lastname: '',
  photo_pic: '',
  type_document: '',
  id_document: '',
  birthdate: '',
  email: '',
  // ...other user fields...
});

const passwordData = ref({
  currentPassword: '',
  newPassword: '',
  confirmPassword: ''
});

const fetchUserData = async () => {
  const data = await getUserData();
  if (data) {
    userData.value = data;
  }
};

const saveUserData = async () => {
  const response = await updateUserData(userData.value);
  if (response) {
    alert('Datos actualizados correctamente');
  } else {
    alert('Error al actualizar los datos');
  }
};

const changeUserPassword = async () => {
  if (passwordData.value.newPassword !== passwordData.value.confirmPassword) {
    alert('La confirmación de la contraseña no coincide');
    return;
  }
  const response = await changePassword(passwordData.value);
  if (response) {
    alert('Contraseña actualizada correctamente');
  } else {
    alert('Error al actualizar la contraseña');
  }
};

onMounted(fetchUserData);
</script>

<template>
<LayoutMain>
  <template #title>
    Perfil
  </template>

  <template #icon>
    <i class="bi bi-person-circle"></i>
  </template>
  <template #subtitle>
    Configuración del perfil
  </template>

  <div>
    <form @submit.prevent="saveUserData">
      <div>
        <label for="name">Nombre:</label>
        <input v-model="userData.name" id="name" type="text" />
      </div>
      <div>
        <label for="lastname">Apellido:</label>
        <input v-model="userData.lastname" id="lastname" type="text" />
      </div>
      <div>
        <label for="photo_pic">Foto:</label>
        <input v-model="userData.photo_pic" id="photo_pic" type="text" />
      </div>
      <div>
        <label for="type_document">Tipo de Documento:</label>
        <select v-model="userData.type_document" id="type_document">
          <option value="DNI">DNI</option>
          <option value="NIE">NIE</option>
          <option value="PASSPORT">PASSPORT</option>
        </select>
      </div>
      <div>
        <label for="id_document">ID Documento:</label>
        <input v-model="userData.id_document" id="id_document" type="text" />
      </div>
      <div>
        <label for="birthdate">Fecha de Nacimiento:</label>
        <input v-model="userData.birthdate" id="birthdate" type="date" />
      </div>
      <div>
        <label for="email">Email:</label>
        <input v-model="userData.email" id="email" type="email" />
      </div>
      <!-- Add more fields as needed -->
      <button type="submit">Guardar</button>
    </form>

    <form @submit.prevent="changeUserPassword">
      <div>
        <label for="currentPassword">Contraseña Actual:</label>
        <input v-model="passwordData.currentPassword" id="currentPassword" type="password" />
      </div>
      <div>
        <label for="newPassword">Nueva Contraseña:</label>
        <input v-model="passwordData.newPassword" id="newPassword" type="password" />
      </div>
      <div>
        <label for="confirmPassword">Confirmar Nueva Contraseña:</label>
        <input v-model="passwordData.confirmPassword" id="confirmPassword" type="password" />
      </div>
      <button type="submit">Cambiar Contraseña</button>
    </form>
  </div>

</LayoutMain>
</template>

<style scoped>
/* Add any necessary styles */
</style>

<!-- 

Como configurarias el profileView para que permita editar los datos del usuario que ha iniciado session

un usuario tiene la siguiente información:

name, lastname, photo_pic, type_document[DNI, NIE, PASSPORT], id_document, birthdate,password

añade que se pueda cambiar el password si sabe el antiguo password, el nuevo password y la confirmacion del nuevo password

dale una apariencia professional a la gestion del perfil

-->
