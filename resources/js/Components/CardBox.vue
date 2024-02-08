<script setup>
import { mdiCog } from "@mdi/js";
import { computed, useSlots } from "vue";
// import BaseIcon from "@/Components/BaseIcon.vue";

const props = defineProps({
  title: {
    type: String,
    default: null,
  },
  icon: {
    type: String,
    default: null,
  },
  headerIcon: {
    type: String,
    default: null,
  },
  rounded: {
    type: String,
    default: "rounded-xl",
  },
  hasTable: Boolean,
  empty: Boolean,
  form: Boolean,
  hoverable: Boolean,
  modal: Boolean,
});

const emit = defineEmits(["header-icon-click", "submit"]);

const is = computed(() => (props.form ? "form" : "v-card"));

const slots = useSlots();

const footer = computed(() => slots.footer && !!slots.footer());

const componentClass = computed(() => {
  const base = [
    props.rounded,
    props.modal ? "dark:bg-slate-900" : "dark:bg-slate-900/70",
  ];

  if (props.hoverable) {
    base.push("hover:shadow-lg transition-shadow duration-500");
  }

  return base;
});

const computedHeaderIcon = computed(() => props.headerIcon ?? "mdi-cog");

const headerIconClick = () => {
  emit("header-icon-click");
};

const submit = (e) => {
  emit("submit", e);
};
</script>

<template>
  <component
    :is="is"
    :class="componentClass"
    class="bg-grey-lighten-3 flex flex-col"
    @submit="submit"
  >
    <VCardItem>
      <VCardTitle v-if="title" class="d-flex align-stretch">
        <!-- class="flex items-stretch border-b border-gray-100 dark:border-slate-800" -->
        <div
          class="d-flex items-center py-3 grow font-bold"
          :class="[icon ? 'px-4' : 'px-6']"
        >
          <VIcon v-if="icon" :icon="icon" class="mr-3" />
          {{ title }}
        </div>
        <!-- class="flex items-center py-3 px-4 justify-center ring-blue-700 focus:ring" -->
        <VBtn
          @click="headerIconClick"
          :icon="computedHeaderIcon"
          variant="text"
        >
        </VBtn>
      </VCardTitle>
    </VCardItem>
    <v-card-text
      v-if="empty"
      class="text-center py-24 text-gray-500 dark:text-slate-400"
    >
      <p>Nothing's here…</p>
    </v-card-text>
    <v-card-text v-else class="flex-1" :class="{ 'pa-6': !hasTable }">
      <slot />
      <v-footer
        v-if="footer"
        class="p-6 border-t border-gray-100 dark:border-slate-800"
      >
        <slot name="footer" />
      </v-footer>
    </v-card-text>
  </component>
</template>
