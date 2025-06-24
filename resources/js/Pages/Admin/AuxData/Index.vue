<template>
  <LayoutAdmin>
    <h1>Tabela Auxiliar</h1>

    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 border">ID</th>
          <th class="p-2 border">Nome do Campo</th>
          <th v-if="canManage" class="p-2 border">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="r in records" :key="r.id" class="hover:bg-gray-50">
          <td class="p-2 border">{{ r.id }}</td>
          <td class="p-2 border">{{ r.name }}</td>
          <td v-if="canManage" class="p-2 border space-x-2">
            <InertiaLink
              :href="route('admin.aux-data.edit', r.id)"
              class="text-blue-600 hover:underline"
            >Editar</InertiaLink>
            <button
              @click="del(r.id)"
              class="text-red-600 hover:underline"
            >Excluir</button>
          </td>
        </tr>
        <tr v-if="records.length === 0">
          <td
            :colspan="canManage ? 3 : 2"
            class="p-4 text-center text-gray-500"
          >
            Nenhum registro encontrado.
          </td>
        </tr>
      </tbody>
    </table>

    <button
      v-if="canManage"
      @click="create"
      class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
    >
      + Novo Registro
    </button>
  </LayoutAdmin>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { Link as InertiaLink } from '@inertiajs/inertia-vue3'

const props = defineProps({
  records:   Array,
  canManage: Boolean,
})

function create() {
  Inertia.get(route('admin.aux-data.create'))
}

function del(id) {
  if (confirm('Confirma exclusão?')) {
    Inertia.delete(route('admin.aux-data.destroy', id))
  }
}
</script>
