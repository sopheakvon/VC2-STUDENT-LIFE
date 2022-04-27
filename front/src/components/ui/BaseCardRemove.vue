<template>
  <v-card>
    <v-card-title class="headline">Remove User</v-card-title>
    <v-card-text> Are you sure ? </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="red darken-1" flat="flat" @click="dialog = true"
        >Remove</v-btn
      >
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
    };
  },
};
</script>