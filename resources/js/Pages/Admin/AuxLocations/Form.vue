<template>
  <Head :title="location ? `Editar ${label}` : `Novo ${label}`" />
  <AuthenticatedLayout>
    <div class="mx-auto p-6 bg-white max-w-lg">
      <h1 class="text-2xl font-semibold mb-4">
        {{ location ? 'Editar' : 'Criar Novo' }} {{ label }}
      </h1>

      <form @submit.prevent="submit" class="space-y-6">
        <FieldText
          id="name" label="Nome"
          v-model="form.name"
          :error="form.errors.name"
        />

        <div v-if="type !== 'country'">
          <FieldSelect
            id="parent_id" label="Selecione o {{ type === 'district' ? 'País' : 'Distrito' }}"
            v-model="form.parent_id"
            :options="parentList"
            option-value="id"
            option-label="name"
            :error="form.errors.parent_id"
          />
        </div>

        <FieldText
          id="order" label="Ordem"
          v-model="form.order"
          type="number"
          :error="form.errors.order"
        />

        <FieldToggle
          id="active" label="Ativo"
          v-model="form.active"
          :error="form.errors.active"
        />

        <div class="flex space-x-4">
          <button type="submit" :disabled="form.processing"
                  class="px-4 py-2 bg-pink-600 text-white rounded">
            {{ location ? 'Atualizar' : 'Criar' }}
          </button>
          <inertia-link
            :href="route('admin.aux-locations.index')"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded"
          >Cancelar</inertia-link>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import Head from '@inertiajs/inertia-vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import FieldText from '@/Pages/Clients/Components/FieldText.vue'
import FieldSelect from '@/Components/FieldSelect.vue'
import FieldToggle from '@/Components/FieldToggle.vue'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  location:   Object,
  type:       String,
  parentList: Array,
})

const label = type === 'country'
  ? 'País'
  : type === 'district'
    ? 'Distrito'
    : 'Concelho'

const form = useForm({
  name:      props.location?.name   || '',
  parent_id: props.location?.parent_id || null,
  order:     props.location?.order  || 0,
  active:    props.location?.active ?? true,
})

function submit() {
  if (props.location) {
    form.put(route('admin.aux-locations.update', props.location.id))
  } else {
    form.post(route('admin.aux-locations.store', props.type))
  }
}
</script>
