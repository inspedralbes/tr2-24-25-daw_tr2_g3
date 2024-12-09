import { onBeforeMount, reactive, ref } from 'vue';

export function useStudentsView() {
  const students = ref([
    { id: 1, name: 'Juan Pérez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123' },
    { id: 2, name: 'María López', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123' },
    { id: 3, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123' },
    { id: 4, name: 'Ana González', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123' },
    { id: 5, name: 'Pedro Sánchez', image: 'https://via.placeholder.com/50', dni: '12345678A', email: 'aasd@gmail.com', phone: '123456789', address: 'Calle Falsa 123' },
  ]);
  
  const search = ref('');

  const nStudents = ref(students.value.length);

  const dropdownOpen = ref(false);

  const options = ref([
    {
      id: 1,
      name: "Nombre",
    },
    {
      id: 2,
      name: "DNI",
    },
    {
      id: 3,
      name: "Curso",
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

  return {
    search,
    dropdownOpen,
    options,
    selectedOption,
    toggleDropdown,
    selectOption,
    students,
    nStudents,
  };
}