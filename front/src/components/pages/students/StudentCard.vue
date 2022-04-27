<template>
  <tr
    :class="student.gender === 'Male' ? 'maleStudent' : 'femaleStudent'"
    @click="pushDataToStudentView(student.id)"
  >
    <td>
      <v-list-item-avatar>
        <v-img :src="url + student.profile"> </v-img>
      </v-list-item-avatar>
    </td>
    <td>{{ student.first_name }}</td>
    <td>{{ student.last_name }}</td>
    <td>{{ student.gender }}</td>
    <td>{{ student.class }}</td>
    <td>{{ student.phone }}</td>
    <td class="text-center" v-if="role !== 'STUDENT'">
      <v-btn
        icon
        color="success"
        @click.stop="editStudent(student)"
        
      >
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
      <v-btn
        icon
        color="red white--text"
        @click.stop="deleteStudent(student.id)"
       
      >
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["student"],
  emits: ["studentEdit", "studentDelete", "studentData"],
  data() {
    return {
      url: "http://localhost:8000/storage/images/",
      role: "",
    };
  },
  methods: {
    editStudent(studentData) {
      this.$emit("studentEdit", studentData);
    },
    deleteStudent(id) {
      this.$emit("studentDelete", id);
    },
    pushDataToStudentView(id) {
      this.$router.push({
        path: '/studentDetail/' + id,
        params: { studentId: id },
      });
    }
  },

  mounted() {
    this.role = localStorage.getItem("role");
  },
};
</script>

<style scoped>
tr:hover {
  cursor: pointer;
}
.maleStudent {
  background: #007bdf5d;
}
.femaleStudent {
  background: #00d1b55b;
}
</style>