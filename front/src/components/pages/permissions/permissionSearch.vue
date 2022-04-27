<template>
  <v-row align="center">
    <!--*~*~*~*~*~*~*~*~*~*~*~*~[SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
    <v-col class="d-flex" cols="12" sm="4">
      <v-text-field
        v-model="keySearchPermission"
        label="Search student*"
        solo
        prepend-inner-icon="mdi-magnify"
        @keyup="searchStudentPermission"
      ></v-text-field>
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[BTN SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-btn
        color="error ms-2 p-4"
        height="47"
        width="95"
        @click.prevent="clearText"
      > <v-icon
          dark
          left
        >
          mdi-minus-circle
        </v-icon>clear
      </v-btn>
    </v-col>
    <!--*~*~*~*~*~*~*~*~*~*~*~*~[SELECT]~*~*~*~*~*~*~*~*~*~*~*~*-->
    <v-col class="d-flex" cols="12" sm="2">
      <v-select
        :items="items"
        label="Display sort by*"
        solo
        v-model="className"
        @change="SelectClass"
      ></v-select>
    </v-col>
  </v-row>
</template>

<script>
export default {
  emits: ["searchByStudentName", "SelectByClass"],
  data() {
    return {
      items: [
        "All Class",
        "WEB 2021 A",
        "WEB 2021 B",
        "WEB 2022 A",
        "WEB 2022 B",
        "SNA 2021",
        "SNA 2022",
      ],
      className: "All Class",
      keySearchPermission: "",
    };
  },
  methods: {
    searchStudentPermission() {
      this.$emit(
        "searchByStudentName",
        this.keySearchPermission,
        this.className
      );
      console.log(this.keySearchPermission);
    },
    SelectClass() {
      this.$emit("SelectByClass", this.className);
    },

    clearText() {
      this.keySearchPermission = "";
      this.searchStudentPermission();
    },
  },
};
</script>