<script setup>
import { ref, reactive, onMounted, onUnmounted } from "vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import { io } from 'socket.io-client';
import { searchUsersByName, searchOrCreateChat, getChats, getMessages, setStatusOnline, setStatusOffline, getStatus } from "@/services/communicationManager.js";
import { useAuthStore } from "@/stores/authStore";

const socket = io('http://localhost:3000');
const messageContent = ref(''); // Contenido del mensaje a enviar
const chats = ref([]); // Variable reactiva para almacenar los chats
const selectedChat = ref(null); // Variable reactiva para almacenar el chat seleccionado
const searchQuery = ref("");
const searchResults = ref([]);
let debounceTimeout = null;
const authStore = useAuthStore();
const currentUserId = authStore.user.id;

const loadChats = async () => {
  try {
    const data = await getChats(); // Obtener chats desde la API
    chats.value = data;
  } catch (error) {
    console.error("Error loading chats:", error);
  }
};

// Llama a loadChats al montar el componente
onMounted(() => {
  loadChats();

  socket.on('connect', () => {
    // console.log('Socket connected:', socket.id);
  });

  // Escuchar mensajes nuevos
  socket.on('newMessage', (message) => {
    if (selectedChat.value && message.chatId === selectedChat.value.chatId) {
      selectedChat.value.messages.push(message);
    }
  });
});

onUnmounted(() => {
  // Limpiar eventos de Socket.IO
  socket.off('newMessage');
});

// Unirse a un chat
const joinChat = (chatId) => {
  socket.emit('joinChat', chatId);
};

// Enviar un mensaje
const sendMessage = () => {
  if (!messageContent.value.trim()) return;

  const message = {
    chatId: selectedChat.value.chatId,
    senderId: currentUserId, 
    content: messageContent.value,
    time: new Date().toISOString(),
    token: authStore.token, // Agregar token aquí
  };

  // Emitir mensaje al servidor
  socket.emit('sendMessage', message);

  messageContent.value = ''; // Limpiar campo de entrada
};

// Función para obtener avatar, name y lastname
function getChatUserInfo(chatId) {
  // Buscar el chat con el ID proporcionado
  const chat = chats.value.find(c => c.id === chatId);
  console.log(chat)
  console.log(chats.value);
  
  
  if (!chat) {
    return null;
  }

  // Retornar la información del usuario
  return {
    avatar: chat.user.avatar,
    name: chat.user.name,
    lastname: chat.user.lastname
  };
}

// Función para cargar el chat completo al hacer clic
const loadChatDetails = async (chatId) => {
  try {
    joinChat(chatId); 
    const data = await getMessages(chatId); // Obtener los mensajes del chat seleccionado

    // Crear un array de mensajes procesados
    const messages = [];
    for (let i = 0; i < data.length; i++) {
      messages.push({
        content: data[i].content,
        senderId: data[i].sender_id,
        time: data[i].created_at,
      });
    }
    loadChats();
    // Crear el chat con los mensajes formateados
    const chat = {
      chatId: chatId,
      messages: messages,
      user: getChatUserInfo(chatId),
    };
    selectedChat.value = chat; // Asignar el chat seleccionado
  } catch (error) {
    console.error("Error loading chat details:", error);
  }
};

const searchUsers = async () => {
  try {
    const results = await searchUsersByName(searchQuery.value);
    searchResults.value = results || [];
  } catch (error) {
    console.error('Error searching users:', error);
    searchResults.value = [];
  }
};

const debouncedSearch = () => {
  // Clear timeout
  clearTimeout(debounceTimeout);
  
  debounceTimeout = setTimeout(() => {
    searchUsers();
  }, 600); // 600ms = 0.6 segundos
};

const clearSearch = () => {
  searchQuery.value = "";
  searchResults.value = [];
};

const createChat = async (username) => {
  const data = await searchOrCreateChat(username);
   
  const existingIndex = chats.value.findIndex(c => c.id === data.id);
  if (existingIndex >= 0) {
    const [existing] = chats.value.splice(existingIndex, 1);
    chats.value.unshift(existing);
  } else {
    chats.value.unshift(data);
  }
  await loadChats();
  await loadChatDetails(data.id)
  //selectedChat.value = data.id;
  clearSearch();
};

const handleUserSelection = async (user) => {
  try {
    await createChat(user.name);
  } catch (error) {
    console.error("Error selecting user:", error);
  }
};

const getUserStatus = async () => {
  const chatId = selectedChat.value.id;
  const userId = currentUserId; 
  const status = await getStatus(chatId, userId);
  console.log("Estado del usuario:", status);
};


// Función para actualizar el estado en tiempo real
const updateStatus = async (chatId, status) => {
  try {
    if (status === 'online') {
      await setStatusOnline(chatId);
    } else {
      await setStatusOffline(chatId);
    }
    loadChats();
  } catch (error) {
    console.error("Error updating status:", error);
  }
};
</script>

