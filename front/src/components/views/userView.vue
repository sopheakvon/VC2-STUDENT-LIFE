<template>
  <div class="text-center">
    <v-btn
      v-if="userRole === 'ADMIN'"
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
          <v-card-text class="mt-5">
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-text-field
                v-model="username"
                :rules="usernameRules"
                label="Username"
                prepend-icon="mdi-account"
                required
              ></v-text-field>

              <v-text-field
                v-model="email"
                :rules="emailRules"
                label="E-mail"
                prepend-icon="mdi-email"
                required
              ></v-text-field>
              <v-alert dense outlined type="error" v-if="messageError !== ''">
                {{ messageError }}
              </v-alert>

              <v-text-field
                v-if="dialogMode !== 'edit'"
                v-model="password"
                :rules="passwordRules"
                label="Password"
                prepend-icon="mdi-lock"
                :append-icon="show1 ? 'eye' : 'eye-off'"
                :type="show1 ? 'text' : 'password'"
                @click:append="show1 = !show1"
                required
              ></v-text-field>

              <v-select
                v-model="role"
                :items="roles"
                :rules="roleRules"
                prepend-icon="mdi-account-star"
                label="Select"
                required
              ></v-select>

              <v-combobox
                v-if="role === 'STUDENT'"
                :rules="studentRules"
                prepend-icon="mdi-account-multiple"
                label="Choose"
                v-model="student"
                :items="students"
                item-text="first_name"
                item-value="id"
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
            </v-form>
          </v-card-text>
        </div>

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~|-REMOVE DIALOG-|~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div v-else>
          <v-card-text class="mt-5">
            <v-alert outlined type="error" prominent border="left">
              Are you sure to delete this user?
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

    <!-- TABLE -->

    <div class="container">
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
      <user-search
        class="mt-12"
        @searchByusername="searchUsername"
        @SelectRole="selectByRole"
      >
      </user-search>
      <v-simple-table class="mb-12">
        <template v-slot:default>
          <thead class="tableHead font-weight-bold text-caption">
            <tr>
              <th>PROFILE</th>
              <th>USERNAME</th>
              <th>EMAIL</th>
              <th>ROLE</th>
              <th v-if="userRole === 'ADMIN'">ACTION</th>
            </tr>
          </thead>
          <tbody v-if="!isSearch">
            <user-card
              class="font-weight-medium text-caption"
              v-for="user of users"
              :key="user.id"
              :user="user"
              @requestToDeleteUser="showDeleteDialog"
              @requestToEdit="showEditForm"
            >
            </user-card>
          </tbody>
          <tbody v-else>
            <user-card
              v-for="user of contain_users_search"
              :key="user.id"
              :user="user"
              @requestToDeleteUser="showDeleteDialog"
              @requestToEdit="showEditForm"
            >
            </user-card>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </div>
</template>

