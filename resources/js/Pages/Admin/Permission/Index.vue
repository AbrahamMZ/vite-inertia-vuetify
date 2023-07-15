<script setup>
import { Head, useForm, router } from "@inertiajs/vue3";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import { reactive, ref, watch } from "vue";
import { VDataTableServer } from "vuetify/labs/VDataTable";

const props = defineProps({
    permissions: {
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
        title: "Nombre Permiso",
        align: "start",
        sortable: true,
        key: "name",
    },
    {
        title: "Guard",
        align: "center",
        sortable: true,
        key: "guard_name",
    },
    { title: "Acciones", key: "actions", align: "end", sortable: false },
]);
const filters = reactive({
    search: "",
    name: "",
});

const formDelete = useForm({});
function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        formDelete.delete(route("permission.destroy", id));
    }
}
let _timeout = null;
watch(
    filters,
    () => {
        clearTimeout(_timeout);
        _timeout = setTimeout(() => {
            loadItems({ page: 1, itemsPerPage: 5 });
        }, 1200);
    },
    { immediate: false }
);

const loadItems = async ({
    page: page,
    itemsPerPage: per_page,
    sortBy: sort,
}) => {
    await router.get(
        route("permission.index"),
        { page, per_page, sort, ...filters },
        {
            preserveState: true,
            preserveScroll: false,
            replace: true,
            onStart: () => {
                loading.value = true;
            },
            onFinish: () => {
                loading.value = false;
            },
        }
    );
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Permissions" />
        <VContainer fluid>
            <VToolbar density="compact" class="pa-3" color="transparent">
                <VIcon icon="mdi-account" size="x-large"></VIcon>
                <VToolbarTitle class="text-h4">Permisos</VToolbarTitle>
                <VSpacer />
                <VBtn
                    prepend-icon="mdi-plus"
                    color="info"
                    variant="outlined"
                    @click="router.get(route('permission.create'))"
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
            <VToolbar flat class="pa-3 d-flex align center" color="transparent">
                <VSpacer />
                <VTextField
                    v-model="filters.search"
                    variant="outlined"
                    persistent-placeholder
                    style="min-width: 400px"
                    hide-details
                    placeholder="Buscar"
                    clearable
                />
            </VToolbar>

            <v-data-table-server
                v-model:items-per-page="permissions.per_page"
                v-model:page="permissions.current_page"
                :headers="headers"
                :items="permissions.data"
                :items-length="permissions.total"
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
            >
                <template v-slot:[`item.actions`]="{ item }">
                    <VBtn
                        icon="mdi-pencil"
                        variant="plain"
                        size="small"
                        color="green-darken-4"
                        @click="
                            router.get(route('permission.edit', item.value))
                        "
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
        </VContainer>
    </LayoutAuthenticated>
</template>
