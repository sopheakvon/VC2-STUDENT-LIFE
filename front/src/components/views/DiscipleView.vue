<template>
  <v-container>
    <v-btn
      v-if="role === 'ADMIN'"
      depressed
      @click.stop="showCreateForm"
      bottom
      color="deep-orange"
      dark
      fab
      fixed
      right
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
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
          <v-card-text class="mt-2">
            <v-form ref="form" v-model="valid" lazy-validation>
              <!--**************|~SELECT STUDENT~|**************-->
              <v-col cols="12" class="d-flex me-4">
                <v-combobox
                  :rules="studentRules"
                  prepend-icon="mdi-account-multiple"
                  label="Choose"
                  v-model="student_id"
                  :items="ListOfStudents"
                  item-text="first_name"
                  item-value="id"
                  :return-object="true"
                >
                  <template v-slot:item="data">
                    <template>
                      <v-list-item-avatar>
                        <img :src="stu_profile + data.item.profile" />
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title
                          v-html="
                            data.item.first_name + ' ' + data.item.last_name
                          "
                        ></v-list-item-title>
                        <v-list-item-subtitle
                          v-html="data.item.class"
                        ></v-list-item-subtitle>
                      </v-list-item-content>
                    </template>
                  </template>
                </v-combobox>

              </v-col>
              <!--**************|~SELECT DISCIPLINE TYPE~|**************-->
              <v-col class="d-flex" cols="12">
                <v-select
                  prepend-icon="mdi-format-list-bulleted-type"
                  v-model="notic_type"
                  :items="discipline_type"
                  label="Select notic type"
                  :rules="notic_type_rule"
                ></v-select>
              </v-col>
              <!--**************|~SELECT DATE~|**************-->
              <v-col cols="12">
                <v-menu
                  v-model="isDateSelected"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="discipline_date"
                      :rules="date_rule"
                      label="Back on *"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="discipline_date"
                    @input="isDateSelected = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <!--**************|~DESCRIPTION~|**************-->
              <v-col cols="12">
                <v-textarea
                  v-model="description"
                  prepend-icon="mdi-comment"
                  auto-grow
                  label="DESCRIPTION*"
                  rows="1"
                  :rules="descriptionRule"
                ></v-textarea>
              </v-col>
            </v-form>
          </v-card-text>
        </div>

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-REMOVE DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div v-else>
          <v-card-text class="mt-5">
            <v-alert outlined type="error" prominent border="left">
              Are you sure to delete this discipline?
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
    <div class="container mt-5">
      <!--~~~~~~~~~~~~~~~~~~~~~~~~|ALERT INFORMATION|~~~~~~~~~~~~~~~~~~~~~~~~-->
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
      <!--~~~~~~~~~~~~~~~~~~~~~~~~|FORM SEARCH|~~~~~~~~~~~~~~~~~~~~~~~~-->
      <disciplines-search v-if="role !== 'STUDENT' "
        @searchByAny="searchAnyKey"
        @selectByType="selectType"
      ></disciplines-search>
      <!--~~~~~~~~~~~~~~~~~~~~~~~~|CARD|~~~~~~~~~~~~~~~~~~~~~~~~-->
      <div >
        <div v-if="!isSearch">
          <disciplines-card
            v-for="discipline of DisciplineData"
            :key="discipline.id"
            :discipline="discipline"
            @disciplineToDelete="showDialogDelete"
            @disciplineToEdit="showDialogEdit"
          >
          </disciplines-card>
        </div>
        <div v-else>
          <disciplines-card
            v-for="discipline of contain_discipline_search"
            :key="discipline.id"
            :discipline="discipline"
            @disciplineToDelete="showDialogDelete"
            @disciplineToEdit="showDialogEdit"
          >
          </disciplines-card>
        </div>
      </div>
      <div v-if="DisciplineData.length === 0 " class="mt-12">
        <h1 class="grey--text text-center">Empty!</h1>
      </div>
    </div>
  </v-container>
</template>

<!--~~~~~~~~~~~~~~~~~~~~~~~~|SCRIPT|~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
import axios from "../../api/api.js";
import DisciplinesCard from "../pages/Disciplines/DisciplineCard.vue";
import DisciplinesSearch from "../pages/Disciplines/DisciplineSearch.vue";