<template>
  <LayoutMain>
    <template #title>
      Mis mensajes
    </template>

    <div class="h-[80vh] flex bg-gray-50">
      <div class="w-96 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-200">
          <div class="flex flex-row items-center space-x-2">
            
            <!-- Input -->
            <input
            v-model="searchQuery"
            type="text"
            placeholder="Search users..."
            class="flex-1 px-1 py-2 bg-gray-100 rounded-lg text-gray-600 focus:outline-none"
            @input="debouncedSearch"
            @keyup.enter="searchUsers"
            />

            <!-- Button "Clear" -->
            <button
              v-if="searchResults.length"
              @click="clearSearch"
              class="px-3 py-2 bg-red-500 text-white rounded-lg"
            >
            <i class="bi bi-x-lg"></i>
            </button>

          </div>
          <!-- Dropdown -->
          <div v-if="searchQuery" class="mt-2 bg-white border border-gray-200 rounded shadow">
            <div v-if="searchResults.length > 0">
              <div
                v-for="user in searchResults"
                :key="user.name"
                class="flex cursor-pointer px-4 py-2 hover:bg-gray-50 items-center font-bold text-gray-500"
                @click="handleUserSelection(user)"
              >
                <img :src="user.photo_pic" :alt="user.name" class="w-10 h-10 rounded-full object-cover mr-3" />
                {{ user.name }} {{ user.lastname }}
              </div>
            </div>
            <div v-else class="px-4 py-2 text-gray-500 font-bold">
              No results found
            </div>
          </div>
        </div>
        <!-- List of chats -->
        <div class="flex-1 overflow-y-auto">
          <button v-for="chat in chats" :key="chat.id" class="w-full p-4 flex items-center space-x-4" @click="loadChatDetails(chat.id)">
            <div class="relative">
              <img :src="chat.user.avatar" :alt="chat.user.name" class="w-12 h-12 rounded-full object-cover" />
              <div class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white" :class="chat.user.status === 'Online' ? 'bg-green-500' : 'bg-gray-500'"></div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-baseline">
                <p class="text-sm font-medium text-gray-900 truncate">{{ chat.user.name }} {{ chat.user.lastname }}</p>
                <span class="text-xs text-gray-500">{{ new Date(chat.lastMessage.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</span>
              </div>
              <p class="text-sm text-gray-500 truncate">{{ chat.lastMessage.content }}</p>
            </div>
          </button>
        </div>
      </div>

      <!-- Conversación seleccionada -->
      <div class="flex-1 flex flex-col">
        <div v-if="selectedChat" class="h-16 px-6 flex items-center border-b border-gray-200 bg-white">
          <div class="flex items-center space-x-4">
            <img :src="selectedChat.user.avatar" :alt="selectedChat.user.name" class="w-10 h-10 rounded-full object-cover" />
            <div>
              <h2 class="text-lg font-semibold text-gray-900">{{ selectedChat.user.name }} {{ selectedChat.user.lastname }}</h2>
              <p class="text-sm text-gray-500">{{ selectedChat.user.status }}</p>
            </div>
          </div>
        </div>

        <!-- Mensajes -->
        <div v-if="!selectedChat" class="flex-1 flex items-center justify-center bg-gray-50">
          <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user text-gray-400">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Select a conversation</h3>
            <p class="text-gray-500">Choose a conversation or start a new one</p>
          </div>
        </div>
        <!-- Formulario para enviar mensaje -->
        <div v-if="selectedChat && selectedChat.messages" class="flex-1 p-6 overflow-y-auto bg-gray-50">
          <div v-for="message in selectedChat.messages" :key="message.messageId" class="mb-4">
            <div :class="message.senderId === currentUserId ? 'text-right' : 'text-left'">
              <p class="text-sm font-medium text-gray-900">{{ message.senderId === currentUserId ? 'You' : selectedChat.user.name }}:</p>
              <p class="text-sm text-gray-700">{{ message.content }}</p>
              <span class="text-xs text-gray-500">{{ new Date(message.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</span>
            </div>
          </div>
        </div>
        <form v-if="selectedChat" @submit.prevent="sendMessage" class="p-4 bg-white border-t border-gray-200">
          <div class="flex items-center space-x-4">
            <input
              v-model="messageContent"
              type="text"
              placeholder="Type a message..."
              class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:outline-none"
            />
            <button
              type="submit"
              class="p-2 rounded-full bg-primary text-white hover:bg-blue-700 focus:outline-none"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send">
                <path d="m22 2-7 20-4-9-9-4Z"></path>
                <path d="M22 2 11 13"></path>
              </svg>
            </button>
          </div>
        </form>

      </div>
    </div>
  </LayoutMain>
</template>

<style scoped>
/* Agrega estilos aquí si es necesario */
</style>
