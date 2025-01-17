import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStudent} from "@/stores/useStudent.js";
import * as coms from '@/services/communicationManager.js'
import html2pdf from 'html2pdf.js';
import PlantillaPDF from "@/views/PlantillaPDF.vue";

export function useStudentView() {

  const name = ref('Kevin');

  const student = reactive([]);
  const group = reactive([]);

  const router = useRouter();
  const route = useRoute();


  const studentId = route.params.student;
  const teacherId = route.params.teacherId;


  const originalStudent = ref({});

  const crumbs = [
    {text: 'Home', href: '/', icon: 'bi bi-house-fill'},
    {text: 'Estudiants', href: `/students/${teacherId}`, icon: ''},
    {text: 'Estudiant', href: `/student/${teacherId}/${studentId}`, icon: ''}
  ];

  const editingSection = ref(null);

  onMounted(async () => {
    try {
      console.log("Id Padre: ", studentId);
      const data = await coms.getStudentByID(studentId);
      console.log("JSON", data);

      student.push(data.student);
      console.log("JSON STUDENT", student);

      group.push(...data.groups);
      console.log("JSON GROUP", group);

    } catch (error) {
      console.error("Error fetching student data:", error);
    }
  });


  const editSection = (section) => {
    if (editingSection.value === section) {
      student.value = {...originalStudent.value}; // Discard changes
      editingSection.value = null;
    } else {
      originalStudent.value = {...student.value}; // Save original data
      editingSection.value = section;
    }
  };

  const saveSection = () => {
    // Logic to save the edited information
    editingSection.value = null;

    //Fetch a la base de datos para guardar los cambios
  };

  const goBack = () => {
    router.back();
  };

  const exportStudent = () => {
    console.log("json", student)
    console.log("json group", group)
    const content = PlantillaPDF.default

    student.forEach(studen => {
      const options = {
        filename: `${studen.name}_${studen.lastname}.pdf`,
        image: {
          type: 'jpeg',
          quality: 0.98
        },
        html2pdf: {
          dpi: 192,
          letterRendering: true,
          useCORS: true
        },
        jsPDF: {
          unit: 'mm',
          format: 'a4',
          orientation: 'portrait'
        }
      };
      html2pdf()
        .from(content)
        .set(options)
        .save();
    });


  }


  return {
    name,
    crumbs,
    student,
    group,
    originalStudent,
    editingSection,
    editSection,
    saveSection,
    goBack,
    exportStudent
  }
}

