<template>
  <!--~!~!~!~!~!~!~!~!~!~!~|CARD|~!~!~!~!~!~!~!~!~!~!~-->
  <v-hover v-slot="{ hover }" class="mt-3">
    <v-card
      id="card"
      class="mx-auto"
      max-width="auto"
      :elevation="hover ? 24 : 6"
      :class="{ 'on-hover': hover }"
    >
      <v-card-text>
        <v-list-item>
          <!--USER PROFILE-->
          <v-list-item-avatar height="80" width="80" class="mb-14">
            <v-img size="100" :src="url + permission.students.profile"> </v-img>
          </v-list-item-avatar>
          <v-list-item-content class="ml-5">
            <div class="text-h7 text-overline">
              {{ permission.students.class }}
            </div>
            <!--STUDENT NAME-->
            <div class="d-flex click" >
              <v-list-item-title class="text-h5 orange--text" @click="pushDataToStudentView(permission.students.id)">
                {{ permission.students.first_name }}
                {{ permission.students.last_name }}
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
                <strong> Amount:</strong>
                <strong
                  v-html="
                    (new Date(permission.end_date).getTime() -
                      new Date(permission.start_date).getTime()) /
                    (1000 * 3600 * 24)
                  "
                ></strong>
                | DAYS
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
        <v-btn
          v-if="role !== 'STUDENT'"
          text
          :class="{ 'show-btn-edit': hover }"
          :color="transparent"
          @click.prevent="editPermission(permission)"
        >
          <v-icon :class="{ 'show-btn-edit': hover }" :color="transparent">
            mdi-pencil
          </v-icon>
          | edit
        </v-btn>

        <v-btn
          text
          v-if="role !== 'STUDENT'"
          :class="{ 'show-btn-remove': hover }"
          :color="transparent"
          @click="deletePermission(permission.id)"
        >
          <v-icon :class="{ 'show-btn-remove': hover }" :color="transparent">
            mdi-delete
          </v-icon>
          | remove
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
  emits: ["permissiontEdit", "permissionToDelete"],

  data() {
    return {
      transparent: "rgba(255, 255, 255, 0)",
      url: "http://localhost:8000/storage/images/",
      role: "",
      stu_id: "",
      reveal: false,
    };
  },
  computed: {},
  methods: {
    editPermission(permission) {
      this.$emit("permissiontEdit", permission);
      console.log("permission edit", permission);
    },
    deletePermission(id) {
      this.$emit("permissionToDelete", id);
    },
    pushDataToStudentView(id) {
      if(this.role !== 'STUDENT') {
        this.$router.push({
          path: "/studentDetail/" + id,
          params: { studentId: id },
        });
      }
    },
  },
  mounted() {
    this.role = localStorage.getItem("role");
    this.stu_id = localStorage.getItem("studentId");
  },
};
</script>

<!--~!~!~!~!~!~!~!~!~!~!~|STYLE|~!~!~!~!~!~!~!~!~!~!~-->
<style scoped>
.click:hover {
  cursor: pointer;
}
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
