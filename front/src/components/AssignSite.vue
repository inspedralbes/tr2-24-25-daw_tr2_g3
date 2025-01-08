<script setup>
import {useAssignSite} from "@/composable/components/useAssignSite.js";

const emit = defineEmits(['counter', 'save-seats']);
const assignSite = useAssignSite(emit);
</script>
<template>
    <q-layout container style="height: 800px">
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="flex q-gutter-md">
            <q-card class="card-drawing">
              <q-card-section>
                <div class="flex gap-6 justify-center">
                  <div v-for="(seat, index) in assignSite.seats" :key="index" class="flex q-gutter-md">
                    <q-card @click="assignSite.clickName(index)" class="card-student">
                      <q-card-section class="flex justify-center">
                        <div v-if="seat.occupied" class="flex q-gutter-md justify-center">
                          <img class="img-student" :src="seat.users[0].image">
                          <p>{{ seat.users[0].firstname }} {{ seat.users[0].lastname }}</p>
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
