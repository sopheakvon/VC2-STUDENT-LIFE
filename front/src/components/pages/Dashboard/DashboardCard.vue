<!--<~><~><~><~><~><~><~><~><~>|*TEMPLATE*|<~><~><~><~><~><~><~><~><~>-->
<template>
  <div>
    <v-app
      id="inspire"
      class="mt-10"
      :style="{ background: $vuetify.theme.themes.dark.background }"
    >
      <!--**********************************|CAROUSEL|***********************************-->
      <v-row>
        <v-col cols="12" lg="12" md="12" sm="12" xs="12">
          <v-card elevation="7" class="mx-auto">
            <v-system-bar lights-out></v-system-bar>
            <v-carousel
              cycle
              height="300"
              hide-delimiter-background
              show-arrows-on-hover
            >
              <v-carousel-item v-for="(value, i) in values" :key="i">
                <v-sheet :color="colors[i]" height="100%" tile>
                  <v-row class="fill-height" align="center" justify="center">
                    <div class="text-h3 font-weight-regular white--text">
                      {{ value }}
                    </div>
                  </v-row>
                </v-sheet>
              </v-carousel-item>
            </v-carousel>
            <!--**********************************|LOGO & NAME OF SCHOOL|***********************************-->
            <v-list two-line>
              <v-list-item class="mb-3">
                <v-list-item-avatar width="100" height="100">
                  <v-img
                    src="https://www.passerellesnumeriques.org/wp-content/uploads/2016/03/pn-logo.png"
                    size="1000"
                  ></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title
                    class="info--text font-weight-medium text-h5"
                    >PASSERELLES NUMERIQUES CAMBODIA</v-list-item-title
                  >
                  <v-list-item-subtitle
                    class="orange--text font-weight-medium text-h6"
                    >STUDENT LIFE</v-list-item-subtitle
                  >
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card>
        </v-col>
      </v-row>
      <div class="numberOfStudents">
        <!--**********************************|SUB CARD|***********************************-->
        <template>
          <div>
            <v-container>
              <!--<><><><><><><><><><><><><><><><><>|~STUDENT 2021~|<><><><><><><><><><><><><><><><><>-->
              <v-list-item-title
                class="
                  font-weight-light
                  text-h4
                  white--text
                  mt-7
                  mb-5
                  text-left
                "
              >
                STUDENTS 2021
                <hr class="hr-1" />
              </v-list-item-title>
              <v-layout row wrap class="mb-5">
                <!--**********************|WEB-A 2021|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="success">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="success"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                          >{{ class_WebA_2021 }}</v-list-item-title
                        >
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-A 2021</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|WEB-B 2021|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="info">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="info"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                          >{{ class_WebB_2021 }}</v-list-item-title
                        >
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-B 2021</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|WEB-A 2021|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="red">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="red"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_SNA_2021 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS SNA 2021</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--<><><><><><><><><><><><><><><><><>|~STUDENT 2022~|<><><><><><><><><><><><><><><><><>-->
                <v-container>
                  <v-list-item-title
                    class="
                      font-weight-light
                      text-h4
                      white--text
                      mt-7
                      mb-5
                      text-left
                    "
                  >
                    STUDENTS 2022
                    <hr class="hr-1" />
                  </v-list-item-title>
                </v-container>
                <!--**********************|WEB-A 2022|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="orange">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="orange"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_WebA_2022 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-A 2022</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|WEB-B 2022|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="pink">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="pink"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_WebB_2022 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-B 2022</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|SNA 2022|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="purple">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="purple"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_SNA_2022 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS SNA 2022</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--<><><><><><><><><><><><><><><><><>|~STUDENT 2023~|<><><><><><><><><><><><><><><><><>-->
                <v-container>
                  <v-list-item-title
                    class="
                      font-weight-light
                      text-h4
                      white--text
                      mt-7
                      mb-5
                      text-left
                    "
                  >
                    STUDENTS 2023
                    <hr class="hr-1" />
                  </v-list-item-title>
                </v-container>
                <!--**********************|WEB-B 2022|**********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="#009688">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="#009688"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_WebA_2023 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-A 2023</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|SNA 2021|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="#FFC107">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="#FFC107"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_WebB_2023 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS WEB-B 2023</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
                <!--**********************|SNA 2022|***********************-->
                <v-flex sm6 xs12 md6 lg4>
                  <v-card class="ma-3" elevation="7" color="#607D8B">
                    <v-list-item>
                      <v-list-item-avatar tile class="mt-n7">
                        <v-sheet
                          color="#607D8B"
                          width="80"
                          height="80"
                          elevation="10"
                        >
                          <v-icon dark large>mdi-school</v-icon>
                        </v-sheet>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <div class="overline text-right white--text">
                          number of students
                        </div>
                        <v-list-item-title
                          class="headline mb-1 text-right white--text"
                        >
                          {{ class_SNA_2023 }}
                        </v-list-item-title>
                        <div><v-divider></v-divider></div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-icon text class="ma-2 white--text">mdi-folder</v-icon>
                      <div class="overline white--text">CLASS SNA 2023</div>
                    </v-card-actions>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </div>
        </template>
      </div>
      <template>
        <!--*****************************|~AMOUNG CARD~|*****************************-->
        <v-item-group mandatory class="mt-n4">
          <v-container>
            <v-list-item-title
              class="font-weight-light text-h4 info--text mt-7 mb-7 text-left"
            >
              TOTAL
              <hr class="hr-1" />
            </v-list-item-title>
            <v-row justify="center" class="space mb-7 mt-5">
              <v-col cols="12" md="3">
                <v-item v-slot="{ active, toggle }">
                  <v-card
                    :color="active ? 'success' : 'white'"
                    class="d-flex align-center rounded-ms"
                    dark
                    height="150"
                    elevation="7"
                    @click="toggle"
                  >
                    <v-row>
                      <v-col cols="12" sm="12">
                        <v-list-item three-line class="mt-3">
                          <v-list-item-content>
                            <div class="mb-4">
                              <v-icon
                                x-large
                                :color="active ? 'white' : 'success'"
                                >mdi-account-multiple</v-icon
                              >
                            </div>
                            <v-list-item-subtitle
                              class="font-weight-medium"
                              :class="active ? 'white--text' : 'success--text'"
                              >USERS</v-list-item-subtitle
                            >
                            <v-list-item-title
                              class="headline mb-1"
                              :class="active ? 'white--text' : 'success--text'"
                            >
                              <strong>{{ list_users }}</strong>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-item>
              </v-col>
              <v-col cols="12" md="3">
                <v-item v-slot="{ active, toggle }">
                  <v-card
                    :color="active ? 'info' : 'white'"
                    class="d-flex align-center rounded-sm"
                    dark
                    height="150"
                    elevation="12"
                    @click="toggle"
                  >
                    <v-row>
                      <v-col cols="12" sm="12">
                        <v-list-item three-line class="mt-3">
                          <v-list-item-content>
                            <div class="mb-4">
                              <v-icon x-large :color="active ? 'white' : 'info'"
                                >mdi-school</v-icon
                              >
                            </div>
                            <v-list-item-subtitle
                              class="font-weight-medium"
                              :class="active ? 'white--text' : 'info--text'"
                              >STUDENTS</v-list-item-subtitle
                            >
                            <v-list-item-title
                              class="headline mb-1"
                              :class="active ? 'white--text' : 'info--text'"
                            >
                              <strong>{{ number }}</strong>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-item>
              </v-col>
              <v-col cols="12" md="3">
                <v-item v-slot="{ active, toggle }">
                  <v-card
                    :color="active ? 'red' : 'white'"
                    class="d-flex align-center rounded-sm"
                    dark
                    height="150"
                    elevation="12"
                    @click="toggle"
                  >
                    <v-row>
                      <v-col cols="12" sm="12">
                        <v-list-item three-line class="mt-3">
                          <v-list-item-content>
                            <div class="mb-4">
                              <v-icon x-large :color="active ? 'white' : 'red'"
                                >mdi-book</v-icon
                              >
                            </div>
                            <v-list-item-subtitle
                              class="font-weight-medium"
                              :class="active ? 'white--text' : 'red--text'"
                              >STUDENT PERMISSIONS</v-list-item-subtitle
                            >
                            <v-list-item-title
                              class="headline mb-1"
                              :class="active ? 'white--text' : 'red--text'"
                            >
                              <strong>{{ list_permission }}</strong>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-item>
              </v-col>
              <v-col cols="12" md="3">
                <v-item v-slot="{ active, toggle }">
                  <v-card
                    :color="active ? 'orange' : 'white'"
                    class="d-flex align-center rounded-sm"
                    dark
                    height="150"
                    elevation="12"
                    @click="toggle"
                  >
                    <v-row>
                      <v-col cols="12" sm="12">
                        <v-list-item three-line class="mt-3">
                          <v-list-item-content>
                            <div class="mb-4">
                              <v-icon
                                x-large
                                :color="active ? 'white' : 'orange'"
                                >mdi-alert</v-icon
                              >
                            </div>
                            <v-list-item-subtitle
                              class="font-weight-medium"
                              :class="active ? 'white--text' : 'orange--text'"
                              >STUDENT DISCIPLINES</v-list-item-subtitle
                            >
                            <v-list-item-title
                              class="headline mb-1"
                              :class="active ? 'white--text' : 'orange--text'"
                            >
                              <strong>{{ list_discipline }}</strong>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-item>
              </v-col>
            </v-row>
          </v-container>
        </v-item-group>
      </template>
    </v-app>
  </div>
