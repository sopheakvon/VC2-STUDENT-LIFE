<template>
  <v-expansion-panels class="mt-4">
    <v-expansion-panel>
      <v-expansion-panel-header>
        <v-row no-gutters>
          <v-col cols="3">
            <div class="d-flex align-center">
              <div>
                <v-icon
                  dark
                  left
                  :color="
                    discipline.discipline_type === 'TERMINATION'
                      ? 'error'
                      : discipline.discipline_type === 'WARNING LETTER'
                      ? 'warning'
                      : discipline.discipline_type === 'MISCONDUCT'
                      ? 'red'
                      : 'warning'
                  "
                >
                  {{
                    discipline.discipline_type === "TERMINATION"
                      ? "mdi-cancel"
                      : discipline.discipline_type === "WARNING LETTER"
                      ? "mdi-alert"
                      : discipline.discipline_type === "MISCONDUCT"
                      ? "mdi-cards"
                      : "mdi-alert-octagon"
                  }}
                </v-icon>
              </div>
              <div class="ml-4">
                {{ discipline.discipline_type }}
              </div>
            </div>
          </v-col>
          <v-col cols="3">
            <div class="d-flex">
              <div>
                <v-img
                  class="mr-4 rounded"
                  lazy-src="https://picsum.photos/id/11/10/6"
                  max-height="50"
                  max-width="70"
                  :src="stu_profile + student.profile"
                ></v-img>
              </div>
              <div>
                <div>
                  <h3>
                    {{ student.first_name }}
                    {{ student.last_name }}
                  </h3>
                </div>
                <div class="grey--text mt-4">
                  {{ student.class }}
                </div>
              </div>
            </div>
          </v-col>
          <v-col cols="3">
            <v-icon class="green--text">mdi-calendar-text</v-icon>
            <strong> {{ discipline.date }} </strong>
          </v-col>
          <!-- <v-col cols="3">
            <div class="d-flex justify-end mr-4" v-if="role === 'ADMIN' ">
              <div class="mr-2">
                <v-btn icon color="success" @click="toEditDiscipline(discipline)">
                  <v-icon> mdi-account-edit </v-icon>
                </v-btn>
              </div>
              <div>
                <v-btn icon color="error" @click="toDeleteDiscipline(discipline.id)">
                  <v-icon> mdi-delete-sweep </v-icon>
                </v-btn>
              </div>
            </div>
          </v-col> -->
        </v-row>
      </v-expansion-panel-header>
      <v-expansion-panel-content class="mt-4">
        <v-divider></v-divider>
        <h4 class="mt-4">REASON</h4>

        <v-alert outlined class="mt-2">
          <div>
            {{ discipline.description }}
          </div>
        </v-alert>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<!--~~~~~~~~~~~~~~~~~~~~~~~~|SCRIPT|~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
export default {
  props: ["discipline", "student"],
//   emits: ["disciplineToDelete", "disciplineToEdit"],

  data() {
    return {
      role: "",
      stu_profile: "http://localhost:8000/storage/images/",
      show: false,
      isTrue: false,
      direction: "left",
      hover: false,
    };
  },
  computed: {},
  methods: {
    // toDeleteDiscipline(id) {
    //   this.$emit("disciplineToDelete", id);
    // },
    // toEditDiscipline(discipline) {
    //   this.$emit("disciplineToEdit", discipline);
    // },
  },
  mounted() {
    this.role = localStorage.getItem("role");
  },
};
</script>

<!--~~~~~~~~~~~~~~~~~~~~~~~~|STYLE|~~~~~~~~~~~~~~~~~~~~~~~~-->
<style scoped>
#create .v-speed-dial {
  position: absolute;
}

#create .v-btn--floating {
  position: relative;
}
</style>
