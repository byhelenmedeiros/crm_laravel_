<template>
  <Head title="Criar Cliente" />
  <AuthenticatedLayout>
    <div class="mx-auto p-4 bg-white rounded shadow-sm">
      

      <h1 class="text-xl font-semibold mb-4">Criar Novo Cliente</h1>
      <p class="mb-6 text-gray-700 text-sm">Preencha os dados abaixo para criar um novo cliente.</p>

      <!-- Tabs -->
      <nav class="flex border-b border-gray-300 mb-6">
        <button
          @click="activeTab = 'cliente'"
          :class="tabClass('cliente')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Dados do Cliente
        </button>
        <button
          @click="activeTab = 'morada'"
          :class="tabClass('morada')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Morada
        </button>
      </nav>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Dados do Cliente -->
        <section v-if="activeTab === 'cliente'">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="name" class="block text-gray-700 mb-1 text-sm font-medium">Nome do Cliente</label>
              <input
                id="name"
                type="text"
                v-model="form.name"
                placeholder="Nome completo"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-rosa-500 focus:border-rosa-500"
              />
              <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
              <label for="email" class="block text-gray-700 mb-1 text-sm font-medium">Email</label>
              <input
                id="email"
                type="email"
                v-model="form.email"
                placeholder="exemplo@dominio.pt"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
              <label for="url" class="block text-gray-700 mb-1 text-sm font-medium">Website</label>
              <input
                id="url"
                type="url"
                v-model="form.url"
                placeholder="https://exemplo.com"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.url" class="mt-1 text-xs text-red-600">{{ form.errors.url }}</p>
            </div>
          </div>
        </section>

        <!-- Morada -->
        <section v-if="activeTab === 'morada'">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="address_type" class="block text-gray-700 mb-1 text-sm font-medium">Tipo de Morada</label>
              <input
                id="address_type"
                type="text"
                v-model="form.address_type"
                placeholder="Residencial, Comercial..."
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.address_type" class="mt-1 text-xs text-red-600">{{ form.errors.address_type }}</p>
            </div>

            <div>
              <label for="address" class="block text-gray-700 mb-1 text-sm font-medium">Morada Completa</label>
              <input
                id="address"
                type="text"
                v-model="form.address"
                placeholder="Rua, Avenida, Nº..."
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.address" class="mt-1 text-xs text-red-600">{{ form.errors.address }}</p>
            </div>

            <div>
              <label for="contact" class="block text-gray-700 mb-1 text-sm font-medium">Contacto</label>
              <input
                id="contact"
                type="text"
                v-model="form.contact"
                placeholder="Pessoa de contacto"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.contact" class="mt-1 text-xs text-red-600">{{ form.errors.contact }}</p>
            </div>

            <div>
              <label for="phone" class="block text-gray-700 mb-1 text-sm font-medium">Telefone</label>
              <input
                id="phone"
                type="text"
                v-model="form.phone"
                placeholder="(XX) XXXX-XXXX"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">{{ form.errors.phone }}</p>
            </div>

            <div>
              <label for="line1" class="block text-gray-700 mb-1 text-sm font-medium">Complemento 1</label>
              <input
                id="line1"
                type="text"
                v-model="form.line1"
                placeholder="Ex.: Bairro, Apartamento"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.line1" class="mt-1 text-xs text-red-600">{{ form.errors.line1 }}</p>
            </div>

            <div>
              <label for="line2" class="block text-gray-700 mb-1 text-sm font-medium">Complemento 2</label>
              <input
                id="line2"
                type="text"
                v-model="form.line2"
                placeholder="Ex.: Referência, Entrada"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.line2" class="mt-1 text-xs text-red-600">{{ form.errors.line2 }}</p>
            </div>

            <div>
              <label for="line3" class="block text-gray-700 mb-1 text-sm font-medium">Complemento 3</label>
              <input
                id="line3"
                type="text"
                v-model="form.line3"
                placeholder="Observações adicionais"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.line3" class="mt-1 text-xs text-red-600">{{ form.errors.line3 }}</p>
            </div>

            <div>
              <label for="code" class="block text-gray-700 mb-1 text-sm font-medium">Código Postal</label>
              <input
                id="code"
                type="text"
                v-model="form.code"
                placeholder="XXXXX-XXX"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.code" class="mt-1 text-xs text-red-600">{{ form.errors.code }}</p>
            </div>

            <div>
              <label for="city" class="block text-gray-700 mb-1 text-sm font-medium">Concelho</label>
              <input
                id="city"
                type="text"
                v-model="form.city"
                placeholder="Ex.: Lisboa"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.city" class="mt-1 text-xs text-red-600">{{ form.errors.city }}</p>
            </div>

            <div>
              <label for="state" class="block text-gray-700 mb-1 text-sm font-medium">Distrito</label>
              <input
                id="state"
                type="text"
                v-model="form.state"
                placeholder="Ex.: Lisboa"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.state" class="mt-1 text-xs text-red-600">{{ form.errors.state }}</p>
            </div>

            <div>
              <label for="country" class="block text-gray-700 mb-1 text-sm font-medium">País</label>
              <input
                id="country"
                type="text"
                v-model="form.country"
                placeholder="Ex.: Portugal"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
              />
              <p v-if="form.errors.country" class="mt-1 text-xs text-red-600">{{ form.errors.country }}</p>
            </div>
          </div>
        </section>

        <div class="pt-4 border-t border-gray-300">
          <button
            type="submit"
            class="text-pink-600 hover:text-pink-800 font-semibold text-sm"
            :disabled="form.processing"
          >
            Criar Cliente
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
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { useToast } from 'vue-toastification'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const toast = useToast()
const activeTab = ref('cliente')

const form = useForm({
  name: '',
  email: '',
  url: '',
  address_type: '',
  address: '',
  contact: '',
  phone: '',
  line1: '',
  line2: '',
  line3: '',
  code: '',
  city: '',
  state: '',
  country: '',
  team_id: null,
  errors: {},
  processing: false,
  errorMessages: [],
})

const tabClass = (tab) =>
  activeTab.value === tab
    ? 'border-b-2 border-pink-600 text-pink-600'
    : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'

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
        form.errorMessages = Object.values(errors).flat()
        form.errors = errors
      }
    },
    onFinish: () => {
      form.processing = false
    },
  })
}
</script>
