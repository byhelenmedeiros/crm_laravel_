<template>
  <Head title="Detalhes do Cliente" />
  <AuthenticatedLayout>
    <div class="mx-auto my-4 px-2 space-y-6">
      <!-- Breadcrumb -->
      <nav class="text-gray-500 text-sm mb-2" aria-label="Breadcrumb">
        <ol class="inline-flex space-x-1">
          <li>
            <Link href="/" class="hover:text-gray-700">Dashboard</Link>
            <span class="mx-1">/</span>
          </li>
          <li>
            <Link :href="route('clients.index')" class="hover:text-gray-700">Clientes</Link>
            <span class="mx-1">/</span>
          </li>
          <li class="text-pink-700">Detalhes</li>
        </ol>
      </nav>

      <!-- Cabeçalho + Botões -->
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">
          Cliente: {{ $page.props.client.name }}
        </h1>
        <div class="space-x-2">
          <Link
            :href="route('clients.edit', $page.props.client.id)"
            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded"
          >
            Editar
          </Link>
          <Link
            :href="route('clients.index')"
            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded"
          >
            Voltar
          </Link>
        </div>
      </div>

      <!-- === Abas (Tabs) === -->
      <nav class="flex border-b border-gray-300">
        <button
          @click="activeTab = 'info'"
          :class="tabClass('info')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Informações Gerais
        </button>
        <button
          @click="activeTab = 'moradas'"
          :class="tabClass('moradas')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Moradas
        </button>
        <button
          @click="activeTab = 'outras'"
          :class="tabClass('outras')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Outras Moradas
        </button>
      </nav>

      <!-- === Seção 1: Informações Gerais === -->
      <section v-if="activeTab === 'info'">
        <div class="bg-white rounded-lg">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
              <span class="block text-xs text-gray-500">Nome</span>
              <span class="block text-gray-800">{{ $page.props.client.name }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">NIF</span>
              <span class="block text-gray-800">{{ $page.props.client.nif ?? '—' }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">URL</span>
              <span class="block text-gray-800">{{ $page.props.client.url ?? '—' }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">Grupo de Cliente</span>
              <span class="block text-gray-800">{{ $page.props.client.clientGroup?.name ?? '—' }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">Subdivisão de Grupo</span>
              <span class="block text-gray-800">{{ $page.props.client.groupSubdivision?.name ?? '—' }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">Criado em</span>
              <span class="block text-gray-800">{{ formattedDate($page.props.client.created_at) }}</span>
            </div>
            <div>
              <span class="block text-xs text-gray-500">Atualizado em</span>
              <span class="block text-gray-800">{{ formattedDate($page.props.client.updated_at) }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- === Seção 2: Moradas === -->
      <section v-if="activeTab === 'moradas'">
        <div
          v-if="$page.props.client.addresses && $page.props.client.addresses.length"
          class="space-y-6"
        >
          <!-- Para cada Morada, crie um card com grid de campos -->
          <div
            v-for="addr in $page.props.client.addresses"
            :key="addr.id"
            class="bg-white rounded-lg"
          >
            <h3 class="text-md font-semibold text-gray-600 mb-4">
              Morada #{{ addr.id }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <!-- external_id -->
              <div>
                <span class="block text-xs text-gray-500">External ID</span>
                <span class="block text-gray-800">{{ addr.external_id ?? '—' }}</span>
              </div>
              <!-- address_type_id (mostra o nome, se disponível) -->
              <div>
                <span class="block text-xs text-gray-500">Tipo (address_type_id)</span>
                <span class="block text-gray-800">
                  {{ addr.addressType?.name ?? addr.address_type_id ?? '—' }}
                </span>
              </div>
              <!-- name -->
              <div>
                <span class="block text-xs text-gray-500">Nome</span>
                <span class="block text-gray-800">{{ addr.name ?? '—' }}</span>
              </div>
              <!-- address -->
              <div>
                <span class="block text-xs text-gray-500">Morada Completo</span>
                <span
                  class="block text-gray-800 max-w-xs truncate"
                  :title="addr.address"
                >
                  {{ addr.address ?? '—' }}
                </span>
              </div>
              <!-- contact -->
              <div>
                <span class="block text-xs text-gray-500">Contact</span>
                <span class="block text-gray-800">{{ addr.contact ?? '—' }}</span>
              </div>
              <!-- phone -->
              <div>
                <span class="block text-xs text-gray-500">Telefone</span>
                <span class="block text-gray-800">{{ addr.phone ?? '—' }}</span>
              </div>
              <!-- line1 -->
              <div>
                <span class="block text-xs text-gray-500">Complemento 1</span>
                <span class="block text-gray-800">{{ addr.line1 ?? '—' }}</span>
              </div>
              <!-- line2 -->
              <div>
                <span class="block text-xs text-gray-500">Complemento 2</span>
                <span class="block text-gray-800">{{ addr.line2 ?? '—' }}</span>
              </div>
              <!-- line3 -->
              <div>
                <span class="block text-xs text-gray-500">Complemento 3</span>
                <span class="block text-gray-800">{{ addr.line3 ?? '—' }}</span>
              </div>
              <!-- code -->
              <div>
                <span class="block text-xs text-gray-500">Código Postal</span>
                <span class="block text-gray-800">{{ addr.code ?? '—' }}</span>
              </div>
              <!-- city -->
              <div>
                <span class="block text-xs text-gray-500">Cidade</span>
                <span class="block text-gray-800">{{ addr.city ?? '—' }}</span>
              </div>
              <!-- state -->
              <div>
                <span class="block text-xs text-gray-500">Estado</span>
                <span class="block text-gray-800">{{ addr.state ?? '—' }}</span>
              </div>
              <!-- country -->
              <div>
                <span class="block text-xs text-gray-500">País</span>
                <span class="block text-gray-800">{{ addr.country ?? '—' }}</span>
              </div>
              <!-- addressable_type -->
              <div>
                <span class="block text-xs text-gray-500">Addressable Type</span>
                <span class="block text-gray-800">{{ addr.addressable_type ?? '—' }}</span>
              </div>
              <!-- user_created_id -->
              <div>
                <span class="block text-xs text-gray-500">User Created ID</span>
                <span class="block text-gray-800">{{ addr.user_created_id ?? '—' }}</span>
              </div>
              <!-- created_at -->
              <div>
                <span class="block text-xs text-gray-500">Criado em</span>
                <span class="block text-gray-800">{{ formattedDate(addr.created_at) }}</span>
              </div>
              <!-- updated_at -->
              <div>
                <span class="block text-xs text-gray-500">Atualizado em</span>
                <span class="block text-gray-800">{{ formattedDate(addr.updated_at) }}</span>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="text-gray-500">
          Nenhuma morada cadastrada para este cliente.
        </div>
      </section>

      <!-- === Seção 3: Outras Moradas (ainda vazia, só a aba aparece) === -->
      <section v-if="activeTab === 'outras'">
        <div class="bg-white rounded-lg">
          <p class="text-gray-600">
          Incluir outras moradas
          </p>
        </div>
      </section>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Controle da aba ativa; começa em 'info'
const activeTab = ref('info')

// Classe para estilizar a aba ativa
const tabClass = (tab) =>
  activeTab.value === tab
    ? 'border-b-2 border-pink-600 text-pink-600'
    : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'

// Função para formatar datas
function formattedDate(dateString) {
  if (!dateString) return '—'
  return new Date(dateString).toLocaleString('pt-PT', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
</script>
