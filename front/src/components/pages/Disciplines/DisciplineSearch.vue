<template>
  <v-container>
    <v-row align="center">
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-col class="d-flex" cols="12" sm="4">
        <v-text-field
          v-model="keySearch"
          @keyup="addSearchStudent"
          label="Search Student Or Class*"
          solo
          prepend-inner-icon="mdi-magnify"
        ></v-text-field>
        <!--*~*~*~*~*~*~*~*~*~*~*~*~[BTN SEARCH]~*~*~*~*~*~*~*~*~*~*~*~*-->
        <v-btn color="orange white--text ms-2 p-4" height="47"
        @click="clearText">
          <v-icon
          dark
          left
        >
          mdi-minus-circle
        </v-icon>clear
        </v-btn>
      </v-col>
      <!--*~*~*~*~*~*~*~*~*~*~*~*~[SELECT]~*~*~*~*~*~*~*~*~*~*~*~*-->
      <v-col class="d-flex" cols="6" sm="3">
        <v-select
          :items="discipline_type"
          label="Sort By Notic Type *"
          solo
          v-model="notic_type"
          @change="addSelectType"
        ></v-select>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "../../../api/api.js";
export default {
  emits: ["searchByAny", "selectByType"],
  data() {
    return {
      notic_type: "ALL TYPE",
      keySearch: "",
      discipline_type: [],
    };
  },
  methods: {
    addSearchStudent() {
      this.$emit(
        "searchByAny",
        this.keySearch,
        this.notic_type
      );
    },
    addSelectType() {
      this.$emit("selectByType", this.notic_type);
    },

    clearText() {
      this.keySearch = "";
      this.addSearchStudent();
    },
  },
  mounted() {
    axios.get("/discipline_type").then((response) => {
      this.discipline_type = response.data.disciplines;
      this.discipline_type.unshift('ALL TYPE');
    });
  },
};
</script>