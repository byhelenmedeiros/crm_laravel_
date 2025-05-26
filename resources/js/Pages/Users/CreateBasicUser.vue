<template>
  <form @submit.prevent="submit">
    <div>
      <label for="name">Nome</label>
      <input v-model="form.name" type="text" id="name" required />
    </div>
    <div>
      <label for="email">Email</label>
      <input v-model="form.email" type="email" id="email" required />
    </div>
    <div>
      <label for="password">Senha</label>
      <input v-model="form.password" type="password" id="password" required />
    </div>
    <div>
      <label for="password_confirmation">Confirmar Senha</label>
      <input v-model="form.password_confirmation" type="password" id="password_confirmation" required />
    </div>
    <button type="submit" :disabled="form.processing">Criar Usuário</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('users.store'), {
    onSuccess: () => {
      console.log('Usuário criado com sucesso!');
    },
    onError: () => {
      console.log('Erro ao criar usuário!');
    },
  });
};
</script>
