<template>
  <Head title="Criar utilizador" />
  <AuthenticatedLayout>
    <div class="mx-auto p-4 bg-white rounded shadow-sm max-w-3xl">

      <h1 class="text-xl font-semibold mb-4">Criar novo utilizador</h1>

      <form @submit.prevent="submit" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Nome -->
          <div>
            <label for="name" class="block text-gray-700 mb-1 text-sm font-medium">Nome</label>
            <input
              id="name"
              type="text"
              v-model="form.name"
              placeholder="Nome completo"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600"
            />
            <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-gray-700 mb-1 text-sm font-medium">Email</label>
            <input
              id="email"
              type="email"
              v-model="form.email"
              placeholder="exemplo@dominio.pt"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600"
            />
            <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
          </div>

          <!-- Palavra passe -->
          <div>
            <label for="password" class="block text-gray-700 mb-1 text-sm font-medium">Palavra passe</label>
            <input
              id="password"
              type="password"
              v-model="form.password"
              placeholder="Digite a Palavra passe"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600"
            />
            <p v-if="form.errors.password" class="mt-1 text-xs text-red-600">{{ form.errors.password }}</p>
          </div>

          <!-- Confirmação de Palavra passe -->
          <div>
            <label for="password_confirmation" class="block text-gray-700 mb-1 text-sm font-medium">Confirmar Palavra passe</label>
            <input
              id="password_confirmation"
              type="password"
              v-model="form.password_confirmation"
              placeholder="Confirme a Palavra passe"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600"
            />
            <p v-if="form.errors.password_confirmation" class="mt-1 text-xs text-red-600">{{ form.errors.password_confirmation }}</p>
          </div>
        </div>

        <div class="pt-4 border-t border-gray-300">
          <button
            type="submit"
            class="text-pink-600 hover:text-pink-800 font-semibold text-sm"
            :disabled="form.processing"
          >
            Criar Usuário
          </button>
        </div>
      </form>

      <div v-if="form.errorMessages.length" class="mt-6 bg-red-50 border border-red-400 p-4 rounded text-sm text-red-700">
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
const errorMessages = ref([])

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  errorMessages.value = []

  form.post(route('users.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Usuário criado com sucesso!')
      form.reset()
      errorMessages.value = []
    },
    onError: (errors) => {
      toast.error('Erro ao criar usuário. Verifique os dados.')

    },
  })
}
</script>
