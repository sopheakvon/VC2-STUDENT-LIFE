<template>
  <section>
    <!--*~*~*~*~*~*~*~*~*~*~*~*~[SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
    <v-row align="center">
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-col class="d-flex" cols="12" sm="4">
        <v-text-field
          v-model="keySearchUsername"
          label="Search by username*"
          solo
          prepend-inner-icon="mdi-magnify"
          @keyup="searchUsername"
        ></v-text-field>
        <!--*~*~*~*~*~*~*~*~*~*~*~*~[BTN SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
        <v-btn color="error" class="ms-1" height="48" @click.prevent="clearText">
          <v-icon
          dark
          left
        >
          mdi-minus-circle
        </v-icon>clear
        </v-btn>
      </v-col>
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[SELECT]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-col class="d-flex" cols="12" sm="3">
        <v-select
          label="Sort by roles*"
          solo
          :items="keyRoles"
          v-model="keySelectByRole"
          @change="SelectUserRole"
        ></v-select>
      </v-col>
    </v-row>
  </section>
</template>

<script>
export default {
  emits: ["searchByusername", "SelectRole"],
  data() {
    return {
      keySearchUsername: "",
      keyRoles: ["ALL", "SOCIAL AFFAIL OFFICER", "STUDENT"],
      keySelectByRole: "ALL",
    };
  },
  methods: {
    searchUsername() {
      this.$emit("searchByusername", this.keySearchUsername,this.keySelectByRole);
    },

    SelectUserRole(){
        this.$emit("SelectRole",this.keySelectByRole);
    },

    clearText() {
      this.keySearchUsername = "";
      this.searchUsername();
    },
  },
};
</script>

<style scoped>
</style>
