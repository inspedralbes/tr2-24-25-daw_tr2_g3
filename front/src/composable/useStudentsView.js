import { onBeforeMount, reactive, ref, onMounted, onBeforeUnmount, computed } from 'vue';

export function useStudentsView() {

  // añadir tutor, separar nombre y apellidos, fecha nacimiento ,grade, group,genero, seguridad social, extranjero, nacionalidad, direccion, codigo postal, ciudad, provincia, pais, telefono, email, dni, imagen, observaciones, fecha matricula
  const students = ref([
    { id: 1, name: 'Juan Pérez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '1º ESO', group: 'A' },
    { id: 2, name: 'María López', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '1º ESO', group: 'B' },
    { id: 3, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '2º ESO', group: 'A' },
    { id: 4, name: 'Ana González', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '2º ESO', group: 'B' },
    { id: 5, name: 'Pedro Sánchez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '3º ESO', group: 'A' },
    { id: 6, name: 'Laura Martínez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'laura@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '3º ESO', group: 'B' },
    { id: 7, name: 'Miguel Torres', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'miguel@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '4º ESO', group: 'A' },
    { id: 8, name: 'Lucía Fernández', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'lucia@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '4º ESO', group: 'B' },
    { id: 9, name: 'David García', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'david@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '1º Bachi.', group: 'A' },
    { id: 10, name: 'Sara López', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'sara@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '1º Bachi.', group: 'B' },
    { id: 11, name: 'Pablo Martínez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'pablo@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '2º Bach.', group: 'A' },
    { id: 12, name: 'Elena Sánchez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'elena@gmail.com', phone: '123456789', address: 'Calle Falsa 123', grade: '2º Bachi.', group: 'B' },
  ]);
  
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

  const selectedOption = ref(options.value[0]);

  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  const selectOption = (option) => {
    selectedOption.value = option;
    dropdownOpen.value = false;
  };

  const itemsPerPage = 20;

  const filteredStudents = ref([...students.value]);

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
    // Mandar peticion con la info de search y selectedOption

    // Actualizar el filteredStudents con la respuesta de la peticion

    // Actualizar el nStudents con el numero de resultados

    // Actualizar dropdown con los cursos del profesor

    currentPage.value = 1; // Reset to the first page on search
  };

  const clearSearch = () => {
    search.value = '';
    applyFilter();
  };

  const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
      dropdownOpen.value = false;
    }
  };

  onMounted(() => {
    //cargar todos los students y options

    document.addEventListener('click', handleClickOutside);
  });

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
  });

  return {
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
    clearSearch
  };
}