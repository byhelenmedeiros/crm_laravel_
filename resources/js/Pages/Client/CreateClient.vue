<template>
  <Head title="Criar Cliente" />
  <AuthenticatedLayout>
    <div class="p-4 rounded-sm bg-white max-w-full">
      <h1 class="text-xl font-semibold mb-4">Criar Novo Cliente</h1>

      <!-- Mostrar erros de validação -->
      <div v-if="form.errors.general" class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
          <li v-for="(msg, idx) in form.errors.general" :key="idx">{{ msg }}</li>
        </ul>
      </div>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Dados do Cliente -->
        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-[200px]">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Cliente</label>
            <input
              id="name"
              type="text"
              v-model="form.name"
              placeholder="Nome do Cliente"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
          </div>

          <div class="flex-1 min-w-[200px]">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input
              id="email"
              type="email"
              v-model="form.email"
              placeholder="exemplo@dominio.com"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
          </div>
        </div>

        <!-- Dados do Endereço -->
        <h2 class="font-semibold mb-3 mt-8">Dados do Endereço</h2>

        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-[200px]">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
            <input
              id="address"
              type="text"
              v-model="form.address"
              placeholder="Endereço do Cliente"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</p>
          </div>

          <div class="flex-1 min-w-[200px]">
            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
            <input
              id="city"
              type="text"
              v-model="form.city"
              placeholder="Cidade do Cliente"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.city" class="text-red-500 text-xs mt-1">{{ form.errors.city }}</p>
          </div>
        </div>

        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-[200px]">
            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <input
              id="state"
              type="text"
              v-model="form.state"
              placeholder="Estado do Cliente"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.state" class="text-red-500 text-xs mt-1">{{ form.errors.state }}</p>
          </div>

          <div class="flex-1 min-w-[200px]">
            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
            <input
              id="postal_code"
              type="text"
              v-model="form.postal_code"
              placeholder="Código Postal"
              class="w-full border border-gray-300 rounded-sm px-2 py-1 text-sm focus:outline-none focus:border-blue-500"
            />
            <p v-if="form.errors.postal_code" class="text-red-500 text-xs mt-1">{{ form.errors.postal_code }}</p>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="text-left text-blue-600 hover:text-blue-800 text-sm font-semibold px-0 py-1 border-0 bg-transparent"
            :disabled="form.processing"
          >
            Criar Cliente
          </button>
        </div>
      </form>

      <div v-if="form.errorMessages.length" class="mt-4 bg-red-50 border border-red-400 p-4 rounded text-sm text-red-700">
        <h3 class="font-semibold mb-2">Erros do formulário:</h3>
        <ul class="list-disc pl-5 space-y-1">
          <li v-for="(msg, idx) in form.errorMessages" :key="idx">{{ msg }}</li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const toast = useToast()

const form = useForm({
  name: '',
  email: '',
  address: '',
  city: '',
  state: '',
  postal_code: '',
  country: '',
  errors: {
    name: '',
    email: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
  },
  processing: false,
  errorMessages: [],
})

const submit = () => {
  form.errorMessages = []

  form.processing = true

  form.post(route('clients.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Cliente criado com sucesso!')
      form.reset()
      form.errorMessages = []
    },
    onError: (errors) => {
      toast.error('Erro ao criar cliente. Verifique os dados.')
      if (errors) {
        form.errorMessages = errors
      }
    },
    onFinish: () => {
      form.processing = false
    },
  })
}
</script>

<style scoped>
/* Custom styles here if needed */
</style>
