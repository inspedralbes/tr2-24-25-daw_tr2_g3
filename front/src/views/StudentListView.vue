<script setup>

const props = defineProps({
  dataProps: {
    type: Object,
    required: true
  }
})

console.log(props.dataProps)

</script>

<template>
  <span class="text-xl font-bold">Lista de estudiantes</span>
  {{props.dataProps}}
</template>

<style scoped>

</style>
