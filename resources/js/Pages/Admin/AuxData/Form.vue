<template>
  <Head :title="form.id ? `Editar ${type.label}` : `Novo ${type.label}`" />

  <AuthenticatedLayout>
    <div class="mx-auto p-6 bg-white">
      <h1 class="text-2xl font-semibold mb-6">
        {{ form.id ? 'Editar' : 'Novo' }} {{ type.label }}
      </h1>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Se houver parents, renderiza o select -->
        <div v-if="parents.length">
          <label class="block text-sm font-medium mb-1">
            {{ typeKeyParentLabel }}
          </label>
          <select
            v-model="form.parent_id"
            class="block w-full border-gray-300 rounded-md shadow-sm"
            required
          >
            <option value="" disabled>Selecione {{ typeKeyParentLabel.toLowerCase() }}</option>
            <option
              v-for="opt in parents"
              :key="opt.id"
              :value="opt.id"
            >
              {{ opt.name }}
            </option>
          </select>
          <p v-if="form.errors.parent_id" class="text-red-500 text-sm">
            {{ form.errors.parent_id }}
          </p>
        </div>

        <!-- Campos comuns -->
        <div>
          <label class="block text-sm font-medium mb-1">Nome</label>
          <input
            v-model="form.name"
            type="text"
            class="block w-full border-gray-300 rounded-md shadow-sm"
            required
          />
          <p v-if="form.errors.name" class="text-red-500 text-sm">
            {{ form.errors.name }}
          </p>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Ordem</label>
          <input
            v-model="form.order"
            type="number"
            class="block w-full border-gray-300 rounded-md shadow-sm"
          />
        </div>

        <div class="flex items-center">
          <input
            v-model="form.active"
            type="checkbox"
            id="active"
            class="h-4 w-4 text-pink-600 border-gray-300 rounded"
          />
          <label for="active" class="ml-2 text-sm">Ativo</label>
        </div>

        <!-- Ações -->
        <div class="pt-6 flex space-x-2">
          <button
            type="submit"
            class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700"
          >
            {{ form.id ? 'Atualizar' : 'Salvar' }}
          </button>
          <Link
            :href="route('admin.aux-data.index', type.key)"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
          >
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'

const { type, item, parents } = usePage().props

// Formulário inicializado com Inertia
const form = useForm({
  id:        item.id || null,
  aux_type_id: type.id,
  parent_id: item.parent_id || '',
  name:      item.name || '',
  order:     item.order || 0,
  active:    item.active ?? true,
})

// Label dinâmico para o select de parent
const typeKeyParentLabel = type.key === 'districts'
  ? 'País'
  : type.key === 'municipalities'
    ? 'Distrito'
    : ''

function submit() {
  if (form.id) {
    form.put(route('admin.aux-data.update', [type.key, form.id]))
  } else {
    form.post(route('admin.aux-data.store', type.key))
  }
}
</script>
