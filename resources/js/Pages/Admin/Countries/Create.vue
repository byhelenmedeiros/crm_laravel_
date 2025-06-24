<template>
  <DefaultLayout>
    <h1 class="text-2xl font-semibold mb-4">Novo País</h1>

    <form @submit.prevent="submit">
      <TextInput v-model="form.name" label="Nome" required />
      <NumberInput v-model="form.order" label="Ordem" />
      <ToggleSwitch v-model="form.active" label="Ativo" />

      <Button type="submit" class="mt-4">Salvar</Button>
    </form>
  </DefaultLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import TextInput from '@/Components/Form/TextInput.vue'
import NumberInput from '@/Components/Form/NumberInput.vue'
import ToggleSwitch from '@/Components/Form/ToggleSwitch.vue'
import Button from '@/Components/Form/Button.vue'

const form = useForm({
  name: '',
  order: 0,
  active: true,
})

function submit() {
  form.post(route('aux.countries.store'), {
    onSuccess: () => form.reset('name', 'order', 'active'),
  })
}
</script>
