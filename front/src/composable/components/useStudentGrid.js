import {computed, onBeforeMount, onMounted, reactive, ref} from "vue";
import {useRouter} from "vue-router";
import {useStudent} from "@/stores/useStudent.js";

export function useStudentGrid(props) {
  const students = reactive({data: props.students});
  const nStudents = ref(props.students.length);
  const router = useRouter();


  onMounted(() => {

  });

  function infoCard(id) {
    console.log("INDEX: ", id);
    router.push({
      name: 'student',
      params: {student: id}
    });
  }


  return {
    students,
    nStudents,
    infoCard
  }
}
