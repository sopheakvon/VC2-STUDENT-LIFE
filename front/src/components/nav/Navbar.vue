<template>
  <nav>
    <v-navigation-drawer v-model="sidebar" app absolute left temporary>
      <v-list nav dense>
        <v-list-item-group active-class="deep-purple--text text--accent-4">
          <v-list-item>
            <v-list-item-avatar>
              <v-img
                :src="
                  userdata.student === null
                    ? userdata.profile
                    : url + userdata.student.profile
                "
              ></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{ userdata.username }}
              </v-list-item-title>
              <v-list-item-subtitle>{{ userdata.roles }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-divider></v-divider>

          <v-list-item :to="{ path: '/dashboard' }">
            <v-list-item-icon>
              <v-icon>mdi-view-dashboard</v-icon>
            </v-list-item-icon>
            <v-list-item-title>DASHBOARD</v-list-item-title>
          </v-list-item>

          <v-list-item :to="{ path: '/user' }" v-if="userdata.roles === 'ADMIN'">
            <v-list-item-icon>
              <v-icon>mdi-account-group-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title>USER</v-list-item-title>
          </v-list-item>

          <v-list-item :to="{ path: '/student' }">
            <v-list-item-icon>
              <v-icon>mdi-school</v-icon>
            </v-list-item-icon>
            <v-list-item-title>STUDENT</v-list-item-title>
          </v-list-item>

          <v-list-item :to="{ path: '/permision' }">
            <v-list-item-icon>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>PERMISSION</v-list-item-title>
          </v-list-item>

          <v-list-item :to="{ path: '/discipline' }">
            <v-list-item-icon>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>DISCIPLINE</v-list-item-title>
          </v-list-item>

          <v-list-item @click="$emit('requestToLogout')">
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title> LOG OUT </v-list-item-title>
          </v-list-item>

          <!--~*~*~*~*~*~*~*~*~*~*~*~*~*~*|DARK MOOD|~*~*~*~*~*~*~*~*~*~*~*~*~*~*-->
          <v-divider></v-divider>
          <v-list-item
            active-class="deep-white--text text--accent-4"
            :dark="!!(isDark === 'dark')"
            @click="$vuetify.theme.dark = !$vuetify.theme.dark"
          >
            <v-list-item-icon>
              <v-icon>
                {{
                  $vuetify.theme.dark
                    ? "mdi-weather-night"
                    : "mdi-weather-sunny"
                }}
              </v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              {{
                $vuetify.theme.dark ? "LIGHT MODE" : "DARK MODE"
              }}</v-list-item-title
            >
          </v-list-item>
          <!--~*~*~*~*~*~*~*~*~*~*~*~*~*~*|END OF DARK MOOD|~*~*~*~*~*~*~*~*~*~*~*~*~*~*-->
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar elevation="6" app>
      <span class="hidden-md-and-up">
        <v-app-bar-nav-icon @click="showSideBar"> </v-app-bar-nav-icon>
      </span>
      <v-toolbar-title>
        <router-link
          to="/"
          tag="span"
          style="cursor: pointer"
          class="hidden-sm-and-down"
        >
          <v-list-item>
            <v-list-item-avatar>
              <v-img
                :src="
                  userdata.student === null
                    ? userdata.profile
                    : url + userdata.student.profile
                "
              ></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{ userdata.username }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>
      </v-toolbar-title>
      <h5 class="hidden-md-and-up">STUDENT LIFE</h5>
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn active-class="info" text :to="{ path: '/dashboard' }">
          <v-icon left active-class="info">mdi-view-dashboard</v-icon>
          DASHBOARD
        </v-btn>
        <v-btn
          active-class="info"
          text
          :to="{ path: '/user' }"
          v-if="userdata.roles === 'ADMIN'"
        >
          <v-icon left active-class="info">mdi-account-group-outline</v-icon>
          USER
        </v-btn>
        <v-btn active-class="info" text :to="{ path: '/student' }">
          <v-icon left active-class="info">mdi-school</v-icon>
          STUDENT
        </v-btn>
        <v-btn active-class="info" text :to="{ path: '/permision' }">
          <v-icon left active-class="info">mdi-account-star</v-icon>
          PERMISSION
        </v-btn>

        <v-btn active-class="info" text :to="{ path: '/discipline' }">
          <v-icon left active-class="info">mdi-account-multiple-outline</v-icon>
          DISCIPLINE
        </v-btn>
        <v-btn
          active-class="grey-5 white--text"
          text
          @click="$emit('requestToLogout')"
        >
          <v-icon left>mdi-logout</v-icon>
          LOG OUT
        </v-btn>
        <!--~*~*~*~*~*~*~*~*~*~*~*~*~*~*|DARK MOOD|~*~*~*~*~*~*~*~*~*~*~*~*~*~*-->
        <v-btn text @click="$vuetify.theme.dark = !$vuetify.theme.dark">
          <v-icon>
            {{
              $vuetify.theme.dark ? "mdi-weather-night" : "mdi-weather-sunny"
            }}
          </v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>
  </nav>
</template>

<script>
export default {
  props: ["userdata"],
  emits: ["requestToLogout"],
  data() {
    return {
      sidebar: false,

      url: "http://localhost:8000/storage/images/",
    };
  },
  methods: {
    showSideBar() {
      this.sidebar = !this.sidebar;
    },
  },
  computed: {
    isDark() {
      return this.$vuetify.theme.dark ? "dark" : "light";
    },
  },
};
</script>

<style lang="scss" scoped>
</style>










