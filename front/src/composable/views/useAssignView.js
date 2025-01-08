import {reactive, ref} from "vue";

export function useAssignView() {
  const counter = ref(0);
  const seats = reactive(Array(24).fill(null).map((_, index) => ({
    position: index,
    occupied: false,
    users: []
  })));

  function updateCounter(newValue) {
    counter.value = newValue;
  }

  function updateSeats(newSeats) {
    Object.assign(seats, newSeats);
    //console.log('Se han guardado los asientos:', seats);
  }
  function saveSeats(){
    console.log("ASIENTOS TOTAL", seats)
  }

  return {
    counter,
    updateCounter,
    updateSeats,
    saveSeats
  }
}
