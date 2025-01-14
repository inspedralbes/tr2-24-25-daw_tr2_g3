import {ref} from "vue";

export function useClassScreen() {
  const tab = ref("test");

  // Function to change tab
  const onTabChange = (newTab) => {
    if (newTab !== tab.value) {
      // console.log("Tab antiguo:", tab.value);
      tab.value = newTab
      // console.log("Tab nuevo:", tab.value);
    }
  }


  return {
    tab,
    onTabChange,
  };
}
