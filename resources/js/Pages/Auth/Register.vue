<script setup>
import { useForm, usePage, Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutGuest from '@/Layouts/LayoutGuest.vue'

import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'


const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: [],
})

const hasTermsAndPrivacyPolicyFeature = computed(() => usePage().props.value?.jetstream?.hasTermsAndPrivacyPolicyFeature)

const submit = () => {
  form
    .transform(data => ({
      ...data,
      terms: form.terms && form.terms.length
    }))
    .post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
  <LayoutGuest>

    <Head title="Register" />
    <VContainer fluid class="d-flex justify-center align-center fill-height">
      <v-card title="Register" subtitle="Crear un cuenta " min-width="500" elevation="6">
        <VCardText>
          <VForm @submit.prevent="submit">
            <VTextField v-model="form.name" variant="outlined" label="Nombre" prepend-icon="mdi-account"
              :error-messages="$page.props.errors.name" />
            <VTextField v-model="form.email" type="email" variant="outlined" label="Email" prepend-icon="mdi-email"
              :error-messages="$page.props.errors.email" />
            <VTextField v-model="form.password" type="password" variant="outlined" label="Password"
              prepend-icon="mdi-lock-outline" :error-messages="$page.props.errors.password" />
            <VTextField v-model="form.password_confirmation" type="password" variant="outlined" label="Confirmar Password"
              prepend-icon="mdi-lock-outline" :error-messages="$page.props.errors.password_confirmation" />


            <v-checkbox v-if="hasTermsAndPrivacyPolicyFeature" v-model="form.terms" color="secondary"
              label="I agree to site terms and conditions"></v-checkbox>
            <VDivider />

            <div class="d-flex justify-end mt-4">
              <VBtn type="submit" color="primary" theme="dark"> Register </VBtn>
              <VBtn :href="route('login')" variant="text" class="ml-2" color="primary">Login</VBtn>
            </div>
          </VForm>
        </VCardText>
      </v-card>
    </VContainer>
  </LayoutGuest></template>
