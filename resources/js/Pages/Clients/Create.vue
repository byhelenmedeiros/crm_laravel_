<template>
  <Head title="Criar Cliente" />
  <AuthenticatedLayout>
    <div class="mx-auto p-4 bg-white  ">
      <h1 class="text-xl font-semibold mb-4">Criar Novo Cliente</h1>
      <p class="mb-6 text-gray-700 text-sm">
        Preencha os dados abaixo para criar um novo cliente.
      </p>

      <!-- Tabs -->
      <nav class="flex border-b border-gray-300 mb-6">
        <button
          @click="activeTab = 'cliente'"
          :class="tabClass('cliente')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Dados do Cliente
        </button>
        <button
          @click="activeTab = 'morada'"
          :class="tabClass('morada')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Moradas
        </button>
        <button
          @click="activeTab = 'grupos'"
          :class="tabClass('grupos')"
          class="px-4 py-2 text-sm font-semibold"
          type="button"
        >
          Grupos de Clientes
        </button>
      </nav>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- === Seção: Dados do Cliente === -->
        <section v-if="activeTab === 'cliente'">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label
                for="name"
                class="block text-gray-700 mb-1 text-sm font-medium"
                >Nome do Cliente</label
              >
              <input
                id="name"
                type="text"
                v-model="form.name"
                placeholder="Nome completo"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
              <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">
                {{ form.errors.name }}
              </p>
            </div>
            <div>
              <label
                for="nif"
                class="block text-gray-700 mb-1 text-sm font-medium"
                >NIF</label
              >
              <input
                id="nif"
                type="text"
                v-model="form.nif"
                placeholder="Número de Identificação Fiscal"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
              <p v-if="form.errors.nif" class="mt-1 text-xs text-red-600">
                {{ form.errors.nif }}
              </p>
            </div>
            <div>
              <label
                for="url"
                class="block text-gray-700 mb-1 text-sm font-medium"
                >Website</label
              >
              <input
                id="url"
                type="url"
                v-model="form.url"
                placeholder="https://exemplo.com"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
              <p v-if="form.errors.url" class="mt-1 text-xs text-red-600">
                {{ form.errors.url }}
              </p>
            </div>
          </div>
        </section>

 <!-- === Seção: Moradas === -->
