<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { useAuthStore } from '@/stores/authStore';
import { usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faTachometerAlt,
  faUser,
  faCog,
  faList,
  faPlus,
  faUserShield,
  faChevronRight,
  faChevronDown
} from '@fortawesome/free-solid-svg-icons';

const props = defineProps({
  sidebarOpen: { type: Boolean, default: true }
});

const authStore = useAuthStore();
const page = usePage();

watch(
  () => page.props.auth?.user,
  (newUser) => {
    if (newUser) {
      authStore.setUser(newUser);
      console.log('[SidebarMenu] authStore atualizado com:', newUser);
    }
  },
  { immediate: true }
);

const menuItems = ref([
  { label: 'Dashboard', url: route('dashboard'), icon: faTachometerAlt },
  { label: 'Perfil', url: route('profile.edit'), icon: faUser },
  { label: 'Configurações', url: '#', icon: faCog },
  { label: 'Utilizadores', url: route('users.index'), icon: faUser }
]);

const submenuOpen = ref(false);
const toggleSubmenu = () => {
  submenuOpen.value = !submenuOpen.value;
  console.log("SidebarMenu - submenuOpen:", submenuOpen.value);
};
</script>
<template>
  <div v-if="authStore.user">
    <p class="text-xs text-red-500 mb-2">Role ID: {{ authStore.user.role_id }}</p>
    <p class="text-xs text-blue-500 mb-2">isSuperadmin: {{ authStore.isSuperadmin }}</p>

    <nav>
      <ul>
        <li v-for="(item, index) in menuItems" :key="index" class="flex flex-col">
          <template v-if="item.label !== 'Utilizadores'">
            <Link :href="item.url" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
              <span v-if="sidebarOpen" class="ml-3 text-sm">{{ item.label }}</span>
            </Link>
          </template>
          <template v-else>
            <div class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <Link :href="item.url" class="flex-1 flex items-center">
                <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
                <span v-if="sidebarOpen" class="ml-3 text-sm">{{ item.label }}</span>
              </Link>
              <button
                v-if="authStore.isSuperadmin && sidebarOpen"
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

            <ul
              v-if="authStore.isSuperadmin"
              v-show="submenuOpen && sidebarOpen"
              class="ml-8"
            >
              <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
                <Link @click.stop :href="route('users.index')" class="flex items-center w-full">
                  <FontAwesomeIcon :icon="faList" class="w-5 h-5" />
                  <span class="ml-3 text-sm">Listar Utilizadores</span>
                </Link>
              </li>
              <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
                <Link
                  @click.stop
                  :href="route('teams.teamadmin.create')"
                  class="flex items-center w-full"
                >
                  <FontAwesomeIcon :icon="faPlus" class="w-5 h-5" />
                  <span class="ml-3 text-sm">Criar Administrador</span>
                </Link>
              </li>
              <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
                <Link
                  @click.stop
                  :href="route('teams.teamadmin.index')"
                  class="flex items-center w-full"
                >
                  <FontAwesomeIcon :icon="faUserShield" class="w-5 h-5" />
                  <span class="ml-3 text-sm">Admins de Setor</span>
                </Link>
              </li>
            </ul>
          </template>
        </li>
      </ul>
    </nav>
  </div>
</template>

