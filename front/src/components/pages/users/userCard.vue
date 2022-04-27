<template>
  <tr
    class="text-left"
    :class="
      user.roles === 'ADMIN'
        ? 'adminColor'
        : user.roles === 'STUDENT'
        ? 'studentColor'
        : 'edColor'
    "
  >
    <td>
      <v-list-item-avatar>
        <v-img
          :src="
            user.student === null
              ? user.profile
              : url + user.student.profile
          "
        ></v-img>
      </v-list-item-avatar>
    </td>
    <td>{{ user.username }}</td>
    <td>{{ user.email }}</td>
    <td>{{ user.roles }}</td>
    <td :class="user.roles !== 'ADMIN' ? ' align-center' : ''" v-if="role === 'ADMIN' ">
      <v-btn class="mr-1" icon color="success" @click="toEditUser(user)">
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
      <v-btn
        class="ml-1"
        icon
        color="red white--text"
        v-if="user.roles !== 'ADMIN'"
        @click="toRemoveUser(user.id)"
      >
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["user"],
  emits: ["requestToDeleteUser", "requestToEdit"],
  data() {
    return {
      url: "http://localhost:8000/storage/images/",
      role: ''
    };
  },
  methods: {
    toRemoveUser(id) {
      this.$emit("requestToDeleteUser", id);
    },
    toEditUser(user) {
      this.$emit("requestToEdit", user);
    },
  },
  mounted() {
    this.role = localStorage.getItem("role");

  },
};
</script>
<style>
.adminColor {
  background: #18ffff48;
}
.studentColor {
  background: #ffa60062;
  
}

.edColor {
  background: #00ffd575;
}
</style>
