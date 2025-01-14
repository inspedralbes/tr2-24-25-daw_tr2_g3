import {computed, reactive, ref} from "vue";

export function useStudentsListView(props) {

  const nStudents = ref(props.length);
  const currentPage = ref(1);
  const itemsPerPage = 20;
  const filteredStudents = ref([]);

  const paginatedStudents = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredStudents.value.slice(start, end);
  });

  const totalPages = computed(() => {
    return Math.ceil(filteredStudents.value.length / itemsPerPage);
  });

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
      currentPage.value = page;
    }
  };

  const nextPage = () => {
    if (currentPage.value < totalPages.value) {
      currentPage.value++;
    }
  };

  const previousPage = () => {
    if (currentPage.value > 1) {
      currentPage.value--;
    }
  };

  return {
    nStudents,
    currentPage,
    goToPage,
    nextPage,
    previousPage,
  }
}
