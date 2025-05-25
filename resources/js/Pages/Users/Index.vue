<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho com título e botão de criar usuário -->
    <div class="mb-6 flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-gray-700">Usuários</h1>
      <Link
        :href="route('users.create')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
      >
        Criar Usuário
      </Link>
    </div>

    <!-- Tabela de usuários -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th class="px-4 py-2 border-b text-left">ID</th>
            <th class="px-4 py-2 border-b text-left">Nome</th>
            <th class="px-4 py-2 border-b text-left">E-mail</th>
            <th class="px-4 py-2 border-b text-left">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users"
            :key="user.id"
            class="hover:bg-gray-100"
          >
            <td class="px-4 py-2 border-b">{{ user.id }}</td>
            <td class="px-4 py-2 border-b">{{ user.name }}</td>
            <td class="px-4 py-2 border-b">{{ user.email }}</td>
            <td class="px-4 py-2 border-b">
              <div class="flex space-x-2">
                <Link
                  :href="route('users.show', user.id)"
                  class="text-blue-500 hover:underline"
                >
                  Ver
                </Link>
                <Link
                  :href="route('users.edit', user.id)"
                  class="text-green-500 hover:underline"
                >
                  Editar
                </Link>
                <button
                  @click="deleteUser(user.id)"
                  class="text-red-500 hover:underline"
                >
                  Excluir
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="users.length === 0">
            <td colspan="4" class="text-center py-4">Nenhum usuário encontrado.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

// Extraímos a lista de usuários das props que a Inertia injeta na página.
const { users } = usePage().props.value

/**
 * Função para excluir um usuário.
 * Exibe uma confirmação e, se aceita, envia o request via Inertia para a rota 'users.destroy'.
 */
const deleteUser = (id) => {
  if (confirm('Você tem certeza que deseja excluir este usuário?')) {
    Inertia.delete(route('users.destroy', id))
  }
}
</script>