<section v-if="activeTab === 'morada'">
  <div class="flex justify-between items-center mb-2">
    <h2 class="text-lg font-medium text-gray-700">Moradas</h2>
    <button
      type="button"
      @click="addAddress"
      class="px-3 py-1 bg-pink-500 hover:bg-pink-600 text-white text-xs rounded"
    >
      + Adicionar Morada
    </button>
  </div>

  <div v-for="(addr, index) in form.addresses" :key="index" class="mb-4">
    <details class="border rounded-lg">
      <!-- O summary exibe o título resumido da morada -->
      <summary
        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 cursor-pointer flex justify-between items-center"
      >
        <span class="font-medium text-gray-700">
          Morada {{ index + 1 }} –
          {{ addr.addressType ? addr.addressType.name : (addr.address || "Sem tipo") }}
        </span>
        <button
          v-if="form.addresses.length > 1"
          type="button"
          @click.stop="removeAddress(index)"
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
              :value="index"
              v-model="form.primaryIndex"
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
              v-model="addr.address_type_id"
              required
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            >
              <option value="" disabled>Selecione o tipo</option>
              <option
                v-for="type in addressTypes"
                :key="type.id"
                :value="type.id"
              >
                {{ type.name }}
              </option>
            </select>
            <p
              v-if="formErrors[`addresses.${index}.address_type_id`]"
              class="mt-1 text-xs text-red-600"
            >
              {{ formErrors[`addresses.${index}.address_type_id`] }}
            </p>
          </div>

          <!-- name -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Nome
            </label>
            <input
              type="text"
              v-model="addr.name"
              placeholder="Ex.: Escritório Fábrica"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
            <p
              v-if="formErrors[`addresses.${index}.name`]"
              class="mt-1 text-xs text-red-600"
            >
              {{ formErrors[`addresses.${index}.name`] }}
            </p>
          </div>

          <!-- address -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Endereço Completo
            </label>
            <input
              type="text"
              v-model="addr.address"
              placeholder="Rua, Avenida, Nº..."
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
            <p
              v-if="formErrors[`addresses.${index}.address`]"
              class="mt-1 text-xs text-red-600"
            >
              {{ formErrors[`addresses.${index}.address`] }}
            </p>
          </div>

          <!-- contact -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Contacto
            </label>
            <input
              type="text"
              v-model="addr.contact"
              placeholder="Pessoa de contacto"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
            <p
              v-if="formErrors[`addresses.${index}.contact`]"
              class="mt-1 text-xs text-red-600"
            >
              {{ formErrors[`addresses.${index}.contact`] }}
            </p>
          </div>

          <!-- phone -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Telefone
            </label>
            <input
              type="text"
              v-model="addr.phone"
              placeholder="(XX) XXXX-XXXX"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
            <p
              v-if="formErrors[`addresses.${index}.phone`]"
              class="mt-1 text-xs text-red-600"
            >
              {{ formErrors[`addresses.${index}.phone`] }}
            </p>
          </div>

          <!-- line1 -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Complemento 1
            </label>
            <input
              type="text"
              v-model="addr.line1"
              placeholder="Ex.: Bairro, Apartamento"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- line2 -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Complemento 2
            </label>
            <input
              type="text"
              v-model="addr.line2"
              placeholder="Ex.: Referência, Entrada"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- line3 -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Complemento 3
            </label>
            <input
              type="text"
              v-model="addr.line3"
              placeholder="Observações adicionais"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- code -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Código Postal
            </label>
            <input
              type="text"
              v-model="addr.code"
              placeholder="XXXXX-XXX"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- city -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Concelho
            </label>
            <input
              type="text"
              v-model="addr.city"
              placeholder="Ex.: Lisboa"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- state -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              Distrito
            </label>
            <input
              type="text"
              v-model="addr.state"
              placeholder="Ex.: Lisboa"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>

          <!-- country -->
          <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">
              País
            </label>
            <input
              type="text"
              v-model="addr.country"
              placeholder="Ex.: Portugal"
              class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            />
          </div>
        </div>
      </div>
    </details>
  </div>
</section>


        <!-- === Seção: Grupos de Clientes === -->
        <section v-if="activeTab === 'grupos'">
          <p class="text-gray-700 text-sm">
            Selecione um grupo de clientes para associar a este cliente.
          </p>
          <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label
                for="client_group_id"
                class="block text-gray-700 mb-1 text-sm font-medium"
                >Grupo do Cliente</label
              >
              <select
                id="client_group_id"
                v-model="form.client_group_id"
                @change="onGroupChange"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              >
                <option value="" disabled>Selecionar grupo</option>
                <option
                  v-for="group in clientGroups"
                  :key="group.id"
                  :value="group.id"
                >
                  {{ group.name }}
                </option>
              </select>
              <p v-if="form.errors.client_group_id" class="mt-1 text-xs text-red-600">
                {{ form.errors.client_group_id }}
              </p>
            </div>

            <div v-if="subdivisions.length">
              <label
                for="group_subdivision_id"
                class="block text-gray-700 mb-1 text-sm font-medium"
                >Subgrupo / Subdivisão</label
              >
              <select
                id="group_subdivision_id"
                v-model="form.group_subdivision_id"
                class="w-full border border-gray-300 rounded px-2 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              >
                <option value="" disabled>Selecionar subgrupo</option>
                <option
                  v-for="sub in subdivisions"
                  :key="sub.id"
                  :value="sub.id"
                >
                  {{ sub.name }}
                </option>
              </select>
              <p v-if="form.errors.group_subdivision_id" class="mt-1 text-xs text-red-600">
                {{ form.errors.group_subdivision_id }}
              </p>
            </div>
            <div v-else class="invisible">&nbsp;</div>
          </div>
        </section>

        <!-- === Botão para Salvar === -->
        <div class="pt-4">
          <button
            type="submit"
            :disabled="form.processing"
            class="inline-flex items-center px-3 py-1 bg-pink-600 border border-transparent rounded-md font-semibold text-white hover:bg-pink-500 active:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-700"
          >
            Salvar Cliente
          </button>
        </div>
      </form>

      <div
        v-if="form.errorMessages.length"
        class="mt-6 bg-red-50 border border-red-400 p-4 rounded text-sm text-red-700"
      >
        <h3 class="font-semibold mb-2">Erros do formulário:</h3>
        <ul class="list-disc pl-5 space-y-1">
          <li v-for="(msg, idx) in form.errorMessages" :key="idx">
            {{ msg }}
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const props = defineProps({
  addressTypes: Array,
  clientGroups: Array,
  subdivisions: Array,
  selectedGroup: [String, Number, null],
  selectedSub: [String, Number, null],
});

