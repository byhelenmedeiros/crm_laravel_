<template>
  <div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Criar Administrador do Setor</h1>
    <form @submit.prevent="submit">
      <!-- Campo de Nome -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-semibold text-gray-700">Nome</label>
        <input
          id="name"
          type="text"
          v-model="form.name"
          placeholder="Nome do Administrador"
          class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
          {{ form.errors.name }}
        </div>
      </div>
      
      <!-- Campo de E-mail -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          placeholder="exemplo@dominio.com"
          class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">
          {{ form.errors.email }}
        </div>
      </div>
      
      <!-- Campo de Senha -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
        <input
          id="password"
          type="password"
          v-model="form.password"
          placeholder="Digite a senha"
          class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">
          {{ form.errors.password }}
        </div>
      </div>
      
      <!-- Campo de Confirmação de Senha -->
      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmar Senha</label>
        <input
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          placeholder="Confirme a senha"
          class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-blue-500"
        />
        <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs mt-1">
          {{ form.errors.password_confirmation }}
        </div>
      </div>
      
      <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"
      >
        Criar Administrador
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

// Cria o estado reativo do formulário e gerencia os erros automaticamente.
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

// Função para submeter os dados do formulário para a rota 'users.teamadmin.store'.
// Certifique-se de que a rota está configurada no Laravel e que o controlador trata os dados
// de modo a salvar o novo administrador associado ao mesmo setor.
const submit = () => {
  form.post(route('users.teamadmin.store'), {
    onSuccess: () => {
      // Ação opcional: reset do formulário após o sucesso ou redirecionamento.
      form.reset()
    },
    onError: (errors) => {
      // Você pode implementar uma notificação ou log se necessário.
      console.log('Erros de validação:', errors)
    },
  })
}
</script>
