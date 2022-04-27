<template>
  <!--~!~!~!~!~!~!~!~!~!~!~|CARD|~!~!~!~!~!~!~!~!~!~!~-->
  <v-hover v-slot="{ hover }" class="mt-3">
    <v-card
      id="card"
      class="mx-auto"
      max-width="auto"
      :elevation="hover ? 6 : 3"
      :class="{ 'on-hover': hover }"
    >
      <v-card-text>
        <v-list-item>
          <!--USER PROFILE-->
          <v-list-item-avatar height="80" width="80" class="mb-14">
            <v-img size="100" :src="url + student.profile"> </v-img>
          </v-list-item-avatar>
          <v-list-item-content class="ml-5">
            <div class="text-h7 text-overline">
              {{ student.class }}
            </div>
            <!--STUDENT NAME-->
            <div class="d-flex">
              <v-list-item-title class="text-h5 orange--text">
                {{student.first_name }}
                {{student.last_name }}
              </v-list-item-title>
            </div>

            <!--REQUEST-->
            <v-list-item-content class="text-h7 mb-0 text-overline">
              Leave Type: {{ permission.reason }}
            </v-list-item-content>

            <!--DATE TIME -->
            <v-divider class="mt-0"></v-divider>
            <v-list-item-subtitle class="mt-0 d-flex">
              <div class="text-h6 text-overline">
                <strong> Leave on: </strong>
                <v-icon class="blue--text">mdi-calendar-text</v-icon>
                <strong> {{ permission.start_date }} </strong>
              </div>
              <div class="text-h6 ml-10 text-overline">
                <strong>Come back on: </strong>
                <v-icon class="red--text">mdi-calendar-text</v-icon>
                <strong> {{ permission.end_date }}</strong>
              </div>
              <div class="text-h6 ml-10 text-overline">
                <v-icon class="orange--text">mdi-calendar-text</v-icon>
                <strong> Amount:</strong> <strong v-html="((new Date(permission.end_date)).getTime() - (new Date(permission.start_date)).getTime()) / (1000 * 3600 * 24)" ></strong> | DAYS
              </div>
            </v-list-item-subtitle> 
          </v-list-item-content>
        </v-list-item>
      </v-card-text>

      <!--BTN HOVER-->
      <v-card-actions>
        <v-btn
          text
          :class="{ 'show-btn-detail': hover }"
          :color="transparent"
          @click="reveal = true"
        >
          <v-icon :class="{ 'show-btn-detail': hover }" :color="transparent">
            mdi-eye
          </v-icon>
          | view
        </v-btn>
      </v-card-actions>
      <!--BTN HOVER-->
      <v-expand-transition>
        <v-card
          v-if="reveal"
          class="transition-fast-in-fast-out v-card--reveal"
          height="100%"
        >
          <v-card-text class="pb-0">
            <p class="text-h4 text--primary">DISCRIPTION</p>
            <p>
              {{ permission.description }}
            </p>
          </v-card-text>
          <v-card-actions class="pt-0">
            <v-btn text color="teal accent-4" @click="reveal = false">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-expand-transition>
    </v-card>
  </v-hover>

  
</template>

<!--~!~!~!~!~!~!~!~!~!~!~|SCRIPT|~!~!~!~!~!~!~!~!~!~!~-->
<script>
export default {
  props: ["permission", "student"],

  data() {
    return {
      transparent: "rgba(255, 255, 255, 0)",
      url: "http://localhost:8000/storage/images/",
      role: "",
      reveal: false,
    };
  },
  mounted() {
      this.role = localStorage.getItem("role");
      console.log(this.permission, this.student)
  },

};
</script>


<!--~!~!~!~!~!~!~!~!~!~!~|STYLE|~!~!~!~!~!~!~!~!~!~!~-->
<style scoped>
.wrapper {
  background: url(https://cdn.pixabay.com/photo/2016/08/11/23/48/mountains-1587287_960_720.jpg)
    fixed;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  height: 100vh;
}

#card {
  border-left: 10px solid #4281f5;
}

h3 {
  font-weight: 400;
}

.show-btn-detail {
  color: blueviolet !important;
  font-weight: 400;
  font-family: "Times New Roman", Times, serif;
}

.show-btn-remove {
  color: orangered !important;
  font-weight: 400;
  font-family: "Times New Roman", Times, serif;
}

.show-btn-edit {
  color: #20de20 !important;
  font-weight: 400;
  font-family: "Times New Roman", Times, serif;
}
</style>