<template>
  <nav>
    <ul>
      <li v-for="(item, index) in menuItems" :key="index" class="flex flex-col">
        <!-- Item principal -->
        <div
          @click="item.label === 'Utilizadores' && isSuperadmin ? toggleSubmenu() : null"
          class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer"
        >
          <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
          <span v-if="sidebarOpen" class="ml-3 text-sm text-gray-700">
            {{ item.label }}
          </span>
          <!-- Ícone de chevron para indicar dropdown (somente para "Utilizadores" se for superadmin e a sidebar estiver expandida) -->
          <template v-if="sidebarOpen && item.label === 'Utilizadores' && isSuperadmin">
            <FontAwesomeIcon
              :icon="submenuOpen ? faChevronDown : faChevronRight"
              class="ml-auto w-4 h-4"
            />
          </template>
        </div>

        <!-- Submenu: 
             Exibido apenas para o item "Utilizadores" se o usuário for superadmin,
             e somente quando o submenu estiver aberto e a sidebar estiver expandida -->
        <ul v-if="item.label === 'Utilizadores' && isSuperadmin" v-show="submenuOpen && sidebarOpen" class="ml-8">
  <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
    <Link :href="route('users.index')" class="flex items-center w-full">
      <FontAwesomeIcon :icon="faList" class="w-5 h-5" />
      <span class="ml-3 text-sm text-gray-700">
        Listar Utilizadores
      </span>
    </Link>
  </li>
 <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
    <Link :href="route('users.teamadmin.create')" class="flex items-center w-full">
      <FontAwesomeIcon :icon="faPlus" class="w-5 h-5" />
      <span class="ml-3 text-sm text-gray-700">
        Criar Administrador
      </span>
    </Link>
</li>

  <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
    <Link :href="route('users.teamadmin.index')" class="flex items-center w-full">
      <FontAwesomeIcon :icon="faUserShield" class="w-5 h-5" />
      <span class="ml-3 text-sm text-gray-700">
        Admins de Setor
      </span>
    </Link>
  </li>
</ul>   
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps, ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faTachometerAlt,
  faUser,
  faCog,
  faList,
  faPlus,
  faUserShield,
  faChevronRight,
  faChevronDown,
} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
  sidebarOpen: {
    type: Boolean,
    default: true,
  },
});

// Obtemos os dados da página (incluindo o usuário autenticado)
const { props: pageProps } = usePage();

// Computed para verificar se o usuário é superadmin
const isSuperadmin = computed(() => {
  // Ajuste a propriedade conforme como você armazena a role. Aqui, assume-se que:
  // pageProps.value.auth.user.role é uma string, por exemplo, "superadmin"
  return pageProps.value.auth.user.role === "superadmin";
});

// Itens de menu
const menuItems = ref([
  { label: "Dashboard", url: "#", icon: faTachometerAlt },
  { label: "Perfil", url: "#", icon: faUser },
  { label: "Configurações", url: "#", icon: faCog },
  { label: "Utilizadores", url: "#", icon: faUser },
]);

// Estado para controlar a abertura do submenu de "Utilizadores"
const submenuOpen = ref(false);
const toggleSubmenu = () => {
  submenuOpen.value = !submenuOpen.value;
};
</script>
