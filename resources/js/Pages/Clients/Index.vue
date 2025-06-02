<template>
  <Head title="Lista de Clientes" />
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-4 bg-white rounded shadow-sm">

      <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Clientes</h1>
        <Link
          :href="route('clients.createClient')"
          class="text-pink-600 hover:text-pink-800 font-semibold text-sm"
        >
          + Criar Cliente
        </Link>
      </div>

      <!-- Filtros -->
      <div class="mb-4 overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
            <tr>
              <th class="p-2">
                <input
                  type="text"
                  v-model="filters.name"
                  @input="applyFilters"
                  placeholder="Filtrar Nome"
                  class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
                />
              </th>
              <th class="p-2">
                <input
                  type="text"
                  v-model="filters.email"
                  @input="applyFilters"
                  placeholder="Filtrar Email"
                  class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
                />
              </th>
              <th class="p-2">
                <input
                  type="text"
                  v-model="filters.phone"
                  @input="applyFilters"
                  placeholder="Filtrar Telefone"
                  class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
                />
              </th>
              <th class="p-2">
                <input
                  type="text"
                  v-model="filters.address"
                  @input="applyFilters"
                  placeholder="Filtrar Morada"
                  class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-600"
                />
              </th>
              <th class="p-2 text-center">
                <button
                  @click="resetFilters"
                  class="text-xs text-pink-600 hover:text-pink-800 font-semibold underline"
                  type="button"
                >
                  Limpar
                </button>
              </th>
            </tr>
          </thead>
        </table>
      </div>

      <!-- Tabela -->
      <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="p-3 border-b border-gray-200 font-medium text-gray-700">Nome</th>
              <th class="p-3 border-b border-gray-200 font-medium text-gray-700">Email</th>
              <th class="p-3 border-b border-gray-200 font-medium text-gray-700">Telefone</th>
              <th class="p-3 border-b border-gray-200 font-medium text-gray-700">Morada</th>
              <th class="p-3 border-b border-gray-200 font-medium text-gray-700 text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients.data" :key="client.id" class="hover:bg-gray-50">
              <td class="p-3 border-b border-gray-200">{{ client.name }}</td>
              <td class="p-3 border-b border-gray-200">{{ client.email }}</td>
              <td class="p-3 border-b border-gray-200">{{ client.phone ?? '-' }}</td>
              <td class="p-3 border-b border-gray-200 max-w-xs truncate" :title="client.address">
                {{ client.address ?? '-' }}
              </td>
              <td class="p-3 border-b border-gray-200 text-center space-x-2">
                <Link
                  :href="route('clients.show', client.id)"
                  class="text-blue-600 hover:text-blue-800 text-xs font-semibold"
                >
                  Ver
                </Link>
              </td>
            </tr>
            <tr v-if="clients.data.length === 0">
              <td colspan="5" class="p-3 text-center text-gray-500">Nenhum cliente encontrado.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Paginação -->
      <div class="mt-6 flex justify-center space-x-4 text-sm">
        <button
          :disabled="!clients.prev_page_url"
          @click="$inertia.visit(clients.prev_page_url, { preserveState: true })"
          class="px-3 py-1 rounded border border-gray-300 text-gray-600 disabled:opacity-50"
        >
          &laquo; Anterior
        </button>

        <span class="px-3 py-1 font-semibold border border-gray-300 rounded bg-gray-100">
          Página {{ clients.current_page }} de {{ clients.last_page }}
        </span>

        <button
          :disabled="!clients.next_page_url"
          @click="$inertia.visit(clients.next_page_url, { preserveState: true })"
          class="px-3 py-1 rounded border border-gray-300 text-gray-600 disabled:opacity-50"
        >
          Próximo &raquo;
        </button>
      </div>

    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import { reactive } from 'vue'
import { Link, Head, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { clients, filters } = usePage().props.value

const filtersReactive = reactive({
  name: filters?.name || '',
  email: filters?.email || '',
  phone: filters?.phone || '',
  address: filters?.address || '',
})

function applyFilters() {
  Inertia.get(route('clients.index'), filtersReactive, { preserveState: true, replace: true })
}

function resetFilters() {
  filtersReactive.name = ''
  filtersReactive.email = ''
  filtersReactive.phone = ''
  filtersReactive.address = ''
  Inertia.get(route('clients.index'), {}, { preserveState: true, replace: true })
}
</script>
