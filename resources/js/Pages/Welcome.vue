<script setup>
import { Head, router } from "@inertiajs/vue3";
import NestedMenu from "../Components/NestedMenu.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});

const click = (route) => {
  router.visit(route);
};
</script>

<template>
  <Head title="Welcome ETBSA" />
  <v-app theme="dark">
    <v-app-bar app>
      <v-toolbar-title>ETBSA</v-toolbar-title>
      <v-spacer></v-spacer>
      <div v-if="canLogin" class="d-flex flex-row">
        <VBtn v-if="$page.props.auth.user" @click="click(route('dashboard'))">
          Dashboard
        </VBtn>

        <template v-else>
          <VBtn @click="click(route('login'))"> Log in </VBtn>

          <VBtn v-if="canRegister" @click="click(route('register'))">
            Register
          </VBtn>
        </template>
      </div>
      <!-- <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn> -->
    </v-app-bar>

    <v-main class="bg-blue-lighten-4">
      <v-container fluid>
        <v-row>
          <v-col>
            <v-sheet min-height="85dvh" rounded="lg"> </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

