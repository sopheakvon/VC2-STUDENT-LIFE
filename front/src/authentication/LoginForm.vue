<template>
  <div class="wrapper">
    <v-row>
      <v-col class="card mt-12" lg="6" md="6" sm="8">
        <v-card elevation="12" shaped tile class="pa-4" id="bg">
          <div class="d-flex justify-center mb-3">
            <v-img
              lazy-src="https://picsum.photos/id/11/10/6"
              max-height="270"
              max-width="130"
              src="https://cdn3.iconfinder.com/data/icons/education-1-1/256/School-256.png"
            ></v-img>
          </div>
          <h3 class="font-weight-bold text-center text-h4 orange--text">
            WELCOME TO
          </h3>
          <h3 class="font-weight-bold text-center mb-4 text-h6 info--text">
            STUDENT LIFE
          </h3>

          <hr class="hr-1" />

          <v-alert type="error" dismissible v-if="message === 'fail'">
            Invalid Password or Email
          </v-alert>

          <v-form ref="form" v-model="valid" lazy-validation class="mt-7">
            <v-text-field
              v-model="email"
              :rules="emailRules"
              label="E-mail"
              prepend-icon="mdi-email"
              required
              solo
            ></v-text-field>

            <v-text-field
              v-model="password"
              :rules="nameRules"
              label="Password"
              :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
              :type="show ? 'text' : 'password'"
              prepend-icon="mdi-lock"
              required
              solo
              @click:append="show = !show"
            ></v-text-field>
            <v-btn
              color="red"
              dark
              outlined
              class="mr-4 mt-3 mb-5"
              left
              @click="reset"
            >
              reset
            </v-btn>
            <v-btn
              :disabled="!valid"
              color="info"
              dark
              class="mr-4 mt-3 mb-5"
              left
              @click="validate"
            >
              Login
            </v-btn>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  emits: ["requestLogin"],
  props: ["message"],
  data: () => ({
    valid: true,
    show: false,
    password: "",
    nameRules: [
      (v) => !!v || "Password is required",
      (v) =>
        (v && v.length <= 8 && v.length >= 4) ||
        "Password must be at least 4 and less than 8 characters",
    ],
    email: "",
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
  }),

  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        let userData = {
          email: this.email,
          password: this.password,
        };
        this.$emit("requestLogin", userData);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
  },
};
</script>

<style scoped>
.card {
  margin: auto;
}
.wrapper {
  background: url(https://cdn.pixabay.com/photo/2019/08/06/02/16/mountains-4387209_960_720.jpg)
    fixed;
  background-size: 100% 100%;
  background-repeat: no-repeat;
  background-position: center;
  height: 102%;
}
#bg {
  background: rgba(255, 255, 255, 0.719);
}
hr {
  background-color: #fff;
  padding: 0;
}

hr.hr-1 {
  border: 0;
  height: 1px;
  background-image: linear-gradient(to right, #2195f336, #f44336, #2195f336);
}
</style>
