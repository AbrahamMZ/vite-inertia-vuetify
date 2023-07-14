<script setup>
import { useLayoutStore } from "@/Stores/layout.js";
import { useStyleStore } from "@/Stores/style.js";
import { router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import NestedMenu from "../Components/NestedMenu.vue";

const styleStore = useStyleStore();
const layoutStore = useLayoutStore();

const drawer = ref(true);
const toggleLightDark = () => {
  styleStore.setDarkMode();
};
const rail = ref(false)
const logout = () => router.post(route('logout'))
</script>

<template>
  <VApp :theme="styleStore.darkMode ? 'dark' : 'light'">
    <VNavigationDrawer v-model="drawer" class="text-xs" :rail="rail" :expand-on-hover="rail">
      <v-list>
        <v-list-item prepend-avatar="https://cdn.vuetifyjs.com/images/john.png" :title="$page.props.auth.user.name"
          :subtitle="$page.props.auth.user.email">
          <template v-slot:append>
            <v-btn v-if="rail" @click.prevent="rail = false" size="small" variant="text" icon="mdi-menu-open"></v-btn>
            <v-btn v-else @click.prevent="rail = true" size="small" variant="text" icon="mdi-backburger"></v-btn>
          </template>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>
      <nested-menu :menus="$page.props.navigation.menu" @click.prevent="rail = false"></nested-menu>
      <template v-slot:append>
        <v-btn block color="primary" @click="logout">
          <VIcon v-if="rail" icon="mdi-logout-variant"></VIcon>
          <span v-else>Log Out</span>
        </v-btn>
      </template>
    </VNavigationDrawer>
    <v-app-bar app>
      <VAppBarNavIcon @click="drawer = !drawer"></VAppBarNavIcon>
      <v-toolbar-title>Admin Pages Layout</v-toolbar-title>
      <v-spacer></v-spacer>
      <VBtn icon @click.prevent="toggleLightDark">
        <VIcon v-if="styleStore.darkMode">mdi-theme-light-dark</VIcon>
        <VIcon v-else>mdi-brightness-4</VIcon>
      </VBtn>
      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main class="bg-green-lighten-4">
      <v-container fluid  >
        <v-sheet rounded="xl">
          <slot />
        </v-sheet>
      </v-container>
    </v-main>
    <v-snackbar :model-value="!!$page.props.flash.message" color="success" timeout="4000" location="top right">
      <span class="title">
        {{ $page.props.flash.message }}
      </span>
    </v-snackbar>
  </VApp>
</template>
