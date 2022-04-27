<template>
  <div id="app" class="overflow-hidden">
    <dashboard-card
      :users="getUsers"
      :list_users="listOfUsers"
      :number="numberOfStudents"
      :list_permission="listStuPermission"
      :list_discipline="listStuDiscipline"

      :class_WebA_2021="countwebA2021"
      :class_WebB_2021="countwebB2021"
      :class_SNA_2021="countSNA2021"
      
      :class_WebA_2022="countwebA2022"
      :class_WebB_2022="countwebB2022"
      :class_SNA_2022="countSNA2022"

      :class_WebA_2023="countwebA2023"
      :class_WebB_2023="countwebB2023"
      :class_SNA_2023="countSNA2023"

    >
    </dashboard-card>
  </div>
</template>

<script>
import axios from "../../api/api.js";
import DashBoardCard from "../pages/Dashboard/DashboardCard.vue";
export default {
  components: {
    "dashboard-card": DashBoardCard,
  },
  name: "team",
  data() {
    return {
      listOfUsers: 0,
      numberOfStudents: 0,
      listStuPermission: 0,
      listStuDiscipline: 0,
      getUsers: [],
      studentDatas: [],
      //~~~~~~~~~~~~~~~~~~~~~|-COUNT STUDENT BY CLASS 2021-|~~~~~~~~~~~~~~~~~~~~~//
      countwebA2021: 0,
      countwebB2021: 0,
      countSNA2021: 0,
      //~~~~~~~~~~~~~~~~~~~~~|-COUNT STUDENT BY CLASS 2022-|~~~~~~~~~~~~~~~~~~~~~//

      countwebA2022: 0,
      countwebB2022: 0,
      countSNA2022: 0,
      //~~~~~~~~~~~~~~~~~~~~~|-COUNT STUDENT BY CLASS 2023-|~~~~~~~~~~~~~~~~~~~~~//

      countwebA2023: 0,
      countwebB2023: 0,
      countSNA2023: 0,
    };
  },
  methods: {
    // currentDateTime() {
    //   let today = new Date();
    //   let date =
    //     today.getFullYear() +
    //     "-" +
    //     (today.getMonth() + 1) +
    //     "-" +
    //     today.getDate();
    //   let time =
    //     today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    //   this.dateTime = date + " " + time;
    //   console.log(this.dateTime);
    //   return this.dateTime;
    // },
  },
  computed: {},
  mounted() {
    // this.currentDateTime();
    //~~~~~~~~~~~~~~~~~~~~|*GET USER*|~~~~~~~~~~~~~~~~~~~~//
    axios.get("/users").then((res) => {
      this.listOfUsers = res.data.length;
      this.getUsers = res.data;
    });

    //~~~~~~~~~~~~~~~~~~~~|*GET STUDENT*|~~~~~~~~~~~~~~~~~~~~//
    axios.get("/students").then((res) => {
      this.numberOfStudents = res.data.length;
      this.newStudent = res.data;
      for (let newStu of this.newStudent) {
        if (newStu.create_at === this.dateTime) {
          this.countNewStu += 1;
        } else {
          this.countNewStu += 0;
        }
      }
      console.log(this.countNewStu);
    });

    //~~~~~~~~~~~~~~~~~~~~|*COUNT STUDENT CLASS WEB-A 2021*|~~~~~~~~~~~~~~~~~~~~//
    axios.get("/students").then((res) => {
      this.studentDatas = res.data;
      for (let classes of this.studentDatas) {
        if (classes.class === "WEB 2021 A") {
          this.countwebA2021 += 1;
        } else if (classes.class === "WEB 2021 B") {
          this.countwebB2021 += 1;
        } else if (classes.class === "WEB 2022 A") {
          this.countwebA2022 += 1;
        } else if (classes.class === "WEB 2022 B") {
          this.countwebB2022 += 1;
        } else if (classes.class === "SNA 2021") {
          this.countSNA2021 += 1;
        } else if (classes.class === "SNA 2022") {
          this.countSNA2022 += 1;
        } else if (classes.class === "WEB 2023 A") {
          this.countwebA2023 += 1;
        } else if (classes.class === "WEB 2023 B") {
          this.countwebB2023 += 1;
        } else if (classes.class === "SNA 2023") {
          this.countSNA2023 += 1;
        } else {
          this.countwebA2021 += 0;
          this.countwebB2021 += 0;
          this.countwebA2022 += 0;
          this.countwebB2022 += 0;
          this.countSNA2021 += 0;
          this.countSNA2022 += 0;
          this.countwebA2023 += 0;
          this.countwebB2023 += 0;
          this.countSNA2023 += 0;
        }
      }
      console.log(this.countwebA2021);
    });

    //~~~~~~~~~~~~~~~~~~~~|*GET STUDENT PERMISSION*|~~~~~~~~~~~~~~~~~~~~//
    axios.get("/permissions").then((res) => {
      this.listStuPermission = res.data.length;
    });

    //~~~~~~~~~~~~~~~~~~~~|*GET STUDENT DISCIPLINE*|~~~~~~~~~~~~~~~~~~~~//
    axios.get("/disciplines").then((res) => {
      this.listStuDiscipline = res.data.length;
    });
  },
};
</script>


<style scoped>
</style>