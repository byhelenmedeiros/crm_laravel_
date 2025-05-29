<script setup>
import { ref, computed, watch } from 'vue';
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
import SubMenu from './SubMenu.vue';

const props = defineProps({
  sidebarOpen: { type: Boolean, default: true }
});

const authStore = useAuthStore();
const page = usePage();

const user = computed(() => authStore.user);
const isSuperadmin = computed(() => authStore.isSuperadmin);
const isAdmin = computed(() => authStore.isAdmin);

watch(
  () => page.props.auth?.user,
  (user) => {
    if (user) {
      authStore.setUser(user);
    }
  },
  { immediate: true }
);

const menuItems = ref([
  { label: 'Dashboard', url: route('dashboard'), icon: faTachometerAlt },
  { label: 'Perfil', url: route('profile.edit'), icon: faUser },
  { label: 'Configurações', url: '#', icon: faCog },
  { label: 'Utilizadores', url: route('users.index'), icon: faUser, submenu: true },
  { label: 'Clientes', url: route('clients.index'), icon: faList, submenu: true }
]);

// Função para verificar se o item tem submenu
const hasSubmenu = (item) => item.submenu;
</script>

<template>
  <div v-if="user">
    <nav>
      <ul>
        <li v-for="(item, index) in menuItems" :key="index" class="flex flex-col">
          <template v-if="!hasSubmenu(item)">
            <Link :href="item.url" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <FontAwesomeIcon :icon="item.icon" class="w-4 h-4" />
              <span v-if="sidebarOpen" class="ml-2 text-sm">{{ item.label }}</span>
            </Link>
          </template>
          
          <!-- Submenu -->
          <template v-else>
            <SubMenu
              :item="item"
              :is-superadmin="isSuperadmin"
              :is-admin="isAdmin"
              :sidebar-open="sidebarOpen"
            />
          </template>
        </li>
      </ul>
    </nav>
  </div>
</template>
