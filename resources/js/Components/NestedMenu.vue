<template>
  <v-list mandatory>
    <v-list-subheader v-if="!isChild">Menu</v-list-subheader>
    <template v-for="menu in menus" :key="menu.id">
      <v-list-item v-if="menu.enabled && !menu.children" :key="menu.id" active-color="primary" :title="menu.name"
        :prepend-icon="isChild ? 'mdi' : 'mdi-menu'" :append-icon="isChild ? 'mdi-menu' : 'mdi'" link
        @click="click(menu.link)">
      </v-list-item>
      <v-list-group v-else-if="menu.children && menu.enabled" :prepend-icon="isChild ? 'mdi' : 'mdi-group'"
        :value="menu.name">
        <template #activator="{ props }">
          <v-list-item v-bind="props" :value="menu.id" :title="menu.name">
          </v-list-item>
        </template>
        <NestedMenu :menus="menu.children" is-child />
      </v-list-group>
    </template>
  </v-list>
</template>
  
<script setup>
import { router } from "@inertiajs/vue3";

defineProps({ menus: Array, isChild: { type: Boolean, default: false } });

const click = (link) => {
  router.visit(link);
};
</script>
  