export default {
  components: {
    "disciplines-card": DisciplinesCard,
    "disciplines-search": DisciplinesSearch,
  },
  data() {
    return {
      role: "",
      stu_profile: "http://localhost:8000/storage/images/",
      DisciplineData: [],
      contain_discipline_search: [],
      ListOfStudents: [],
      discipline_type: [],
      isSearch: false,
      key_notic_search: "",
      disciplineAction: {},
      dialogMode: "create",
      valid: true,
      dialog: false,
      messageAlert: "",

      student_id: null,
      notic_type: "",
      description: "",
      discipline_date: new Date(
        Date.now() - new Date().getTimezoneOffset() * 60000
      )
        .toISOString()
        .substr(0, 10),

      isDateSelected: false,

      date_rule: [(v) => !!v || "Please select date"],
      notic_type_rule: [(v) => !!v || "Please select notic type"],
      descriptionRule: [(v) => !!v || "Please input description detail"],
      studentRules: [(v) => !!v || "Student is required!"],
    };
  },
  computed: {
    // **********************|~TITLE DIALOG~|********************** //
    dialogTitle() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE NEW DISCIPLINE";
      } else if (this.dialogMode === "edit") {
        message = "EDIT THE DISCIPLINE";
      } else if (this.dialogMode === "delete") {
        message = "DELETE THE DISCIPLINE";
      }
      return message;
    },
    // **********************|~BUTTON DIALOG~|********************** //
    dialogButton() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE";
      } else if (this.dialogMode === "edit") {
        message = "UPDATE";
      } else if (this.dialogMode === "delete") {
        message = "DELETE";
      }
      return message;
    },
    // **********************|~COLOR DIALOG~|********************** //
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
  methods: {
    // **********************|~GET DISCIPLINE~|********************** //
    getDisciplines() {
      axios.get("/disciplines").then((response) => {
        if(this.role !== 'STUDENT') {
          if (!this.isSearch) {
            this.DisciplineData = response.data;
          } else {
            this.contain_discipline_search = response.data.filter((discipline) =>
              discipline.discipline_type
                .toLowerCase()
                .includes(this.key_notic_search.toLowerCase())
            );
          }
        } else {
          this.DisciplineData = response.data.filter(discipline => discipline.student_id === parseInt(localStorage.getItem("studentId")));
        }
      });
    },
    // **********************|~CLOSE FORM DIALOG~|********************** //
    closeDialog() {
      this.dialog = false;
      if (this.dialogMode !== "delete") {
        this.$refs.form.reset();
        // this.student_id = 0;
      }
    },
    //----------------------- SHOW DIALOG DELETE -----------------------------------
    showDialogDelete(id) {
      this.dialogMode = "delete";
      this.dialog = true;
      this.disciplineAction = {
        id: id,
      };
      console.log("delete", id);
    },
    showDialogEdit(discipline) {
      this.dialogMode = "edit";
      this.dialog = true;
      this.disciplineAction = discipline;
      this.student_id = discipline.students.first_name;
      this.notic_type = discipline.discipline_type;
      this.discipline_date = discipline.date;
      this.description = discipline.description;
    },

    // **********************|~CONFIRM DIALOG~|********************** //
    onConfirm() {
      if (this.dialogMode === "create") {
        this.addDiscipline();
        this.$refs.form.reset();
      } else if (this.dialogMode === "delete") {
        this.deleteDiscipline(this.disciplineAction.id);
      } else if (this.dialogMode === "edit") {
        this.updateDiscipline();
      }
    },

    updateDiscipline() {
      if (this.$refs.form.validate()) {
        let studentId = "";
        if (this.student_id.id !== undefined) {
          studentId = this.student_id.id;
        } else {
          studentId = this.disciplineAction.student_id;
        }
        
        let newDiscipline = {
          student_id: studentId,
          discipline_type: this.notic_type,
          date: this.discipline_date,
          description: this.description,
        };
        axios
          .put("/disciplines/" + this.disciplineAction.id, newDiscipline)
          .then((res) => {
            console.log(res.data);
            this.getDisciplines();
            this.closeDialog();
            this.messageAlert = "Congratulation, you have updated!";
          })
          .catch((error) => {
            console.log(error.res.data.errors);
          });
      }
    },

    // **********************|~SHOW CREATE FORM DIALOG~|********************** //
    showCreateForm() {
      this.dialogMode = "create";
      this.dialog = true;
      this.messageAlert = "";
      this.discipline_date = null;
    },
    // **********************|~ADD DISCIPLINE~|********************** //
    addDiscipline() {
      if (this.$refs.form.validate()) {
        let disciplines_data = {
          student_id: this.student_id.id,
          discipline_type: this.notic_type,
          date: this.discipline_date,
          description: this.description,
        };
        axios
          .post("/disciplines", disciplines_data)
          .then(() => {
            this.closeDialog();
            this.getDisciplines();
            this.messageAlert = "Created success";
          })
          .catch((error) => {
            console.log(error.response.data.errors);
          });
      }
    },
    //------------------------------ DELETE DISCIPLINE------------------------
    deleteDiscipline(id) {
      axios.delete("/disciplines/" + id).then(() => {
        this.DisciplineData = this.DisciplineData.filter(
          (discipline) => discipline.id !== id
        );
        this.contain_discipline_search = this.contain_discipline_search.filter(
          (discipline) => discipline.id !== id
        );
        this.messageAlert = "Delete success !";
        this.closeDialog();
      });
    },
    // **********************[SEARCH PERMISSION BY USERNAME AND CLASS]**********************//
    // ------------------------------(Search By Username)---------------------------------
    searchAnyKey(any_key, type_key) {
      if (
        (any_key !== "" && type_key !== "ALL TYPE") ||
        (any_key === "" && type_key !== "ALL TYPE")
      ) {
        console.log(any_key, type_key);
        this.contain_discipline_search = this.DisciplineData.filter(
          (discipline) =>
            (discipline.students.first_name
              .toLowerCase()
              .includes(any_key.toLowerCase()) ||
              discipline.students.last_name
                .toLowerCase()
                .includes(any_key.toLowerCase()) ||
              discipline.students.class
                .toLowerCase()
                .includes(any_key.toLowerCase())) &&
            discipline.discipline_type
              .toLowerCase()
              .includes(type_key.toLowerCase())
        );
      } else {
        this.contain_discipline_search = this.DisciplineData.filter(
          (discipline) =>
            discipline.students.first_name
              .toLowerCase()
              .includes(any_key.toLowerCase()) ||
            discipline.students.last_name
              .toLowerCase()
              .includes(any_key.toLowerCase()) ||
            discipline.students.class
              .toLowerCase()
              .includes(any_key.toLowerCase())
        );
      }
      this.isSearch = true;
    },
    //----------------------------(Search By select Class)-------------------------------------
    selectType(type_key) {
      if (type_key === "ALL TYPE") {
        this.getDisciplines();
        this.isSearch = false;
      } else {
        console.log(type_key);
        this.key_notic_search = type_key;
        this.contain_discipline_search = this.DisciplineData.filter(
          (discipline) =>
            discipline.discipline_type
              .toLowerCase()
              .includes(type_key.toLowerCase())
        );
        this.isSearch = true;
      }
    },
  },

  mounted() {
    this.getDisciplines();
    this.role = localStorage.getItem("role");
    console.log(this.DisciplineData);

    // **********************|~GET STUDENT~|********************** //
    axios.get("/students").then((response) => {
      this.ListOfStudents = response.data;
    });
    // **********************|~GET DISCIPLINE NOTIC TYPE~|********************** //
    axios.get("/discipline_type").then((response) => {
      this.discipline_type = response.data.disciplines;
    });
  },
};
</script>

<!--~~~~~~~~~~~~~~~~~~~~~~~~|STYLE|~~~~~~~~~~~~~~~~~~~~~~~~-->
<style scoped>
select {
  width: 100%;
  padding: 10px;
  outline-style: none;
  border: none;
  border-bottom: 1px solid gray;
}
option {
  font-size: medium;
  color: gray;
}
</style>
