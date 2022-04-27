<template>
  <section>
    <v-container class="mt-5">
      <v-btn
        v-if="role !== 'STUDENT'"
        depressed
        @click.stop="showCreateForm"
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
            <v-card-text class="mt-2">
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-combobox
                  :rules="studentRules"
                  prepend-icon="mdi-account-multiple"
                  label="Choose"
                  v-model="student_id"
                  :items="contain_students"
                  item-text="first_name"
                  item-value="id"
                  :return-object="true"
                >
                  <template v-slot:item="data">
                    <template>
                      <v-list-item-avatar>
                        <img :src="url + data.item.profile" />
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

                <v-row align="center">
                  <v-col cols="6">
                    <v-menu
                      v-model="isDateSelected1"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="startDate"
                          :rules="startDateRules"
                          label="Leave on *"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="startDate"
                        @input="isDateSelected1 = false"
                        :min="nowDate"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="6">
                    <v-menu
                      v-model="isDateSelected2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="endDate"
                          :rules="endDateRules"
                          label="Back on *"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="endDate"
                        @input="isDateSelected2 = false"
                        :min="nowDate"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                </v-row>

                <v-alert
                  v-if="messageError !== ''"
                  text
                  type="error"
                  icon="mdi-alert-octagon"
                >
                  {{ messageError }}
                </v-alert>

                <v-select
                  v-model="leave_type"
                  :rules="leave_typeRules"
                  prepend-icon="mdi-fast-forward"
                  :items="contain_leaveType"
                  label="Select Reason"
                  required
                ></v-select>
                <v-textarea
                  v-model="description"
                  :rules="descriptionRules"
                  auto-grow
                  rows="1"
                  label="Description"
                  prepend-icon="mdi-comment-text"
                  required
                ></v-textarea>
              </v-form>
            </v-card-text>
          </div>

          <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-REMOVE DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
          <div v-else>
            <v-card-text class="mt-5">
              <v-alert outlined type="error" border="left">
                Are you sure to delete this permission?
              </v-alert>
            </v-card-text>
          </div>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="warning" @click="closeDialog"> close </v-btn>
            <v-btn :color="dialogColor" :disabled="!valid"  @click="onConfirm">
              {{ dialogButton }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-alert
        type="success"
        class="mt-6"
        elevation="12"
        v-if="messageAlert !== ''"
        dismissible
        border="left"
        colored-border
      >
        {{ messageAlert }}
      </v-alert>
      <permission-search
        v-if="role !== 'STUDENT'"
        class="mt-3"
        @searchByStudentName="searchStudentPermission"
        @SelectByClass="SelectClass"
      >
      </permission-search>
      <div v-if="!isSearch" class="mb-12">
        <permission-card
          v-for="permission of permissions_data"
          :key="permission.id"
          :permission="permission"
          @permissiontEdit="showEditForm"
          @permissionToDelete="showDialogDelete"
        ></permission-card>
      </div>
      <div v-else class="mb-12">
        <permission-card
          v-for="permission of contain_permission_search"
          :key="permission.id"
          :permission="permission"
          @permissiontEdit="showEditForm"
          @permissionToDelete="showDialogDelete"
        ></permission-card>
      </div>
      <div v-if="permissions_data.length === 0 " class="mt-12">
        <h1 class="grey--text text-center">Empty!</h1>
      </div>
    </v-container>
  </section>
</template>

<script>
import axios from "../../api/api.js";
import PermissionSearch from "../pages/permissions/permissionSearch.vue";
import PermissionCard from "../pages/permissions/permissionCard.vue";
export default {
  components: {
    "permission-card": PermissionCard,
    "permission-search": PermissionSearch,
  },
  data() {
    return {
      role: "",
      permissions_data: [],
      valid: true,
      dialog: false,
      show1: false,
      dialogMode: "create",
      permissionAction: {},
      dialogDisplay: false,
      messageAlert: "",
      messageError: "",

      url: "http://localhost:8000/storage/images/",

      startDate: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
      endDate: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
      nowDate: new Date().toISOString().slice(0, 10),

      isSearchStudentPermission: false,
      isDateSelected1: false,
      isDateSelected2: false,
      student_id: null,
      leave_type: null,
      description: null,

      contain_leaveType: [],
      contain_students: [],
      contain_permission_search: [],
      isSearch: false,
      key_class_search: "",

      startDateRules: [(v) => !!v || "Start date is required"],
      endDateRules: [(v) => !!v || "End date is required"],
      leave_typeRules: [(v) => !!v || "Leave type is required"],
      descriptionRules: [(v) => !!v || "description is required"],
      studentRules: [(v) => !!v || "Student is required"],
    };
  },

  computed: {
    // **********************|~TITLE DIALOG~|********************** //
    dialogTitle() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE NEW PERMISSION";
      } else if (this.dialogMode === "edit") {
        message = "EDIT THE PERMISSION";
      } else if (this.dialogMode === "delete") {
        message = "DELETE THE PEERMISSION";
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
    getPermissions() {
      axios.get("/permissions").then((response) => {
        if (this.role !== 'STUDENT') {
          if (!this.isSearch) {
            this.permissions_data = response.data;
          } else {
            this.contain_permission_search = response.data.filter((permission) =>
              permission.students.class
                .toLowerCase()
                .includes(this.key_class_search.toLowerCase())
            );
          }
        } else {
          this.permissions_data = response.data.filter(permission => permission.student_id === parseInt(localStorage.getItem("studentId")))
        }
      });
    },
    // **********************|~CLOSE FORM DIALOG~|********************** //
    closeDialog() {
      this.dialog = false;
      if (this.dialogMode !== "delete") {
        this.$refs.form.reset();
      }
    },

    // **********************|~SHOW CREATE FORM DIALOG~|********************** //
    showCreateForm() {
      this.dialogMode = "create";
      this.dialog = true;
      this.startDate = null;
      this.endDate = null;

      this.messageAlert = "";
      this.messageError = "";
    },
    // ---------------------------- SHOW EDIT FORM --------------------------- \\
    showEditForm(permissionData) {
      this.dialogMode = "edit";
      this.dialog = true;
      this.messageAlert = "";
      this.messageError = "";

      this.permissionAction = permissionData;

      this.startDate = permissionData.start_date;
      this.endDate = permissionData.end_date;
      this.description = permissionData.description;
      this.leave_type = permissionData.reason;
      console.log(permissionData);
      this.student_id = permissionData.students.first_name;
    },
    //----------------------- SHOW DIALOG DELETE -----------------------------------
    showDialogDelete(id) {
      this.dialogMode = "delete";
      this.dialog = true;
      this.permissionAction = {
        delete_id: id,
      };
      this.messageAlert = "";
    },

    onConfirm() {
      if (this.dialogMode === "create") {
        this.addPermission();
      } else if (this.dialogMode === "edit") {
        this.updatePermission(this.permissionAction.id);
      } else if (this.dialogMode === "delete") {
        this.deletePermission(this.permissionAction.delete_id);
      }
    },

    addPermission() {
      if (this.$refs.form.validate()) {
        let permission_info = {
          start_date: this.startDate,
          end_date: this.endDate,
          reason: this.leave_type,
          description: this.description,
          student_id: this.student_id.id,
        };
        axios
          .post("/permissions", permission_info)
          .then((response) => {
            console.log(response.data);
            this.getPermissions();
            this.closeDialog();
            this.messageAlert =
              "Congratulation ! You have created one permission successfully !";
            this.messageError = "";
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.messageError =
                "Permission start date cannot after permission end date !";
            }
          });
      }
    },

    // ---------------------------------- UPDADE PERMISSION ------------------------ \\
    updatePermission(edit_id) {
      if (this.$refs.form.validate()) {
        let studentId = "";
        if (this.student_id.id !== undefined) {
          studentId = this.student_id.id;
        } else {
          studentId = this.permissionAction.student_id;
        }

        let permission_info = {
          start_date: this.startDate,
          end_date: this.endDate,
          reason: this.leave_type,
          description: this.description,
          student_id: studentId,
        };

        axios
          .put("/permissions/" + edit_id, permission_info)
          .then((response) => {
            console.log("response data", response.data);
            this.messageAlert = "Update success";
            this.getPermissions();
            this.closeDialog();
            this.messageAlert =
              "Congratulation ! You have updated on permission successfully !";
            this.messageError = "";
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.messageError =
                "Permission start date cannot after permission end date !";
            }
          });
      }
    },

    //------------------------------ DELETE PERMISSION------------------------
    deletePermission(id) {
      axios.delete("/permissions/" + id).then(() => {
        this.permissions_data = this.permissions_data.filter(
          (permission) => permission.id !== id
        );
        this.contain_permission_search = this.contain_permission_search.filter(
          (permission) => permission.id !== id
        );
        this.messageAlert = "Delete success !";
        this.closeDialog();
      });
    },

    //==========================SEARCH PERMISSION BY USERNAME AND CLASS ============================================================
    // Search By Username-----------------------------------------------------------------------------
    searchStudentPermission(username_key, class_key) {
      if (
        (username_key !== "" && class_key !== "All Class") ||
        (username_key === "" && class_key !== "All Class")
      ) {
        console.log("search", username_key, class_key);
        this.contain_permission_search = this.permissions_data.filter(
          (permission) =>
            (permission.students.first_name.toLowerCase().includes(username_key.toLowerCase()) ||
              permission.students.last_name
                .toLowerCase()
                .includes(username_key.toLowerCase())) &&
            permission.students.class
              .toLowerCase()
              .includes(class_key.toLowerCase())
        );
      } else {
        this.contain_permission_search = this.permissions_data.filter(
          (permission) =>
            permission.students.first_name
              .toLowerCase()
              .includes(username_key.toLowerCase()) ||
            permission.students.last_name
              .toLowerCase()
              .includes(username_key.toLowerCase())
        );
      }
      this.isSearch = true;
    },
    //Search By select Class---------------------------------------------------------------------------
    SelectClass(class_key) {
      if (class_key === "All Class") {
        this.getPermissions();
        this.isSearch = false;
      } else {
        this.key_class_search = class_key;
        console.log(class_key);
        this.contain_permission_search = this.permissions_data.filter(
          (permission) =>
            permission.students.class
              .toLowerCase()
              .includes(class_key.toLowerCase())
        );
        this.isSearch = true;
      }
    },
  },
  mounted() {
    this.getPermissions();
    // GET REASONS TYPE FROM BACK END=======================================================
    axios.get("/reasons").then((response) => {
      this.contain_leaveType = response.data.reasons;
    });
    // GET AL CONTAIN STUDENT NAME THAT HAVE AT SCHOOL=============================================
    axios.get("/students").then((response) => {
      this.contain_students = response.data;
    });

    this.role = localStorage.getItem("role");
  },
};
</script>

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
