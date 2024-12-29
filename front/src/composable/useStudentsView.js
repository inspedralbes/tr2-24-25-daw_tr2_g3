import {onBeforeMount, reactive, ref, onMounted, onBeforeUnmount, computed} from 'vue';
import {getStudentsByTeacher} from '@/services/communicationManager.js';
import jsPDF from "jspdf";
import "jspdf-autotable";  // Asegúrate de importar el módulo AutoTable



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

  const options = reactive([
    {
      id: 3,
      name: "1",
    },
    {
      id: 4,
      name: "2",
    }
  ]);

  const optionsFilter = reactive([
    {label: 'year', value: 'year'},
    {label: 'course', value: 'course'},
    {label: 'letter', value: 'letter'}
  ]);

  const groups = reactive([]);

  const selectedOption = ref('');

  const copystudents = reactive([]); // Variable reactiva para almacenar los estudiantes filtrados
  const itemsPerPage = 10;


  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  const selectOption = (option) => {
    console.log("aA", option)
    selectedOption.value = option;
    dropdownOpen.value = false;
    applyFilter();
    console.log("sss", applyFilter())
  };

  const applyFilter = () => {
    //return students.map(student => student.groups);
    return groups;
    /*
    filteredStudents.value = students.filter(student => {
      return student.grade === selectedOption.value.name.split(' - ')[0] && student.group === selectedOption.value.name.split(' - ')[1];
    });*/

    nStudents.value = students.length;
    currentPage.value = 1; // Reset to the first page on filter
  };


  const paginatedStudents = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return students.slice(start, end);
  });

  const totalPages = computed(() => {
    return Math.ceil(students.length / itemsPerPage);
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
    if (!search.value) {
      students.splice(0, students.length, ...copystudents);
    } else {
      const filterStudent = students.filter(student => {
        const searchValue = search.value.toLowerCase();
        return ['name', 'lastname', 'id_document'].some(key =>
          student[key].toLowerCase().includes(searchValue)
        );
      });
      students.splice(0, students.length, ...filterStudent); // Sobreescribe el arreglo 'students'
    }
    nStudents.value = students.length;
  };


  const clearSearch = () => {
    search.value = '';
    students.splice(0, students.length, ...copystudents);
    nStudents.value = students.length;
    currentPage.value = 1;
  };

  const clearOption = () => {
    selectedOption.value = '';
    students.splice(0, students.length, ...copystudents);
    nStudents.value = students.length;
    currentPage.value = 1; // Reset to the first page
  };

  const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
      dropdownOpen.value = false;
    }
  };

  const exportStudents = () => {
    console.log("ESTUDIANTES", students);
    const doc = new jsPDF();

    //Agregar titulo al PDF
    doc.setFontSize(16)
    doc.text("Lista de Estudiantes", 14, 20);

    // Configurar los datos de la tabla
    const headers = [["Nombre", "Apellido", "ID Documento", "Grupos"]];
    const data = students.map((student) => [
      student.name,
      student.lastname,
      student.id_document,
      student.groups.map((group) => `${group.course} - ${group.letter}`).join(", "),
    ]);

    // Agregar la tabla al PDF
    doc.autoTable({
      head: headers,
      body: data,
      startY: 30, // Donde empieza la tabla en el PDF
    });

    doc.save("Listat_Estudiants.pdf")

  }

  onBeforeMount(async () => {
    //cargar todos los students y options
    const data = await getStudentsByTeacher(1);
    const combinedData = [].concat(...data);

    students.push(...combinedData);
    copystudents.push(...combinedData);

    for (let i = 0; i < students.length; i++) {
      groups.push(students[i].groups);
    }

    nStudents.value = students.length;
  });

  onMounted(() => {
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
    itemsPerPage,
    goToPage,
    nextPage,
    previousPage,
    searchStudents,
    clearSearch,
    clearOption,
    applyFilter,
    groups,
    optionsFilter,
    exportStudents
  };
}
