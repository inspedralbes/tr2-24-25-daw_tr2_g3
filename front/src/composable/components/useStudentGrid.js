import {reactive, ref} from "vue";

export function useStudentGrid(props) {
  const students = reactive({data: props.students});
  const nStudents = ref(props.students.length);
  const teacherId = ref(props.teacherId);

  return{
    students,
    nStudents,
    teacherId
  }
}
