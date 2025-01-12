import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import * as coms from '@/services/communicationManager.js'



export function useStudentView() {

  const name = ref('Kevin');
  const info = ref('Observaciones del estudiante');

  const student = reactive([]);
  const group = reactive([]);

  const router = useRouter();
  const route = useRoute();


  const studentId = route.params.student;
  const teacherId = route.params.teacherId;


  const originalStudent = ref({});

  const crumbs = [
    {text: 'Home', href: '/', icon: 'bi bi-house-fill'},
    {text: 'Estudiants', href: `/students`, icon: ''},
    {text: 'Estudiant', href: `/student/${studentId}`, icon: ''}
  ];

  const editingSection = ref(null);

  onMounted(async () => {
    try {
      const data = await coms.getStudentByID(studentId);

      student.push(data.student);

      group.push(...data.groups);

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

  const contentPDF = null;

  const exportStudent = async () => {
    await coms.exportStudentToPdf(student, group);
  }


  return {
    name,
    crumbs,
    student,
    group,
    originalStudent,
    editingSection,
    info,
    editSection,
    saveSection,
    goBack,
    exportStudent
  }
}

