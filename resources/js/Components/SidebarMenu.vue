<template>
  <nav>
    <ul>
      <li v-for="(item, index) in menuItems" :key="index" class="flex flex-col">
        <!-- Item principal: se for "Utilizadores", ele dispara o toggle do dropdown -->
        <div
          @click="item.label === 'Utilizadores' ? toggleUsersMenu() : null"
          class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer"
        >
          <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
          <span v-if="sidebarOpen" class="ml-3 text-sm text-gray-700">
            {{ item.label }}
          </span>
          <!-- Exibe o ícone de chevron apenas para "Utilizadores" quando a sidebar estiver expandida -->
          <template v-if="sidebarOpen && item.label === 'Utilizadores'">
            <FontAwesomeIcon
              :icon="usersMenuOpen ? faChevronDown : faChevronRight"
              class="ml-auto w-4 h-4"
            />
          </template>
        </div>

        <!-- Submenu do item "Utilizadores" -->
        <ul
          v-if="item.label === 'Utilizadores' && usersMenuOpen && sidebarOpen"
          class="ml-8"
        >
          <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
            <span class="text-sm text-gray-700">Listar Utilizadores</span>
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
            <span class="text-sm text-gray-700">Criar Administrador</span>
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
            <span class="text-sm text-gray-700">Admins de Setor</span>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps, ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faTachometerAlt,
  faUser,
  faCog,
  faChevronRight,
  faChevronDown,
} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
  sidebarOpen: {
    type: Boolean,
    default: true,
  },
});

const menuItems = ref([
  { label: "Dashboard", url: "#", icon: faTachometerAlt },
  { label: "Perfil", url: "#", icon: faUser },
  { label: "Configurações", url: "#", icon: faCog },
  { label: "Utilizadores", url: "#", icon: faUser },
]);

// Estado para controlar a abertura do submenu de "Utilizadores"
const usersMenuOpen = ref(false);
const toggleUsersMenu = () => {
  usersMenuOpen.value = !usersMenuOpen.value;
};
</script>