<script>
import axios from "../../api/api.js";
import UserFormSearch from "../pages/users/userFormSearch.vue";
import UserCard from "../pages/users/userCard.vue";
export default {
  components: {
    "user-search": UserFormSearch,
    "user-card": UserCard,
  },
  props: ["userdata"],
  data() {
    return {
      userRole: "",
      userId: null,
      valid: true,
      url: "http://localhost:8000/storage/images/",
      dialog: false,
      show1: false,
      dialogMode: "create",
      roles: ["SOCIAL AFFAIL OFFICER", "STUDENT"],
      notStudentRole: ["STUDENT"],
      students: [],
      images: [
        "https://cdn3.iconfinder.com/data/icons/vector-icons-6/96/256-512.png",
        "https://cdn4.iconfinder.com/data/icons/social-messaging-ui-color-and-shapes-3/177800/129-512.png",
        "https://www.pinclipart.com/picdir/big/164-1640714_user-symbol-interface-contact-phone-set-add-sign.png",
        "https://www.pngall.com/wp-content/uploads/5/Profile-PNG-Clipart.png",
        "https://icon-library.com/images/user-512_4557.png",
      ],
      // DATA FROM INPUT ----------------------------------------
      username: null,
      email: null,
      password: null,
      student: null,
      role: null,
      profile: "",
      // RULE OF INPUT DATA ----------------------------------------
      usernameRules: [(v) => !!v || "Username is required"],
      emailRules: [
        (v) => !!v || "Email is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      passwordRules: [
        (v) => !!v || "Password is required",
        (v) =>
          (v && v.length <= 8 && v.length >= 4) ||
          "Password must be at least 4 and less than 8 characters",
      ],
      studentRules: [(v) => !!v || "Student is required"],
      roleRules: [(v) => !!v || "Role is required"],
      profileRules: [(v) => !!v || "Profile is required"],
      // DATA GET FROM BACKEND ----------------------------------------
      users: [],
      isSearch: false,
      contain_users_search: [],
      key_role_search: "",
      userAction: {},
      dialogDisplay: false,
      // MESSAGE DATA
      messageError: "",
      messageAlert: "",
    };
  },
  computed: {
    // **********************|~TITLE DIALOG~|********************** //
    dialogTitle() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE NEW USER";
      } else if (this.dialogMode === "edit") {
        message = "EDIT THE USER";
      } else if (this.dialogMode === "delete") {
        message = "DELETE THE USER";
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
    // **********************|~GET USER FROM BACKEND~|********************** //
    getUsers() {
      axios.get("/users").then((res) => {
        if (!this.isSearch) {
          this.users = res.data;
        } else {
          this.contain_users_search = res.data.filter((user) =>
            user.roles
              .toLowerCase()
              .includes(this.key_role_search.toLowerCase())
          );
        }
      });
    },

    // **********************|~SHOW CREATE FORM DIALOG~|********************** //
    showCreateForm() {
      this.dialogMode = "create";
      this.dialog = true;

      this.username = null;
      this.email = null;
      this.password = null;
      this.student = null;
      this.role = null;
      this.profile = "";
      this.messageError = "";
      this.messageAlert = "";
    },
    // **********************|~SHOW REMOVE DIALOG~|********************** //
    showDeleteDialog(id) {
      this.userAction = {
        id: id,
      };
      this.dialogMode = "delete";
      this.dialog = true;
      this.messageAlert = "";
    },
    // **********************|~CLOSE FORM DIALOG~|********************** //
    closeDialog() {
      this.dialog = false;
      if (this.dialogMode !== "delete") {
        this.$refs.form.reset();
      }
    },
    showEditForm(userData) {
      this.dialogMode = "edit";
      this.dialog = true;
      this.userAction = {
        id: userData.id,
        username: userData.username,
        email: userData.email,
        role: userData.roles,
        student_id: userData.student_id,
      };
      this.username = this.userAction.username;
      this.email = this.userAction.email;
      if (userData.roles === "ADMIN") {
        this.role = "ADMIN";
      } else {
        this.role = this.userAction.role;
        if (userData.roles === "STUDENT") {
          this.student = userData.student.first_name;
        }
      }
      this.messageError = "";
      this.messageAlert = "";
      console.log(userData);
    },
    updateUser() {
      if (this.userAction.role === "ADMIN") {
        this.role = "ADMIN";
      }

      let student_id = "";
      if (this.role === "STUDENT" || this.userAction.roles === "STUDENT") {
        if (this.student.id !== undefined) {
          student_id = this.student.id;
        } else {
          student_id = this.userAction.student_id;
        }
      } else {
        this.student = "";
      }
      console.log(this.student.id, this.role, this.userAction.student_id);

      let myNewUserData = {
        username: this.username,
        email: this.email,
        roles: this.role,
        student_id: student_id,
      };

      axios
        .put("/users/" + this.userAction.id, myNewUserData)
        .then((response) => {
          console.log(response.data);
          this.getUsers();
          this.closeDialog();
          this.messageAlert = "Update successfully!";
        })
        .catch((error) => {
          if (error.response.status === 500) {
            this.messageError =
              "The email has already been taken by other user!";
          }
        });
    },

    // **********************|~CREATE NEW USER~|********************** //
    createUser() {
      if (this.$refs.form.validate()) {
        const imageRadom = Math.floor(Math.random() * this.images.length);
        this.profile = this.images[imageRadom];

        let student_id = "";
        if (this.student !== null) {
          student_id = this.student.id;
        }

        let userInfo = {
          username: this.username,
          email: this.email,
          password: this.password,
          password_confirmation: this.password,
          roles: this.role,
          student_id: student_id,
          profile: this.profile,
        };
        axios
          .post("/register", userInfo)
          .then((response) => {
            this.users.push(response.data.user);
            this.getUsers();
            this.closeDialog();
            this.messageAlert = "Create succussfully !";
          })
          .catch((error) => {
            this.messageError = error.response.data.errors.email[0];
            console.log(this.messageError);
          });
      }
    },

    // **********************|~REMOVE USER~|********************** //
    deleteUser() {
      let id = this.userAction.id;
      axios.delete("/users/" + id).then(() => {
        this.users = this.users.filter((user) => user.id !== id);
        this.contain_users_search = this.contain_users_search.filter(
          (user) => user.id !== id
        );
        this.closeDialog();
        this.messageAlert = "Delete succussfully!";
      });
    },

    // **********************|~CONFIRM DIALOG~|********************** //
    onConfirm() {
      if (this.dialogMode === "create") {
        this.createUser();
      } else if (this.dialogMode === "delete") {
        this.deleteUser();
      } else if (this.dialogMode === "edit") {
        this.updateUser();
      }
    },

    //==========================SEARCH USER BY USERNAME============================================================
    // Search By Username-----------------------------------------------------------------------------
    searchUsername(username_key, role_key) {
      if (
        (username_key !== "" && role_key !== "ALL") ||
        (username_key === "" && role_key !== "ALL")
      ) {
        console.log(username_key);
        this.contain_users_search = this.users.filter(
          (user) =>
            user.username.toLowerCase().includes(username_key.toLowerCase()) &&
            user.roles.toLowerCase().includes(role_key.toLowerCase())
        );
      } else {
        this.contain_users_search = this.users.filter((user) =>
          user.username.toLowerCase().includes(username_key.toLowerCase())
        );
      }
      this.isSearch = true;
    },
    //Search By select roles---------------------------------------------------------------------------
    selectByRole(role_key) {
      if (role_key === "ALL") {
        this.getUsers();
        this.isSearch = false;
      } else {
        this.key_role_search = role_key;
        // console.log("hello",this.key_role_search);
        this.contain_users_search = this.users.filter((user) =>
          user.roles.toLowerCase().includes(role_key.toLowerCase())
        );
        this.isSearch = true;
      }
    },
  },
  mounted() {
    this.getUsers();
    this.userId = localStorage.getItem("userId");
    this.userRole = localStorage.getItem("role");

    axios
      .get("/students")
      .then((res) => {
        // for (let student of res.data) {
        //   let myStudent = (student.first_name + " " + student.last_name)
        //   this.students.push(myStudent)
        // }
        this.students = res.data;
      })
      .catch((error) => {
        console.log(error.res.data.errors);
      });
  },
};
</script>

<style scoped>
.text-center {
  background: url(https://cdn.pixabay.com/photo/2017/02/05/15/04/stones-2040340_960_720.jpg)
    fixed;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  min-height: 100vh;
  max-height: auto;
}

.tableHead {
  background: #03a9f4;
}
</style>
