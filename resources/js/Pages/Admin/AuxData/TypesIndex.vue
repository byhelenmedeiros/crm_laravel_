<template>
  <Head title="Tabelas Auxiliares" />
  <AuthenticatedLayout>
    <div class="mx-auto p-6 bg-white">
      <h1 class="text-2xl font-semibold mb-4">Tabelas Auxiliares</h1>
      <ul class="space-y-2">
        <li v-for="type in types" :key="type.key">
          <Link
            :href="route('admin.aux-data.index', type.key)"
            class="text-pink-600 hover:underline"
          >
            {{ type.label }}
          </Link>
        </li>
      </ul>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
const { types } = usePage().props

</script>