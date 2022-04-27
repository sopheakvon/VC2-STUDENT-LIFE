<template>
  <div>
    <v-btn
      v-if="role !== 'STUDENT'"
      @click.stop="showCreateForm"
      depressed
      bottom
      class="mb-8"
      color="deep-orange"
      dark
      fab
      fixed
      right
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
    <v-dialog
      v-model="dialog"
      max-width="700"
      transition="dialog-top-transition"
    >
      <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-CREATE FORM DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
      <v-card>
        <v-toolbar color="primary" class="lighten-1" dark>
          {{ dialogTitle }}
        </v-toolbar>
        <div v-if="dialogMode !== 'delete'">
          <v-card-text class="mt-5">
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="first_name"
                    :rules="firstnameRules"
                    label="First Name"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="last_name"
                    :rules="lastnameRules"
                    label="Last Name"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-radio-group :rules="genderRules" v-model="gender" row>
                <v-radio label="Male" value="Male"></v-radio>
                <v-radio label="Female" value="Female"></v-radio>
              </v-radio-group>

              <v-select
                v-model="class_name"
                prepend-icon="mdi-school"
                label="Class"
                :rules="classRules"
                :items="student_class"
                item-text="class_group"
                required
              >
              </v-select>

              <v-text-field
                v-model="phonenumber"
                :rules="phonenumberRules"
                prepend-icon="mdi-phone"
                label="Phone Number"
                required
              ></v-text-field>

              <v-file-input
                v-if="dialogMode !== 'edit'"
                v-model="profile"
                :rules="profileRules"
                label="Choose profile image "
                prepend-icon="mdi-camera"
              >
              </v-file-input>
            </v-form>
          </v-card-text>
        </div>

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-REMOVE DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div v-else>
          <v-card-text class="mt-5">
            <v-alert outlined type="error" prominent border="left">
              Are you sure to delete this student?
            </v-alert>
          </v-card-text>
        </div>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="warning" @click="closeDialog"> close </v-btn>
          <v-btn :color="dialogColor" :disabled="!valid" @click="onConfirm">
            {{ dialogButton }}
          </v-btn>
        </v-card-actions>

      </v-card>
    </v-dialog>

    <div class="container mt-12" v-if="role !== 'STUDENT' ">
      <v-alert
        dense
        text
        type="success"
        v-if="this.messageAlert !== ''"
        dismissible
        elevation="2"
      >
        {{ messageAlert }}
      </v-alert>
      <student-form-search
        @searchByStudentname="searchStudentName"
        @SelectClass="selectByClass"
      >
      </student-form-search>
      <v-simple-table>
        <template v-slot:default >
          <thead >
            <tr class="tableHead font-weight-bold text-caption" >
              <th>Profile</th>
              <th>FirstName</th>
              <th>LastName</th>
              <th>Gender</th>
              <th>Class_name</th>
              <th>Phone Number</th>
              <th class="text-center" v-if="role !== 'STUDENT'">Action</th>
            </tr>
          </thead>
          <tbody v-if="!isSearch">
            <student-card
              class="font-weight-bold"
              v-for="student in students"
              :key="student.id"
              :student="student"
              @studentEdit="showEditForm"
              @studentDelete="showDeleteDialog"
              @studentData="getDataFormCard"
            >
            </student-card>
          </tbody>
          <tbody v-else>
            <student-card
              class="font-weight-medium text-caption"
              v-for="student in contain_student_search"
              :key="student.id"
              :student="student"
              @studentEdit="showEditForm"
              @studentDelete="showDeleteDialog"
              @studentData="getDataFormCard"
            >
            </student-card>
          </tbody>
        </template>
      </v-simple-table>
    </div>
    <div class="container mt-12" v-else>
      <student-detail> </student-detail>
    </div>
  </div>
</template>
<script>
import axios from "../../api/api.js";
import StudentFormSearch from "../pages/students/StudentFormSearch.vue";
import StudentCard from "../pages/students/StudentCard.vue";
import StudentDetail from "./StudentDetailView.vue";

