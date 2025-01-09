<script>
import {
    ref,
    onMounted
} from 'vue';
import {
    getUserData,
    updateUserData,
    changePassword
} from '@/services/communicationManager';
import LayoutMain from "@/layout/LayoutMain.vue";
import { Notify } from 'quasar';

export default {
    components: {
        LayoutMain
    },
    setup() {
        const userData = ref({
            name: '',
            lastname: '',
            photo_pic: '',
            type_document: '',
            id_document: '',
            birthdate: '',
            email: '',
        });

        const passwordData = ref({
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
        });

        const passwordVisibility = ref({
            currentPassword: false,
            newPassword: false,
            confirmPassword: false
        });

        const inputValues = ref([]); // Array to store input values
        const showModal = ref(false); // State to control modal visibility
        const passwordError = ref(''); // State to store password error message
        const isEditing = ref(false);
        const originalUserData = ref({});

        const fetchUserData = async () => {
            const data = await getUserData();
            if (data) {
                userData.value = data;
            }
        };

        const saveUserData = async () => {
            const response = await updateUserData(userData.value);
            if (response) {
                customAlert('Datos actualizados correctamente', 'possitive', 'info', 'top-right', 2000)
            } else {
                customAlert('Error al actualizar los datos', 'negative', 'warning', 'top-right', 2000)
            }
        };

        const changeUserPassword = async () => {
            if (!passwordData.value.currentPassword || !passwordData.value.newPassword || !passwordData.value.confirmPassword) {
                passwordError.value = 'Todos los campos son obligatorios';
                return;
            }

            if (passwordData.value.newPassword !== passwordData.value.confirmPassword) {
                passwordError.value = 'Las contraseñas no coinciden';
                return;
            }

            passwordError.value = '';

            const response = await changePassword(passwordData.value);
            if (response) {
                customAlert('Contraseña actualizada correctamente', 'possitive', 'info', 'top-right', 2000)
                closeModal();
            } else {
                passwordError.value = 'Error al actualizar la contraseña';
            }
        };

        const saveInputValues = () => {
            inputValues.value = [
                userData.value.name,
                userData.value.lastname,
                userData.value.type_document,
                userData.value.id_document,
                userData.value.birthdate
            ];
        };

        const openModal = () => {
            showModal.value = true;
        };

        const closeModal = () => {
            showModal.value = false;
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

        const toggleEdit = () => {
            if (!isEditing.value) {
                originalUserData.value = {
                    ...userData.value
                };
            } else {
                userData.value = {
                    ...originalUserData.value
                };
            }
            isEditing.value = !isEditing.value;
        };

        const togglePasswordVisibility = (field) => {
            passwordVisibility.value[field] = !passwordVisibility.value[field];
        };

        const onSaveData = async () => {
            await saveUserData();
            isEditing.value = false;
        };

        onMounted(() => {
            fetchUserData();
            saveInputValues();
        });

        return {
            userData,
            passwordData,
            inputValues,
            showModal,
            passwordError,
            fetchUserData,
            saveUserData,
            changeUserPassword,
            saveInputValues,
            openModal,
            closeModal,
            isEditing,
            originalUserData,
            toggleEdit,
            onSaveData,
            togglePasswordVisibility,
            passwordVisibility,
            customAlert,
        };
    }
};
</script>

<template>
<LayoutMain>

    <div>

        <div class="min-h-screen py-8">
            <div class="max-w-4xl mx-auto px-4">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-primary px-8 py-6">
                        <h1 class="text-2xl font-bold text-white">Administració del Perfil</h1>
                    </div>
                    <div class="p-8">
                        <form class="space-y-6">
                            <div class="flex items-center space-x-8">
                                <div class="relative"><img :src="userData.photo_pic || 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?w=400'" alt="Profile" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg"></div>
                                <div>
                                    <h2 class="text-2xl font-semibold text-gray-800">{{ userData.name }} {{ userData.lastname }}</h2>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><label class="block text-sm font-medium text-gray-700">Nombre</label><input type="text" name="name" :disabled="!isEditing" v-model="userData.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Apellidos</label><input type="text" name="lastname" :disabled="!isEditing" v-model="userData.lastname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Tipo de documento</label><select name="type_document" :disabled="!isEditing" v-model="userData.type_document" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="DNI">DNI</option>
                                        <option value="NIE">NIE</option>
                                        <option value="PASSPORT">Passport</option>
                                    </select></div>
                                <div><label class="block text-sm font-medium text-gray-700">ID</label><input type="text" name="id_document" :disabled="!isEditing" v-model="userData.id_document" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label><input type="date" name="birthdate" :disabled="!isEditing" v-model="userData.birthdate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                            </div>
                            <div class="flex justify-between pt-6">
                                <button type="button" @click="openModal" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="bi bi-lock-fill mr-2"></i>
                                    Cambiar Contraseña
                                </button>
                                <div class="flex space-x-2">
                                    <button v-if="isEditing" type="button" @click="toggleEdit" class="inline-flex rounded-md items-center px-4 py-2 border text-gray-700 bg-white hover:bg-gray-50">
                                        Cancelar
                                    </button>
                                    <button type="button" @click="isEditing ? onSaveData() : toggleEdit()" class="inline-flex rounded-md items-center px-4 py-2 border text-white bg-primary">
                                        <template v-if="isEditing">
                                            <i class="bi bi-floppy-fill mr-3"></i>
                                            Guardar
                                        </template>
                                        <template v-else>
                                            Editar Perfil
                                        </template>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="showModal" class="fixed inset-0 fondoOscurecido flex items-center justify-center p-4">
                <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar Contraseña</h3>
                    <form class="space-y-4" @submit.prevent="changeUserPassword">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                            <div class="relative">
                                <input :type="passwordVisibility.currentPassword ? 'text' : 'password'" v-model="passwordData.currentPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" @click="togglePasswordVisibility('currentPassword')">
                                    <template v-if="passwordVisibility.currentPassword">
                                        <!-- Eye-off Icon -->
                                        <i class="bi bi-eye text-2xl"></i>
                                    </template>
                                    <template v-else>
                                        <!-- Eye-off Icon -->
                                        <i class="bi bi-eye-slash text-2xl"></i>
                                    </template>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                            <div class="relative">
                                <input :type="passwordVisibility.newPassword ? 'text' : 'password'" v-model="passwordData.newPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" @click="togglePasswordVisibility('newPassword')">
                                    <template v-if="passwordVisibility.newPassword">
                                        <i class="bi bi-eye text-2xl"></i>
                                    </template>
                                    <template v-else>
                                        <i class="bi bi-eye-slash text-2xl"></i>
                                    </template>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                            <div class="relative">
                                <input :type="passwordVisibility.confirmPassword ? 'text' : 'password'" v-model="passwordData.confirmPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" @click="togglePasswordVisibility('confirmPassword')">
                                    <template v-if="passwordVisibility.confirmPassword">
                                        <i class="bi bi-eye text-2xl"></i>
                                    </template>
                                    <template v-else>
                                        <i class="bi bi-eye-slash text-2xl"></i>
                                    </template>
                                </button>
                            </div>
                        </div>
                        <div v-if="passwordError" class="text-red-500 font-bold text-sm">{{ passwordError }}</div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="closeModal" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Actualitzar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</LayoutMain>
</template>

<style scoped>
/* Add any necessary styles */

.fondoOscurecido {
    background-color: rgb(24, 22, 22, 0.8);
}
</style>
