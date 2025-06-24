<template>
  <Head :title="type.label" />
  <AuthenticatedLayout>
    <div class="mx-auto p-6 bg-white">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ type.label }}</h1>
        <Link
          v-if="canManage"
          :href="route('admin.aux-data.create', type.key)"
          class="px-3 py-1 bg-pink-600 text-white rounded hover:bg-pink-700"
        >
          Novo {{ type.label.slice(0, -1) }}
        </Link>
      </div>

      <GenericTable
        :data="items"
        :columns="columns"
        :type="type"
        :can-manage="canManage"
        @delete="destroy"
      />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import GenericTable from '@/Components/GenericTable.vue'

// Destructure props enviados pelo controller
const { type, items, canManage } = usePage().props

// Colunas específicas para Países (sem parent)
const columns = [
  { key: 'name',   label: 'Nome'  },
  { key: 'order',  label: 'Ordem' },
  { key: 'active', label: 'Ativo' },
]

function destroy(id) {
  if (!confirm(`Excluir ${type.label.slice(0, -1)} #${id}?`)) return
  Inertia.delete(route('admin.aux-data.destroy', [type.key, id]))
}
</script>