export default {
  components: {
    "student-card": StudentCard,
    "student-form-search": StudentFormSearch,
    "student-detail": StudentDetail
  },
  data() {
    return {
      role: "",
      students: [],
      url: "http://localhost:8000/storage/images/",
      dialog: false,
      dialogMode: "create",
      valid: true,
      show1: false,
      studentAction: {},
      dialogDisplay: false,
      student_class: [],

      messageAlert: "",
      contain_student_search: [],
      isSearch: false,
      key_class_search: "",
      // Data from input
      first_name: null,
      last_name: null,
      gender: null,
      class_name: null,
      phonenumber: null,
      profile: "",

      // Rule of input data
      firstnameRules: [(v) => !!v || "Firstname is required"],
      lastnameRules: [(v) => !!v || "Lastname is required"],
      genderRules: [(v) => !!v || "Gender is required"],
      classRules: [(v) => !!v || "Class is required"],
      phonenumberRules: [(v) => !!v || "PhoneNumber is required"],
      profileRules: [(v) => !!v || "Profile is required"],
      // data get from backend
    };
  },
  methods: {
    getDataFormCard(student) {
      console.log(student)
    },
    getStudent() {
      axios
        .get("/students")
        .then((res) => {
          if (!this.isSearch) {
            this.students = res.data;
            this.countStudent = res.data.length
          } else {
            this.contain_student_search = res.data.filter((student) =>
              student.class
                .toLowerCase()
                .includes(this.key_class_search.toLowerCase())
            );
          }
        })
        .catch((error) => {
          console.log(error.res.data.errors);
        });
    },
    // **********************|~SHOW CREATE FORM DIALOG~|********************** //
    showCreateForm() {
      this.dialogMode = "create";
      this.dialog = true;
      this.messageAlert = "";

      if (this.dialogMode === "create") {
        this.$refs.form.reset();
      }
    },
    // ---------------------------- SHOW EDIT FORM --------------------------- \\
    showEditForm(studentData) {
      this.dialogMode = "edit";
      this.dialog = true;
      this.messageAlert = "";

      this.studentAction = studentData;

      console.log(this.studentAction.id);

      this.first_name = studentData.first_name;
      this.last_name = studentData.last_name;
      this.gender = studentData.gender;
      this.class_name = studentData.class;
      this.phonenumber = studentData.phone;
      this.profile = studentData.profile;
    },
    // **********************|~SHOW REMOVE DIALOG~|********************** //
    showDeleteDialog(id) {
      this.studentAction = {
        id: id,
      };
      this.dialogMode = "delete";
      this.dialog = true;
    },
    // **********************|~CLOSE FORM DIALOG~|********************** //
    closeDialog() {
      this.dialog = false;
      if (this.dialogMode !== "delete") {
        this.$refs.form.reset();
      }
    },

    // **********************|~CONFIRM DIALOG~|********************** //
    onConfirm() {
      if (this.dialogMode === "create") {
        this.creatStudent();
      } else if (this.dialogMode === "edit") {
        this.updateStudent();
      } else {
        this.deleteStudent();
      }
    },

    // },
    // **********************|~CREATE NEW STUDENT~|********************** //
    creatStudent() {
      if (this.$refs.form.validate()) {
        let studentInfo = new FormData();
        studentInfo.append("first_name", this.first_name);
        studentInfo.append("last_name", this.last_name);
        studentInfo.append("gender", this.gender);
        studentInfo.append("profile", this.profile);
        studentInfo.append("phone", this.phonenumber);
        studentInfo.append("class", this.class_name);

        console.log(studentInfo);
        axios.post("/students", studentInfo).then(() => {
          this.closeDialog();
          this.getStudent();
          this.messageAlert = "Created success";
          console.log(this.messageAlert);
        });
      }
    },

    // ---------------------------------- UPDAE STUDENT ------------------------ \\
    updateStudent() {
      let newData = {
        first_name: this.first_name,
        last_name: this.last_name,
        gender: this.gender,
        class: this.class_name,
        phone: this.phonenumber,
      };

      axios
        .put("/students/" + this.studentAction.id, newData)
        .then((response) => {
          console.log(response.data);
          this.messageAlert = "Update success";
          this.getStudent();
          this.closeDialog();
        });
    },
    // **********************|~REMOVE STUDENT~|********************** //
    deleteStudent() {
      let id = this.studentAction.id;
      axios.delete("/students/" + id).then(() => {
        this.students = this.students.filter((student) => student.id !== id);
        this.contain_student_search = this.contain_student_search.filter(
          (student) => student.id !== id
        );
        this.messageAlert = "Delete success";
        this.closeDialog();
      });
    },

    //==========================SEARCH PERMISSION BY USERNAME AND CLASS ============================================================
    // Search By Username-----------------------------------------------------------------------------
    searchStudentName(stu_name_key, class_key) {
      if (
        (stu_name_key !== "" && class_key !== "ALL CLASS") ||
        (stu_name_key === "" && class_key !== "ALL CLASS")
      ) {
        console.log("search", stu_name_key, class_key);
        this.contain_student_search = this.students.filter(
          (student) =>
            (student.first_name
              .toLowerCase()
              .includes(stu_name_key.toLowerCase()) ||
              student.last_name
                .toLowerCase()
                .includes(stu_name_key.toLowerCase())) &&
            student.class.toLowerCase().includes(class_key.toLowerCase())
        );
      } else {
        this.contain_student_search = this.students.filter(
          (student) =>
            student.first_name
              .toLowerCase()
              .includes(stu_name_key.toLowerCase()) ||
            student.last_name.toLowerCase().includes(stu_name_key.toLowerCase())
        );
      }
      this.isSearch = true;
    },
    //Search By select Class---------------------------------------------------------------------------
    selectByClass(class_key) {
      if (class_key === "ALL CLASS") {
        this.getStudent();
        this.isSearch = false;
      } else {
        this.key_class_search = class_key;
        console.log(class_key);
        this.contain_student_search = this.students.filter((student) =>
          student.class.toLowerCase().includes(class_key.toLowerCase())
        );
        this.isSearch = true;
      }
    },
  },
  computed: {
    dialogTitle() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE NEW STUDENT";
      } else if (this.dialogMode === "edit") {
        message = "UPDATE STUDENT";
      } else if (this.dialogMode === "delete") {
        message = "DELETE STUDENT";
      }
      return message;
    },
    dialogButton() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE";
      } else if (this.dialogMode === "edit") {
        message = "UPDATE";
      } else if (this.dialogMode === "delete") {
        message = "REMOVE";
      }
      return message;
    },
    dialogColor() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "primary";
      } else if (this.dialogMode === "edit") {
        message = "success";
      } else if (this.dialogMode === "delete") {
        message = "error";
      }
      return message;
    },
  },
  mounted() {
    axios.get("/class").then((res) => {
      this.student_class = res.data.class;
      console.log(this.student_class);
    });

    this.getStudent();
    this.role = localStorage.getItem('role');
  },
};
</script>

<style scoped>
.tableHead {
  background: #00b7ff;
}
</style>
