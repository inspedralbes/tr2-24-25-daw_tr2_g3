<script setup>
import {useWizardView} from "@/composable/useWizardView.js";

const wizardView = useWizardView()
</script>

<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <div class="my-div d-flex justify-center align-items-center">
          <!-- Contenido del div -->
          <h2>Contenido centrado</h2>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<style lang="sass" scoped>

.my-div
  background-color: $dark-light
  border: 1px solid white
  text-align: center
  border-radius: 8px
</style>
