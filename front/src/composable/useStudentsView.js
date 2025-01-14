import {onBeforeMount, reactive, ref, onMounted, onBeforeUnmount, computed} from 'vue';
import {getStudentsByTeacher} from '@/services/communicationManager.js';
import jsPDF from "jspdf";
import "jspdf-autotable";  // Asegúrate de importar el módulo AutoTable
import logo from '@/assets/logo.png'
import {useAuthStore} from "@/stores/authStore.js";

export function useStudentsView() {

  const crumbs = [
    {text: 'Home', href: '/', icon: 'bi bi-house-fill'},
    {text: 'Estudiants', href: `/students`, icon: ''},
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
    {label: 'curso', value: 'curso'},
    {label: 'letra', value: 'letra'}
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
    selectedOption.value = option.label;
    dropdownOpen.value = false;

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
      const searchValue = search.value.toLowerCase();

      if (!search.value) {
        students.splice(0, students.length, ...copystudents);
      } else if (selectedOption.value === 'curso') {
        const filteredStudents = students.filter(student => {
          // Filter by course
          return student.groups.some(group => group.course.toLowerCase().includes(searchValue));
        });
        students.splice(0, students.length, ...filteredStudents); // Sobreescribe el arreglo 'students'


      } else if (selectedOption.value === 'letra') {
        const filteredStudents = students.filter(student => {
          // Filter by course
          return student.groups.some(group => group.letter.toLowerCase().includes(searchValue));
        });
        students.splice(0, students.length, ...filteredStudents); // Sobreescribe el arreglo 'students'

      } else {
        const filterStudent = students.filter(student => {
          return ['name', 'lastname', 'id_document'].some(key =>
            student[key].toLowerCase().includes(searchValue)
          );
        });
        students.splice(0, students.length, ...filterStudent); // Sobreescribe el arreglo 'students'
      }
      nStudents.value = students.length;
    }
  ;


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

    // Configurar los datos de la tabla
    const headers = [["Nombre", "Apellido", "Tipo", "Numero Documento", "Grupos"]];
    const data = students.map((student) => [
      student.name,
      student.lastname,
      student.type_document.toUpperCase(),
      student.id_document,
      student.groups.map((group) => `${group.course} - ${group.letter}`).join(", "),
    ]);


    //Logo
    const imgData = logo

    // Agregar la tabla al PDF
    doc.autoTable({
      head: headers,
      body: data,
      //startY:37,
      theme: 'grid',
      headStyles: {
        fillColor: [28, 27, 23],
        textColor: [255, 255, 255],
        fontStyle: "bold",
        halign: "center",
        fontsize: 10
      },
      bodyStyles: {
        fontsize: 10,
        halign: "center"
      },
      margin: {
        top: 35,
        bottom: 15
      },
      styles: {
        overflow: "linebreak"
      },
      didDrawPage: (data) => {
        //Agregar titulo al PDF
        doc.setFont('FX Neofara Thin', 'bold');
        doc.setFontSize(16)
        doc.text("Lista de Estudiantes", 80, 20);

        //RESPONSABLE
        doc.setFont('FX Neofara Thin', 'bold');
        doc.setFontSize(12);
        doc.text(`Responsable: Kevin`, 14, 28);

        //Fecha
        doc.setFont("FX Neofara Thin", 'bold');
        doc.setFontSize(12);
        doc.text(`Fecha: ${new Date().toLocaleDateString()}`, 167, 28);

        doc.addImage(logo, 'PNG', 14, 4, 18, 16); // Coordenadas x, y, ancho, alto
      }
    });

    // Obtener el total de páginas
    setTimeout(() => {
      // Obtener el total de páginas
      const pageCount = doc.internal.getNumberOfPages();

      // Agregar número de página en todas las páginas
      for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i); // Establecer la página actual
        doc.setFontSize(10);
        doc.text(
          `${i} de ${pageCount}`, // Texto del número de página
          doc.internal.pageSize.width - 20, // Posición X
          doc.internal.pageSize.height - 9 // Posición Y
        );
      }

      // Guardar el PDF
      doc.save("Listat_Estudiants.pdf")
    }, 1000); // Espera 5 segundos
  }

  onBeforeMount(async () => {
    //cargar todos los students y options
    const data = await getStudentsByTeacher(useAuthStore().user.id);
    const combinedData = [].concat(...data);

    students.push(...combinedData);
    copystudents.push(...combinedData);

    console.log("Json", students)

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
    groups,
    optionsFilter,
    exportStudents
  };
}
