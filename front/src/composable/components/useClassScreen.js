import {ref} from "vue";

export function useClassScreen() {
  const tab = ref("test");

  // Function to change tab
  const onTabChange = (newTab) => {
    if (newTab !== tab.value) {
      tab.value = newTab
    }
  }

  return {
    tab,
    onTabChange,
  };
}
