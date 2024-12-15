import {onBeforeMount, reactive, ref, onMounted, onBeforeUnmount, computed} from 'vue';
import {getStudentsByTeacher} from '@/services/communicationManager.js';

export function useStudentsView() {

  const crumbs = [
    {text: 'Home', href: '/', icon: 'bi bi-house-fill'},
    {text: 'Estudiants', href: `/students/${1}`, icon: ''},
  ];

  const students = reactive([]);

  const nStudents = ref(0);
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

  const copystudents = reactive([]); // Variable reactiva para almacenar los estudiantes filtrados


  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  const selectOption = (option) => {
    selectedOption.value = option;
    dropdownOpen.value = false;
    applyFilter();
  };

  const applyFilter = () => {
    filteredStudents.value = students.filter(student => {
      return student.grade === selectedOption.value.name.split(' - ')[0] && student.group === selectedOption.value.name.split(' - ')[1];
    });
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1; // Reset to the first page on filter
  };

  const itemsPerPage = 20;

  const filteredStudents = computed(() => { // Usar computed para calcular el filtro
    if (!students.length || !selectedOption.value) return [];
    return students.filter(student => {
      return student.grade === selectedOption.value.name.split(' - ')[0] && student.group === selectedOption.value.name.split(' - ')[1];
    });
  });

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

    const filterStudent = students.filter(student => {
      return student.name.toLowerCase().includes(search.value.toLowerCase());
    })

    console.log("AAA: ", filterStudent);

    //students.splice(0, students.length, ...filterStudent); // Sobreescribe el arreglo 'students'
  };

  const prueba = computed(() => {
    if (!search.value) {
      return students;
    } else {
      return students.filter(student => {
        return student.name.toLowerCase().includes(search.value.toLowerCase());
      });
    }
  });

  const clearSearch = () => {
    search.value = '';
    filteredStudents.value = [...students]; // Copia directa desde students
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1;
  };

  const clearOption = () => {
    selectedOption.value = '';
    filteredStudents.value = [...students];
    nStudents.value = filteredStudents.value.length;
    currentPage.value = 1; // Reset to the first page
  };

  const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
      dropdownOpen.value = false;
    }
  };

  onBeforeMount(async () => {
    //cargar todos los students y options
    const data = await getStudentsByTeacher(1);
    const combinedData = [].concat(...data);
    students.push(...combinedData); // Agrega los elementos del array combinado al estado reactivo
    nStudents.value = students.length;
  });

  onMounted(async () => {
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
    applyFilter,
    prueba
  };
}
