import {onMounted, reactive, ref} from "vue";

export function useStudentGrid(props) {
  const students = reactive({data: props.students});
  const nStudents = ref(props.students.length);


  onMounted(() => {
    console.log("HIJO: ", students)
  });

  const update = (newStudent) => {
    students.data = newStudent;
  }

  return {
    students,
    nStudents,
  }
}
