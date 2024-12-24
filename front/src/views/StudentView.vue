<script setup>
import LayoutMain from '@/layout/LayoutMain.vue';
import BreadCrumbs from '@/components/BreadCrumbs.vue';
import {useStudentView} from "@/composable/views/useStudentView.js";


const student = useStudentView();

</script>

<template>
  <LayoutMain>
    <template #breadcrumbs>
      <BreadCrumbs :crumbs=student.crumbs></BreadCrumbs>
    </template>

    <template #title>
      <div class="flex justify-between items-center" v-for="(stu, index) in student.student">
        <div class="flex flex-row items-center">
          <div class="flex flex-row items-center mr-4">
            <img :src="stu.photo_pic" :alt="stu.name" class="w-32 h-32 rounded-full"/>
            <div class="flex flex-col ml-4">
              <div class="text-3xl font-bold">{{ stu.name }} {{ stu.lastname }}</div>
              <div v-for="(group,index) in student.group">
                <span class="text-xl font-semibold">{{ group.course }} - {{ group.letter }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!--DATOS DE INFORMACION PERSONAL-->
      <div class="border p-8 rounded-lg shadow-md bg-white relative" v-for="(stu, index) in student.student">
        <button @click="student.editSection('personal')"
                class="edit-button absolute top-4 right-4 bg-primary text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
          <i class="bi bi-pencil"></i>
        </button>
        <div class="font-bold text-3xl mb-6"><i class="bi bi-person mr-4"></i>Información Personal</div>
        <div v-if="student.editingSection.value === 'personal'">
          <div class="text-lg leading-loose"><span class="font-bold">Fecha de Nacimiento: </span><input
            v-model="stu.birthdate" class="editable-input"/></div>
          <div class="text-lg leading-loose"><span class="font-bold">Género: </span><input v-model="stu.gender"
                                                                                           class="editable-input"/>
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Seguridad Social: </span><input
            v-model="stu.social_security_number" class="editable-input"/></div>
          <div class="text-lg leading-loose"><span class="font-bold">Nacionalidad: </span><input
            v-model="stu.nationality" class="editable-input"/></div>
          <div class="text-lg leading-loose"><span class="font-bold">DNI: </span><input v-model="stu.id_document"
                                                                                        class="editable-input"/></div>
          <button @click="student.saveSection"
                  class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">
            Guardar
          </button>
        </div>
        <div v-else>
          <div class="text-lg leading-loose"><span class="font-bold">Fecha de Nacimiento: </span>{{ stu.birthdate }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Género: </span>{{ stu.gender }}</div>
          <div class="text-lg leading-loose"><span class="font-bold">Seguridad Social: </span>{{
              stu.socialSecurity
            }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Nacionalidad: </span>{{ stu.nationality }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">DNI: </span>{{ stu.id_document }}</div>
        </div>
      </div>
      <!--DATOS DE INFORMACION ACADEMICA-->
      <div class="border p-8 rounded-lg shadow-md bg-white relative" v-for="(group, index) in student.group">

        <button @click="student.editSection('academic')"
                class="edit-button absolute top-4 right-4 bg-primary text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
          <i class="bi bi-pencil"></i>
        </button>

        <div class="font-bold text-3xl mb-6"><i class="bi bi-mortarboard"></i> Información Académica</div>

        <div v-if="student.editingSection.value === 'academic'">

          <div v-for="(tutor, index) in group.tutor">
            <div class="text-lg leading-loose"><span class="font-bold">Tutor: </span><input
              v-model="tutor.user.name "
              class="editable-input"/></div>
          </div>

          <div class="text-lg leading-loose"><span class="font-bold">Fecha de Matrícula: </span><input
            v-model="student.enrollmentDate" class="editable-input"/></div>

          <div class="text-lg leading-loose"><span class="font-bold">Grado: </span><input v-model="group.course"
                                                                                          class="editable-input"/></div>

          <div class="text-lg leading-loose"><span class="font-bold">Grupo: </span><input v-model="group.code"
                                                                                          class="editable-input"/></div>

          <button @click="student.saveSection"
                  class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">
            Guardar
          </button>

        </div>
        <div v-else>
          <div v-for="(tutor,index ) in group.tutor">
            <div class="text-lg leading-loose"><span class="font-bold">Tutor: </span>{{ tutor.user.name }}
              {{ tutor.user.lastname }}
            </div>
          </div>
          <div class="text-lg leading-loose"><span
            class="font-bold">Fecha de Matrícula: </span>{{ group.created_at }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Grado: </span>{{ group.course }} {{ group.letter }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Grupo: </span>{{ group.code }}</div>
        </div>
      </div>
      <!--DATOS DE INFORMACION DE CONTACTO-->
      <div class="border p-8 rounded-lg shadow-md bg-white relative" v-for="(stu, index) in student.student">
        <button @click="student.editSection('contact')"
                class="edit-button absolute top-4 right-4 bg-primary text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
          <i class="bi bi-pencil"></i>
        </button>
        <div class="font-bold text-3xl mb-6"><i class="bi bi-telephone"></i> Información de Contacto</div>
        <div v-if="student.editingSection.value === 'contact'">
          <div class="text-lg leading-loose"><span class="font-bold">Dirección: </span><input v-model="stu.address"
                                                                                              class="editable-input"/>
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Código Postal: </span><input
            v-model="stu.postal_code" class="editable-input"/></div>
          <div class="text-lg leading-loose"><span class="font-bold">Ciudad: </span><input v-model="stu.city"
                                                                                           class="editable-input"/>
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Provincia: </span><input v-model="stu.province"
                                                                                              class="editable-input"/>
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Teléfono: </span><input v-model="stu.phone"
                                                                                             class="editable-input"/>
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Email: </span><input v-model="stu.email"
                                                                                          class="editable-input"/></div>
          <div class="h-[40px]"></div>
          <button @click="student.saveSection"
                  class="save-button bg-green-400 text-white px-4 py-2 rounded-full shadow-md mt-2">Guardar
          </button>
        </div>
        <div v-else>
          <div class="text-lg leading-loose"><span class="font-bold">Dirección: </span>{{ stu.address }}</div>
          <div class="text-lg leading-loose"><span class="font-bold">Código Postal: </span>{{ stu.postal_code }}
          </div>
          <div class="text-lg leading-loose"><span class="font-bold">Ciudad: </span>{{ stu.city }}</div>
          <div class="text-lg leading-loose"><span class="font-bold">Provincia: </span>{{ stu.province }}</div>
          <div class="text-lg leading-loose"><span class="font-bold">Teléfono: </span>{{ stu.phone }}</div>
          <div class="text-lg leading-loose"><span class="font-bold">Email: </span>{{ stu.email }}</div>
          <div class="h-[40px]"></div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
      <div class="p-8 border rounded-lg shadow-md bg-white relative">
        <button @click="student.editSection('observations')"
                class="edit-button absolute top-4 right-4 bg-primary text-white w-10 h-10 rounded-full shadow-md flex items-center justify-center">
          <i class="bi bi-pencil"></i>
        </button>
        <div class="font-bold text-xl mb-2"><i class="bi bi-sticky"></i> Observaciones</div>
        <div v-if="student.editingSection.value === 'observations'">
          <textarea v-model="student.observations" class="w-full text-lg editable-input"></textarea>
          <button @click="student.saveSection"
                  class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2">
            Guardar
          </button>
        </div>
        <div v-else class="text-lg">
          {{ student.observations }}
          <button @click="student.saveSection"
                  class="save-button bg-green-400 text-white px-4 py-2 rounded-lg shadow-md mt-2"
                  style="visibility: hidden;">Guardar
          </button>
        </div>
      </div>
      <div class="p-8 border rounded-lg shadow-md bg-white">
        <div class="font-bold text-xl mb-2"><i class="bi bi-bar-chart"></i> Gráfico</div>
        <!-- Aquí va el gráfico -->
        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
          <span class="text-gray-500">El grafico de mi pana</span>
        </div>
      </div>
    </div>
  </LayoutMain>
</template>

<style scoped>
.save-button {
  position: absolute;
  bottom: 16px;
  left: 32px;
}

.edit-button {
  transition: background-color 0.4s;
}

.edit-button:hover {
  background-color: #7FD3E6 !important;
}

.editable-input {
  line-height: 10px;
  margin-left: 5px;
  border: 1px solid black;
  border-radius: 5px;
}
</style>
