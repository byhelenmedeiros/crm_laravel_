<template>
  <div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Criar Novo Usuário</h1>
    <form @submit.prevent="submit">
      <!-- Campo Nome -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input
          id="name"
          type="text"
          v-model="form.name"
          placeholder="Digite o nome"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
          {{ form.errors.name }}
        </div>
      </div>
      
      <!-- Campo E-mail -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          placeholder="exemplo@dominio.com"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">
          {{ form.errors.email }}
        </div>
      </div>
      
      <!-- Campo Senha -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
        <input
          id="password"
          type="password"
          v-model="form.password"
          placeholder="Digite a senha"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">
          {{ form.errors.password }}
        </div>
      </div>

      <!-- Campo Confirmação de Senha -->
      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
        <input
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          placeholder="Confirme a senha"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs mt-1">
          {{ form.errors.password_confirmation }}
        </div>
      </div>
      
      <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md"
      >
        Criar Usuário
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

// Inicializa o formulário com os campos necessários.
// Note que o campo 'role' não é exposto pois o controlador já definirá o role "user".
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

// Ao submeter, os dados do formulário são enviados para a rota 'users.store'
const submit = () => {
  form.post(route('users.store'))
}
</script>