</template>

<!--<~><~><~><~><~><~><~><~><~>|*SCRIPT*|<~><~><~><~><~><~><~><~><~>-->
<script>
export default {
  props: [
    "users",
    "list_users",
    "number",
    "list_permission",
    "list_discipline",
    "class_WebA_2021",
    "class_WebB_2021",
    "class_WebA_2022",
    "class_WebB_2022",
    "class_SNA_2021",
    "class_SNA_2022",
    "class_WebA_2023",
    "class_WebB_2023",
    "class_SNA_2023",
  ],
  data() {
    return {
      user_profile: "http://localhost:8000/storage/images/",
      colors: ["warning", "info", "warning", "info", "warning"],
      cycle: false,
      values: [
        "TRUST",
        "RESPONSIBILITY",
        "SOLIDARITY",
        "RESPECT",
        "DEMANDING APPROACH",
      ],
      allStudents: [500, 600, 200, 900, 100, 500, 700, 1000],
      permission: [423, 446, 675, 510, 590, 610, 760, 900],
      discipline: [30, 46, 75, 80, 979, 160, 890, 900],
    };
  },
};
</script>

<!--<~><~><~><~><~><~><~><~><~>|*STYLE*|<~><~><~><~><~><~><~><~><~>-->
<style >
.numberOfStudents {
  background-image: url(https://cdn.pixabay.com/photo/2016/11/14/03/16/book-1822474_960_720.jpg);
  background-repeat: no-repeat;
  background-size: 100% 100%;
  height: auto;
  text-align: center;
  background-attachment: fixed;
}
hr {
  background-color: #fff;
  padding: 0;
}

hr.hr-1 {
  border: 0;
  height: 2px;
  background-image: linear-gradient(to right, orange, #20de20, orange);
}
</style>