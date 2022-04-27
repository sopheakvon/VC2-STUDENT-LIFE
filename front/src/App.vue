<template>
  <v-app>
    <nav-app
      v-if="isLogin"
      :userdata="user"
      @requestToLogout="Logout"
    >
    </nav-app>

    <v-main>
      <router-view @requestLogin="Login" :message="messageError" :userdata="user"> </router-view>
    </v-main>
    <!-- <footer-app v-if="!$route.path.includes('login')"></footer-app> -->
  </v-app>
</template>

<script>
import axios from "./api/api.js";
import NavBar from "./components/nav/Navbar.vue";
// import Footer from "./components/nav/Footer.vue";

export default {
  name: "App",

  components: {
    "nav-app": NavBar,
    // "footer-app": Footer,
  },
  data() {
    return {
      user: null,
      messageError: "",
      isLogin: false
    };
  },
  methods: {
    Login(userData) {
      axios
        .post("/login", userData)
        .then((response) => {
          this.user = response.data.user;
          localStorage.setItem("token", response.data.token);
          localStorage.setItem("userId", response.data.user.id);
          localStorage.setItem("studentId", response.data.user.student_id);
          localStorage.setItem("role", response.data.user.roles);
          this.isLogin = true;
          this.$router.push("/")
    
        })
        .catch((error) => {
          if (error.response.status === 401) {
            this.messageError = error.response.data.message;
          }
        });
    },
    Logout() {
      axios.post("/logout").then((response) => {
        this.user = null;
        this.messageError = "";
        localStorage.removeItem("userId");
        localStorage.removeItem("studentId");
        localStorage.removeItem("token");
        this.$router.push("/login");
        this.isLogin = false;
        console.log(response.data);
      });
    },
  },
  mounted() {
    
    if (localStorage.userId && localStorage.token) {
      axios.get("/users/" + localStorage.userId).then((response) => {
        this.user = response.data;
      });
      this.isLogin = true
    } else {
      this.isLogin = false;
    }

    if(this.user.length === 0) {
      localStorage.clear()
      this.isLogin = false;
    }
  },
};
</script>
