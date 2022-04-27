<template>
  <section>
    <v-row align="center">
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-col class="d-flex" cols="12" sm="4">
        <v-text-field
          v-model="keySearchStudentname"
          label="Search by studentname...*"
          solo
          prepend-inner-icon="mdi-magnify"
          @keyup="searchStudentname"
          
        ></v-text-field>
        <!--*~*~*~*~*~*~*~*~*~*~*~*~[BTN SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
        <v-btn color="error" class="ms-1" height="47" @click.prevent = "clearText()" >
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
          label="Search by classname..."
          solo
          :items="classes"
          v-model="keySelectByClass"
          @change="SelectStudentClass"
         
        ></v-select>
      </v-col>
    </v-row>
  </section>
</template>

<script>
import axios from "../../../api/api.js";
export default {
  emits: ["searchByStudentname", "SelectClass"],

  data() {
    return {
      keySelectByClass: "ALL CLASS",
      keySearchStudentname: "",
      classes: [],

    };
  },
  methods: {
    searchStudentname() {
      this.$emit(
        "searchByStudentname",
        this.keySearchStudentname,
        this.keySelectByClass
      );
    },
    SelectStudentClass() {
      this.$emit("SelectClass", this.keySelectByClass);
    },

    clearText() {
      this.keySearchStudentname = "";
      this.searchStudentname();
    },
  },
  mounted(){
    axios.get("/class").then((res) => {
      this.classes = res.data.class;
      this.classes.unshift("ALL CLASS")
      console.log(this.classes);
    });
  }
};
</script>

<style>
</style>