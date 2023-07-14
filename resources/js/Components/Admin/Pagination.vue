<script setup>
import { router } from '@inertiajs/vue3';
import {  reactive, watchEffect } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    routeName: {
        type: String,
        default: "",
    },
    page: {
        type: Number,
    },
    per_page: {
        type: Number,
    }
})
const options = reactive({
    page: props.page | 1,
    per_page: props.per_page | 5,
})

watchEffect(async () => {
    if (options.page != props.data?.current_page || options.per_page != props.data?.per_page
    ) {
        let sort = new URL(document.location).searchParams.get("sort")
        let search = new URL(document.location).searchParams.get("search")
        await router.get(route(props.routeName), { ...options, sort,search }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        })
    }
}, {
    flush: 'post'
}
)
</script>

<template>
    <div class="d-flex mt-3">
        <div class="w-100">
            <div class="d-flex justify-space-between align-center">
                <div class="d-flex flex-row align-center text-overline">
                    Por Pagina:
                    <VSelect v-model="options.per_page" :items="[1, 5, 10, 15, -1]" density="compact" variant="outlined"
                        hide-details style="max-width: 70px;" class="mx-2"></VSelect>
                    <span class="mr-2">{{ data.from }}-{{ data.to }} de {{ data.total }}</span>
                    <!-- Pagina Actual: {{ data.current_page }} Ultima: {{ data.last_page }} -->
                </div>
                <div class="d-flex flex-row align-center">
                    <v-pagination v-model="options.page" :length="data.last_page" :total-visible="5"></v-pagination>
                </div>
            </div>
        </div>
    </div>
</template>