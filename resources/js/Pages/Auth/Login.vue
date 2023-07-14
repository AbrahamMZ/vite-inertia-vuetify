<script setup>
import { useForm, Head, router } from "@inertiajs/vue3";
import LayoutGuest from "@/Layouts/LayoutGuest.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
  canResetPassword: Boolean,
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: [],
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember && form.remember.length ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <LayoutGuest>

    <Head title="Login" />
    <VContainer fluid class="d-flex justify-center align-center fill-height">
      <VCard title="Login" subtitle="Ingrese sus credenciales" min-width="500px" elevation="6">
        <template #append>
          <VAvatar size="80">
            <application-logo></application-logo>
          </VAvatar>
        </template>
        <VCardText>
          <VForm @submit.prevent="submit">
            <v-text-field v-model="form.email" type="email" label="E-mail"
              :error-messages="$page.props.errors.email"></v-text-field>

            <v-text-field v-model="form.password" type="password" label="Password"
              :error-messages="$page.props.errors.password"></v-text-field>

            <v-checkbox v-model="form.remember" label="remember" type="checkbox"></v-checkbox>

            <div class="d-flex justify-end align-center">
              <v-btn class="me-4" type="submit" color="primary"> Login </v-btn>
              <v-btn v-if="canResetPassword" variant="text" @click="router.get(route('password.request'))" class="me-4">
                remind
              </v-btn>
              <VBtn variant="text" @click="router.get(route('register'))"> Register </VBtn>
            </div>
          </VForm>
        </VCardText>
      </VCard>
    </VContainer>
  </LayoutGuest>
</template>
