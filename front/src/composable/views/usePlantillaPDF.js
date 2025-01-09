import {reactive} from "vue";

export function usePlantillaPDF(props) {
  const student = reactive({data: props.student});
  const groups = reactive({data: props.group});

  return {
    student,
    groups
  }
}
