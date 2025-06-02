<script setup>
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faChevronRight, faChevronDown, faList, faPlus, faUserShield } from '@fortawesome/free-solid-svg-icons';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
  item: Object,
  isSuperadmin: Boolean,
  isAdmin: Boolean,
  sidebarOpen: Boolean,
  user: Object 
});

const submenuOpen = ref(false);

function toggleSubmenu() {
  submenuOpen.value = !submenuOpen.value;
}
</script>

<template>
  <div class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
    <Link :href="item.url" class="flex-1 flex items-center">
      <FontAwesomeIcon :icon="item.icon" class="w-4 h-4" />
      <span v-if="sidebarOpen" class="ml-2 text-sm">{{ item.label }}</span>
    </Link>
    <button
      v-if="sidebarOpen"
      @click.stop="toggleSubmenu"
      class="ml-auto"
      aria-label="Toggle submenu"
    >
      <FontAwesomeIcon
        :icon="submenuOpen ? faChevronDown : faChevronRight"
        class="w-4 h-4"
      />
    </button>
  </div>

  <ul v-if="submenuOpen && sidebarOpen" class="ml-8">
    <!-- Submenu de Utilizadores -->
    <template v-if="item.label === 'Utilizadores'">
      <li v-if="isAdmin || isSuperadmin" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
        <Link :href="route('users.index')" class="flex items-center w-full">
          <FontAwesomeIcon :icon="faList" class="w-4 h-4" />
          <span class="ml-3 text-sm">Listar Utilizadores</span>
        </Link>
      </li>

      <li v-if="isAdmin" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
        <Link :href="route('users.create')" class="flex items-center w-full">
          <FontAwesomeIcon :icon="faPlus" class="w-4 h-4" />
          <span class="ml-3 text-sm">Criar Utilizador</span>
        </Link>
      </li>

      <template v-if="isSuperadmin">
        <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
          <Link :href="route('teams.teamadmin.create')" class="flex items-center w-full">
            <FontAwesomeIcon :icon="faPlus" class="w-4 h-4" />
            <span class="ml-3 text-sm">Criar Administrador</span>
          </Link>
        </li>
        <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
          <Link :href="route('teams.teamadmin.index')" class="flex items-center w-full">
            <FontAwesomeIcon :icon="faUserShield" class="w-4 h-4" />
            <span class="ml-3 text-sm">Admins de Setor</span>
          </Link>
        </li>
      </template>
    </template>

 <template v-if="item.label === 'Clientes'">
  <!-- Link para listar os clientes -->
  <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
    <Link :href="route('clients.index')" class="flex items-center w-full">
      <FontAwesomeIcon :icon="faList" class="w-4 h-4" />
      <span class="ml-3 text-sm">Listar Clientes</span>
    </Link>
  </li>

  <!-- Link para criar um cliente, disponível para admins ou superadmins -->
  <li v-if="isAdmin || isSuperadmin" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
   <Link :href="route('clients.create')" class="...">
  <FontAwesomeIcon :icon="faPlus" class="w-4 h-4" />
  <span class="ml-3 text-sm">Criar Cliente</span>
</Link>

  </li>


</template>

  </ul>
</template>
