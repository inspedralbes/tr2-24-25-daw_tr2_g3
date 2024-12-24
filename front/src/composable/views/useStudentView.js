import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStudent} from "@/stores/useStudent.js";
import * as coms from '@/services/communicationManager.js'

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
  }
}

