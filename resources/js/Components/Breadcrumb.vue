<template>
  <nav class="text-gray-500 text-sm mb-2" aria-label="Breadcrumb">
    <ol class="inline-flex space-x-1">
      <li
        v-for="(item, index) in items"
        :key="index"
        class="flex items-center"
      >
        <template v-if="item.href">
          <Link :href="item.href" class="hover:text-gray-700">
            {{ item.label }}
          </Link>
        </template>
        <template v-else>
          <span class="text-pink-700">{{ item.label }}</span>
        </template>

        <!-- separador -->
        <span
          v-if="index < items.length - 1"
          class="mx-1"
        >/</span>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  items: {
    type: Array,
    required: true,
    default: () => [],
  },
})
</script>
