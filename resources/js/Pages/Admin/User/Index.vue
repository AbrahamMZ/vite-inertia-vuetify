<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import Pagination from "@/Components/Admin/Pagination.vue";
import Sort from "@/Components/Admin/Sort.vue";
import { watchEffect } from "vue";

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

const form = useForm({
    search: props.filters.search,
    name: "",
    email: "",
});

watchEffect(
    async () => {
        await form.get(route("user.index"), {
            preserveState: true,
            preserveScroll: false,
            replace: true,
        });
    },
    {
        flush: "post",
    }
);

const formDelete = useForm({});

function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        formDelete.delete(route("user.destroy", id));
    }
}
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

            <VSheet class="d-flex flex-wrap">
                <VTextField
                    v-model="form.name"
                    variant="outlined"
                    density="compact"
                    placeholder="Buscar Nombre"
                    persistent-placeholder
                    hide-details
                    clearable
                    class="ma-2 pa-2"
                />
                <VTextField
                    v-model="form.email"
                    variant="outlined"
                    density="compact"
                    placeholder="Buscar Email"
                    persistent-placeholder
                    hide-details
                    clearable
                    class="ma-2 pa-2"
                />
                <VTextField
                    v-model="form.search"
                    variant="outlined"
                    density="compact"
                    placeholder="Buscar"
                    persistent-placeholder
                    hide-details
                    clearable
                    class="ma-2 pa-2"
                />
            </VSheet>

            <VTable>
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
            </VTable>
        </VContainer>
    </LayoutAuthenticated>
</template>