const toast = useToast();
const activeTab = ref("cliente");

// Classe para estilizar abas
const tabClass = (tab) =>
  activeTab.value === tab
    ? "border-b-2 border-pink-600 text-pink-600"
    : "border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300";

// Estado reativo do formulário Inertia
const form = useForm({
  name: "",
  nif: "",
  url: "",
  client_group_id: props.selectedGroup || null,
  group_subdivision_id: props.selectedSub || null,

  // Array inicial com uma morada
  addresses: [
    {
      address_type_id: null,
      name: "",
      address: "",
      contact: "",
      phone: "",
      line1: "",
      line2: "",
      line3: "",
      code: "",
      city: "",
      state: "",
      country: "",
    },
  ],

  // Qual índice do array de addresses é a morada principal
  primaryIndex: 0,

  processing: false,
  errors: {},
  errorMessages: [],
});

// State reativo para subdivisões conforme grupo
const subdivisions = ref(props.subdivisions || []);

// Adiciona uma nova morada em branco ao array
function addAddress() {
  form.addresses.push({
    address_type_id: null,
    name: "",
    address: "",
    contact: "",
    phone: "",
    line1: "",
    line2: "",
    line3: "",
    code: "",
    city: "",
    state: "",
    country: "",
  });
}

// Remove morada em dado índice e ajusta primaryIndex se necessário
function removeAddress(idx) {
  form.addresses.splice(idx, 1);
  if (form.primaryIndex === idx) {
    form.primaryIndex = 0;
  } else if (form.primaryIndex > idx) {
    form.primaryIndex--;
  }
}

// Quando seleciona outro grupo, carrega subdivisões via fetch
const onGroupChange = async () => {
  if (!form.client_group_id) {
    subdivisions.value = [];
    form.group_subdivision_id = null;
    return;
  }
  try {
    const response = await fetch(
      `/subdivisoes-por-grupo/${form.client_group_id}`
    );
    if (!response.ok) throw new Error("Falha ao carregar subdivisões");
    const data = await response.json();
    subdivisions.value = data;
    form.group_subdivision_id = null;
  } catch (e) {
    console.error("Erro ao buscar subdivisões:", e);
    subdivisions.value = [];
    form.group_subdivision_id = null;
  }
};

// Submit: transforma addresses adicionando campo `primary`
function submit() {
  form.errorMessages = [];
  form.processing = true;

  // Antes de enviar, montar payload de endereços com primary = 1 ou 0
  const transformed = {
    ...form,
    addresses: form.addresses.map((addr, i) => ({
      ...addr,
      primary: i === form.primaryIndex ? 1 : 0,
    })),
  };

  form.post(route("clients.store"), {
    preserveScroll: true,
    data: transformed,
    onSuccess: () => {
      toast.success("Cliente criado com sucesso!");
      form.reset();
      form.errorMessages = [];
    },
    onError: (errors) => {
      toast.error("Erro ao criar cliente. Verifique os dados.");
      if (errors) {
        form.errorMessages = Object.values(errors).flat();
        form.errors = errors;
      }
    },
    onFinish: () => {
      form.processing = false;
    },
  });
}

// Helper para ler erros aninhados em addresses
const formErrors = reactive({});
watch(
  () => form.errors,
  (errs) => {
    Object.keys(errs || {}).forEach((key) => {
      formErrors[key] = errs[key];
    });
  },
  { deep: true, immediate: true }
);

// Utility para formatar datas (caso use no futuro dentro dos campos)
function formattedDate(dateString) {
  if (!dateString) return "—";
  return new Date(dateString).toLocaleString("pt-PT", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}
</script>
