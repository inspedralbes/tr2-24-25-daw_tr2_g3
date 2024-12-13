import { onBeforeMount, reactive, ref, onMounted, onBeforeUnmount, computed } from 'vue';
import { getStudentsByTeacher } from '@/services/communicationManager';

export function useStudentsView(teacherId) {

  const crumbs = [
    { text: 'Home', href: '/', icon: 'bi bi-house-fill' },
    { text: 'Estudiants', href: `/students/${teacherId}`, icon:''},
  ];

  const students = ref([]);
  
  const nStudents = ref(students.value.length);
  const currentPage = ref(1);

  const search = ref('');
  const dropdownOpen = ref(false);

  const options = ref([
    {
      id: 3,
      name: "1º ESO - A",
    },
    {
      id: 4,
      name: "1º ESO - B",
    },
    {
      id: 5,
      name: "2º ESO - A",
    },
    {
      id: 6,
      name: "2º ESO - B",
    },
    {
      id: 7,
      name: "3º ESO - A",
    },
    {
      id: 8,
      name: "3º ESO - B",
    },
    {
      id: 9,
      name: "4º ESO - A",
    },
    {
      id: 10,
      name: "4º ESO - B",
    },
    {
      id: 11,
      name: "1º Bachi. - A",
    },
    {
      id: 12,
      name: "1º Bachi. - B",
    },
    {
      id: 13,
      name: "2º Bachi. - A",
    },
    {
      id: 14,
      name: "2º Bachi. - B",
    },
  ]);

  const selectedOption = ref('');

  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  const selectOption = (option) => {
    selectedOption.value = option;
    dropdownOpen.value = false;
    applyFilter();
  };

  const applyFilter = () => {
    filteredStudents.value = students.value.filter(student => {
      return student.grade === selectedOption.value.name.split(' - ')[0] && student.group === selectedOption.value.name.split(' - ')[1];
    });
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1; // Reset to the first page on filter
  };

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

  const searchStudents = () => {
    

    // Actualizar el filteredStudents con la respuesta de la peticion

    // Actualizar el nStudents con el numero de resultados

    // Actualizar dropdown con los cursos del profesor


    //Solución mientras no se implementa la petición
    filteredStudents.value = students.value.filter(student => {
      return student.name.toLowerCase().includes(search.value.toLowerCase()) || student.dni.toLowerCase().includes(search.value.toLowerCase());
    });
    nStudents.value = filteredStudents.value.length;

    currentPage.value = 1; // Reset to the first page on search
  };

  const clearSearch = () => {
    search.value = '';
    filteredStudents.value = [...students.value];
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1;
  };

  const clearOption = () => {
    selectedOption.value = '';
    filteredStudents.value = [...students.value];
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1; // Reset to the first page
  };

  const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
      dropdownOpen.value = false;
    }
  };

  onMounted(async () => {
    //cargar todos los students y options
    students.value = await getStudentsByTeacher(teacherId);
    nStudents.value = students.value.length;
    filteredStudents.value = [...students.value];
    document.addEventListener('click', handleClickOutside);
  });

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
  });

  return {
    crumbs,
    currentPage,
    search,
    dropdownOpen,
    options,
    selectedOption,
    toggleDropdown,
    selectOption,
    students,
    nStudents,
    paginatedStudents,
    totalPages,
    goToPage,
    nextPage,
    previousPage,
    searchStudents,
    clearSearch,
    clearOption,
    applyFilter
  };
}