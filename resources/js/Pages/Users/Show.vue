<template>
  <div>
    <h1 class="text-2xl font-bold">{{ client.name }}</h1>

    <h2 class="mt-4 font-semibold">Moradas do Cliente:</h2>
    <ul class="mt-2 list-disc pl-5">
      <li v-for="addr in client.addresses" :key="addr.id" class="mb-2">
        <strong v-if="addr.primary === 1">(Principal)</strong>
        {{ addr.address }}, {{ addr.city }} – {{ addr.state }}, {{ addr.country }}
        <br />
        <small class="text-sm text-gray-600">
          Tipo: {{ addr.address_type_id }} • Contato: {{ addr.contact || '—' }} • Tel: {{ addr.phone || '—' }}
        </small>
      </li>
    </ul>
  </div>
</template>

<script setup>
const props = defineProps({
  client: Object,
});
</script>
