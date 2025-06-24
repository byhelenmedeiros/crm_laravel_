<!-- resources/js/Pages/Clients/AddressField.vue -->
<template>
  <details class="border rounded-lg mb-4">
    <summary
      class="px-4 py-2 bg-gray-100 hover:bg-gray-200 cursor-pointer flex justify-between items-center"
    >
      <span class="font-medium text-gray-700">
        Morada {{ addressIndex + 1 }} –
        {{ addressData.addressTypeName || addressData.address || "Sem tipo" }}
      </span>
      <button
        v-if="canRemove"
        type="button"
        @click.stop="$emit('remove')"
        class="text-red-500 hover:text-red-700 text-xs"
      >
        Remover
      </button>
    </summary>

    <div class="p-4 bg-white">
      <!-- Escolher morada principal -->
      <div class="mb-4">
        <label class="inline-flex items-center text-sm text-gray-700">
          <input
            type="radio"
            :value="addressIndex"
            v-model="primaryIndexLocal"
            class="form-radio text-pink-600"
          />
          <span class="ml-2">Definir como Morada Principal</span>
        </label>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- address_type_id -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">
            Tipo de Morada
          </label>
          <select
            v-model="local.address_type_id"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            required
          >
            <option value="" disabled>Selecione o tipo</option>
            <option v-for="type in addressTypes" :key="type.id" :value="type.id">
              {{ type.name }}
            </option>
          </select>
          <p
            v-if="errorFor(`addresses.${addressIndex}.address_type_id`)"
            class="mt-1 text-xs text-red-600"
          >
            {{ errorFor(`addresses.${addressIndex}.address_type_id`) }}
          </p>
        </div>

        <!-- name -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Nome</label>
          <input
            type="text"
            v-model="local.name"
            placeholder="Ex.: Escritório Fábrica"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
          <p
            v-if="errorFor(`addresses.${addressIndex}.name`)"
            class="mt-1 text-xs text-red-600"
          >
            {{ errorFor(`addresses.${addressIndex}.name`) }}
          </p>
        </div>

        <!-- address -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Morada</label>
          <input
            type="text"
            v-model="local.address"
            placeholder="Rua, Avenida, Nº..."
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
          <p
            v-if="errorFor(`addresses.${addressIndex}.address`)"
            class="mt-1 text-xs text-red-600"
          >
            {{ errorFor(`addresses.${addressIndex}.address`) }}
          </p>
        </div>
        <!-- Morada 2 -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Morada 2</label>
          <input
            type="text"
            v-model="local.line1"
            placeholder="Morada 2"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
        </div>

        <!-- Morada 3 -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Morada 3</label>
          <input
            type="text"
            v-model="local.line2"
            placeholder="Morada 3"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
        </div>

        <!-- Contacto -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Contacto</label>
          <input
            type="text"
            v-model="local.contact"
            placeholder="Pessoa de contacto"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
          <p
            v-if="errorFor(`addresses.${addressIndex}.contact`)"
            class="mt-1 text-xs text-red-600"
          >
            {{ errorFor(`addresses.${addressIndex}.contact`) }}
          </p>
        </div>

        <!-- Telefone -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Telefone</label>
          <input
            type="text"
            v-model="local.phone"
            placeholder="Telefone"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
          <p
            v-if="errorFor(`addresses.${addressIndex}.phone`)"
            class="mt-1 text-xs text-red-600"
          >
            {{ errorFor(`addresses.${addressIndex}.phone`) }}
          </p>
        </div>

        <!-- Código Postal -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
          <input
            type="text"
            v-model.trim="local.code"
            placeholder="1234-567"
            maxlength="8"
            :class="[
              'mt-1 block w-full border rounded-md shadow-sm sm:text-sm px-2 py-2',
              errorFor(`addresses.${addressIndex}.code`)
                ? 'border-red-500 focus:ring-red-500 focus:border-red-500'
                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
            ]"
          />
          <p
            v-if="errorFor(`addresses.${addressIndex}.code`)"
            class="text-red-600 text-sm mt-1"
          >
            {{ errorFor(`addresses.${addressIndex}.code`) }}
          </p>
        </div>

        <!-- Concelho -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Concelho</label>
          <input
            type="text"
            v-model="local.city"
            placeholder="Ex.: Lisboa"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
        </div>

        <!-- Distrito -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">Distrito</label>
          <input
            type="text"
            v-model="local.state"
            placeholder="Ex.: Lisboa"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
        </div>

        <!-- País -->
        <div>
          <label class="block text-gray-700 mb-1 text-sm font-medium">País</label>
          <input
            type="text"
            v-model="local.country"
            placeholder="Ex.: Portugal"
            class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
          />
        </div>
      </div>
    </div>
  </details>
</template>

<script setup>
import { computed, toRefs, reactive } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

// Props recebidos pelo componente pai
const props = defineProps({
  addressIndex: {
    type: Number,
    required: true,
  },
  addressData: {
    type: Object,
    required: true,
  },
  addressTypes: {
    type: Array,
    required: true,
  },
  primaryIndex: {
    type: Number,
    required: true,
  },
  formErrors: {
    type: Object,
    required: true,
  },
  canRemove: {
    type: Boolean,
    required: true,
  },
});

// Vamos criar uma cópia reativa de addressData para editar localmente
const local = reactive({ ...props.addressData });

// Para comunicar alterações ao pai, emitimos onUpdate sempre que local mudar
// Aqui usamos `watch` implícito: quando `local` muda, emitimos o novo objeto
import { watch, toRaw } from "vue";
watch(
  () => toRaw(local),
  (novo) => {
    // Envia o objeto atualizado para o pai
    emit("update:addressData", { ...novo });
  },
  { deep: true }
);

// Para controlar qual índice é o principal, vamos “espelhar” num valor local
const primaryIndexLocal = computed({
  get() {
    return props.primaryIndex;
  },
  set(val) {
    // Emite para o pai selecionar este endereço como principal
    emit("update:primaryIndex", val);
  },
});

// Função para ler erros aninhados de forma genérica
function errorFor(key) {
  return props.formErrors[key] || null;
}

// Expor `local` para o template
// (note que já está disponível pois usamos reactive)
</script>

<style scoped>
/* Você pode inserir aqui estilos específicos para o AddressField */
</style>
