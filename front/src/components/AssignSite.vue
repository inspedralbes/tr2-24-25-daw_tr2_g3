<script setup>
import {useAssignSite} from "@/composable/components/useAssignSite.js";

const assignSite = useAssignSite();
</script>
<template>
  <div>
    <q-layout view="lHh lpr lFf" container style="height: 400px">
      <q-header elevated>
        <q-toolbar>
          <q-btn flat round dense icon="menu" class="q-mr-sm" />
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>

          <q-toolbar-title>Quasar Framework</q-toolbar-title>

          <q-btn flat round dense icon="whatshot" />
        </q-toolbar>
      </q-header>

      <q-footer elevated>
        <q-toolbar>
          <q-toolbar-title>Footer</q-toolbar-title>
        </q-toolbar>
      </q-footer>

    </q-layout>
  </div>
</template>
<style scoped>

</style>
