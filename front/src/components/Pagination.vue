<template>
  <div class="flex justify-center mt-6 mb-0 md:mt-6 md:mb-6">
    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
      <!-- Previous -->
      <button
        @click="$emit('previousPage')"
        :disabled="currentPage === 1"
        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
      >
        <span class="sr-only">Previous</span>
        <i class="bi bi-chevron-left"></i>
      </button>
      <!-- Pages -->
      <span
        v-for="page in totalPages"
        :key="page"
        @click="$emit('goToPage', page)"
        :class="[
          'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium cursor-pointer',
          currentPage === page ? 'bg-primary text-white'  : 'text-gray-500 hover:bg-gray-50 hover:!text-black'
        ]"
      >
        {{ page }}
      </span>
      <!-- Next -->
      <button
        @click="$emit('nextPage')"
        :disabled="currentPage === totalPages"
        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
      >
        <span class="sr-only">Next</span>
        <i class="bi bi-chevron-right"></i>
      </button>
    </nav>
  </div>
</template>

<script>
import { computed } from 'vue';

export default {
  name: 'Pagination',
  props: {
    totalItems: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      default: 20
    },
    currentPage: {
      type: Number,
      required: true
    }
  },
  setup(props) {
    const totalPages = computed(() => {
      return Math.ceil(props.totalItems / props.itemsPerPage);
    });

    return {
      totalPages
    };
  }
};
</script>