import {defineStore} from "pinia";

export const useStudent = defineStore('student', {
  state: () => ({
    studentID: null
  }),
  actions: {
    setIdStudent(newID) {
      this.studentID = newID;
    }
  }


});
