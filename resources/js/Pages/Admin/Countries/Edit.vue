<template>
  <DefaultLayout>
    <h1 class="text-2xl font-semibold mb-4">Editar País</h1>

    <form @submit.prevent="submit">
      <TextInput v-model="form.name" label="Nome" required />
      <NumberInput v-model="form.order" label="Ordem" />
      <ToggleSwitch v-model="form.active" label="Ativo" />

      <div class="mt-4 flex space-x-2">
        <Button type="submit">Atualizar</Button>
        <Link :href="route('aux.countries.index')" class="btn btn-secondary">
          Cancelar
        </Link>
      </div>
    </form>
  </DefaultLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'
import TextInput from '@/Components/Form/TextInput.vue'
import NumberInput from '@/Components/Form/NumberInput.vue'
import ToggleSwitch from '@/Components/Form/ToggleSwitch.vue'
import Button from '@/Components/Form/Button.vue'

const { country } = usePage().props
const form = useForm({
  name: country.name,
  order: country.order,
  active: country.active,
})

function submit() {
  form.put(route('aux.countries.update', country.id))
}
</script>
