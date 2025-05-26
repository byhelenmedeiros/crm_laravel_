<template>
  <AuthenticatedLayout>
    <form @submit.prevent="submit">
      <div>
        <label>Nome</label>
        <input v-model="form.name" />
      </div>
      <div>
        <label>E-mail</label>
        <input v-model="form.email" type="email" />
      </div>

      <div>
        <label>Senha</label>
        <input v-model="form.password" type="password" />
      </div>

      <div>
        <label>Confirmar Senha</label>
        <input v-model="form.password_confirmation" type="password" />
      </div>

      <div>
        <label>Departamento</label>
        <input :value="teamName" disabled />
      </div>

      <button :disabled="form.processing">Criar Usuário</button>
    </form>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const teamName = ref(page.props.auth.user.team_name || ''); 

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('users.team.store'), {
    onSuccess: () => form.reset(),
  });
};
</script>
