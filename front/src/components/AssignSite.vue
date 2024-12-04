<script setup>
import {useAssignSite} from "@/composable/components/useAssignSite.js";

const assignSite = useAssignSite();
</script>
<template>
  <div>
    <q-layout view="lHh lpr lFf" container style="height: 800px">
      <q-header elevated style="background-color: #23272F; padding: 8px;">
        <q-toolbar>
          <q-btn flat round dense icon="menu" class="q-mr-sm"/>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>

          <q-toolbar-title>Quasar Framework</q-toolbar-title>

          <q-btn flat round dense icon="account_circle"/>
        </q-toolbar>
      </q-header>

      <q-page-container>
        <q-page class="q-pa-md">

          <div class="q-pa-sm flex">
            <div class="info-class">
              <h4 class="q-mb-none q-mt-none">Class 2 - A</h4>
              <div class="q-mt-sm flex items-center">
                <q-icon name="groups" size="md" class="q-mr-xs"></q-icon>
                <span>0 students</span>
              </div>
            </div>

            <div class="btns-class flex justify-between items-center">
              <q-btn icon="compare_arrows" color="info">Aleatorio</q-btn>
              <q-btn icon="save" color="positive" @click="assignSite.saveAssigned()">Guardar</q-btn>
            </div>
          </div>


          <div class="flex q-gutter-md">
            <q-card class="card-drawing">
              <q-card-section>
                <div class="flex q-gutter-md">
                  <div v-for="(student, index) in assignSite.studentsPlaceholder" :key="index" class="flex q-gutter-md">
                    <q-card @click="assignSite.clickName(index)" class="card-student">
                      <q-card-section class="flex justify-center">
                        <div v-if="assignSite.students[index]" class="flex q-gutter-md justify-center">
                          <img class="img-student" :src="assignSite.students[index].image">
                          <p>{{ assignSite.students[index].firstname }} {{ assignSite.students[index].lastname }}</p>
                        </div>
                        <div v-else class="flex justify-center">
                          <img src="https://cdn-icons-png.flaticon.com/512/6676/6676023.png" class="img-student">
                          <p>VACIO</p>
                        </div>
                      </q-card-section>
                    </q-card>
                  </div>

                </div>
              </q-card-section>
            </q-card>
          </div>

        </q-page>
      </q-page-container>


      <!--      <q-footer elevated style="background-color: #23272F">-->
      <!--        <q-toolbar>-->
      <!--          <q-toolbar-title>Footer</q-toolbar-title>-->
      <!--        </q-toolbar>-->
      <!--      </q-footer>-->

    </q-layout>
  </div>
</template>
<style scoped>

.info-class {
  width: 70%;
}

.btns-class {
  width: 30%;
}

.card-student {
  width: 100%;
  max-width: 120px; /* Tamaño máximo para pantallas grandes */
  border-radius: 10%;
}

.img-student {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover; /* Evita distorsión de la imagen */
}
</style>
