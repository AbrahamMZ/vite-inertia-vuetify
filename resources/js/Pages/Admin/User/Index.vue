<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import { VDataTableServer } from "vuetify/labs/VDataTable";
import { reactive, ref, watch } from "vue";

const props = defineProps({
  users: {
    type: Object,
    default: () => ({}),
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
});

const loading = ref(true);
const headers = ref([
  {
    title: "Usuario",
    align: "start",
    sortable: true,
    key: "name",
  },
  {
    title: "Email",
    align: "center",
    sortable: true,
    key: "email",
  },
  { title: "Acciones", key: "actions", align: "end", sortable: false },
]);

const filters = reactive({
  search: "",
  name: "",
  email: "",
});

const pagination = reactive({
  itemsPerPage: 5,
  page: 1,
  sortBy: [],
});

const formDelete = useForm({});
function destroy(id) {
  if (confirm("Are you sure you want to delete?")) {
    formDelete.delete(route("user.destroy", id));
  }
}

let _timeout = null;
watch(
  filters,
  () => {
    clearTimeout(_timeout);
    _timeout = setTimeout(() => {
      loadItems(pagination);
    }, 1200);
  },
  { immediate: false }
);

const loadItems = async (options) => {
  let params = {
    ...filters,
    ...options,
    per_page: options.itemsPerPage,
    sort: options.sortBy.reduce((_, obj) => {
      return obj.order === "desc" ? `-${obj.key}` : obj.key;
    }, {}),
  };

  await router.get(route("user.index"), params, {
    preserveState: true,
    preserveScroll: false,
    replace: true,
    onStart: () => {
      loading.value = true;
    },
    onFinish: () => {
      loading.value = false;
    },
  });
};

const print = () => window.print();
const cleanFilter = () => {
  Object.assign(filters, {
    search: "",
    name: "",
    email: "",
  });
};
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Users" />
    <VContainer fluid>
      <VToolbar density="compact" class="pa-3" color="transparent">
        <VIcon icon="mdi-account" size="x-large"></VIcon>
        <VToolbarTitle class="text-h4">Usuarios</VToolbarTitle>
        <VSpacer />
        <VBtn
          prepend-icon="mdi-plus"
          color="info"
          variant="outlined"
          @click="router.get(route('user.create'))"
        >
          Agregar
        </VBtn>
      </VToolbar>
      <VAlert
        :model-value="!!$page.props.flash.message"
        type="info"
        title="Notificacion"
        :text="$page.props.flash.message"
        closable
        class="pa-3"
      >
      </VAlert>

      <VSheet class="d-flex flex-wrap align-center">
        <VTextField
          v-model="filters.name"
          variant="outlined"
          density="compact"
          placeholder="Buscar Nombre"
          persistent-placeholder
          hide-details
          clearable
          class="ma-2 pa-2"
        />
        <VTextField
          v-model="filters.email"
          variant="outlined"
          density="compact"
          placeholder="Buscar Email"
          persistent-placeholder
          hide-details
          clearable
          class="ma-2 pa-2"
        />
        <VTextField
          v-model="filters.search"
          variant="outlined"
          density="compact"
          placeholder="Buscar"
          persistent-placeholder
          hide-details
          clearable
          class="ma-2 pa-2"
        />
        <VBtn
          icon="mdi-filter-remove-outline"
          color="red"
          variant="text"
          @click="cleanFilter"
        />
        <VBtn icon="mdi-microsoft-excel" color="green" variant="text" />
        <VBtn icon="mdi-printer" color="black" variant="text" @click="print" />
        <VBtn
          icon="mdi-refresh"
          color="primary"
          variant="text"
          :loading="loading"
          @click="loadItems(pagination)"
        />
      </VSheet>

      <v-data-table-server
        :headers="headers"
        :items="users.data"
        :items-length="users.total"
        :items-per-page-options="[
          { value: 5, title: '5' },
          { value: 10, title: '10' },
          { value: 25, title: '25' },
          { value: -1, title: '$vuetify.dataFooter.itemsPerPageAll' },
        ]"
        :loading="loading"
        class="elevation-3 rounded-xl"
        item-value="id"
        density="compact"
        @update:options="loadItems"
        v-model:options="pagination"
      >
        <!-- v-model:items-per-page="users.per_page"
        v-model:page="users.current_page" -->
        <template v-slot:[`item.actions`]="{ item }">
          <VBtn
            icon="mdi-pencil"
            variant="plain"
            size="small"
            color="green-darken-4"
            @click="router.get(route('permission.edit', item.value))"
          >
          </VBtn>
          <VBtn
            icon="mdi-trash-can"
            variant="plain"
            size="small"
            color="red-darken-4"
            @click="destroy(item.value)"
          >
          </VBtn>
        </template>
      </v-data-table-server>

      <!-- <VTable>
                <thead>
                    <tr>
                        <th>
                            <Sort label="Name" attribute="name" />
                        </th>
                        <th>
                            <Sort label="Email" attribute="email" />
                        </th>
                        <th v-if="can.edit || can.delete">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td data-label="Name">
                            <VBtn
                                variant="text"
                                :ripple="false"
                                color="blue"
                                @click="router.get(route('user.show', user.id))"
                            >
                                {{ user.name }}
                            </VBtn>
                        </td>
                        <td data-label="Email">
                            {{ user.email }}
                        </td>
                        <td
                            v-if="can.edit || can.delete"
                            class="before:hidden lg:w-1 whitespace-nowrap"
                        >
                            <VBtn
                                v-if="can.edit"
                                variant="plain"
                                icon="mdi-pencil"
                                @click="router.get(route('user.edit', user.id))"
                            >
                            </VBtn>
                            <VBtn
                                v-if="can.delete"
                                variant="plain"
                                icon="mdi-trash-can"
                                color="error"
                                @click="destroy(user.id)"
                            >
                            </VBtn>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">
                            <Pagination
                                :data="users"
                                :route-name="'user.index'"
                            />
                        </td>
                    </tr>
                </tfoot>
            </VTable> -->
    </VContainer>
  </LayoutAuthenticated>
</template>
