<template>
  <nav>
    <ul>
      <li v-for="(item, index) in menuItems" :key="index" class="flex flex-col">
        <!-- Caso o item não seja "Utilizadores", renderiza o link normalmente -->
        <template v-if="item.label !== 'Utilizadores'">
          <Link :href="item.url" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
            <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
            <span v-if="sidebarOpen" class="ml-3 text-sm text-gray-700">{{ item.label }}</span>
          </Link>
        </template>
        <!-- Item "Utilizadores" funcionando como dropdown para superadmin -->
        <template v-else>
          <div @click="isSuperadmin && toggleSubmenu()" class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
            <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
            <span v-if="sidebarOpen" class="ml-3 text-sm text-gray-700">{{ item.label }}</span>
            <FontAwesomeIcon
              v-if="sidebarOpen && isSuperadmin"
              :icon="submenuOpen ? faChevronDown : faChevronRight"
              class="ml-auto w-4 h-4" />
          </div>
          <ul v-if="isSuperadmin" v-show="submenuOpen && sidebarOpen" class="ml-8">
            <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <Link @click.stop :href="route('users.index')" class="flex items-center w-full">
                <FontAwesomeIcon :icon="faList" class="w-5 h-5" />
                <span class="ml-3 text-sm text-gray-700">Listar Utilizadores</span>
              </Link>
            </li>
            <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <Link @click.stop :href="route('users.teamadmin.create')" class="flex items-center w-full">
                <FontAwesomeIcon :icon="faPlus" class="w-5 h-5" />
                <span class="ml-3 text-sm text-gray-700">Criar Administrador</span>
              </Link>
            </li>
            <li class="flex items-center px-4 py-2 hover:bg-gray-200 cursor-pointer">
              <Link @click.stop :href="route('users.teamadmin.index')" class="flex items-center w-full">
                <FontAwesomeIcon :icon="faUserShield" class="w-5 h-5" />
                <span class="ml-3 text-sm text-gray-700">Admins de Setor</span>
              </Link>
            </li>
          </ul>
        </template>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps, ref, computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faTachometerAlt,
  faUser,
  faCog,
  faList,
  faPlus,
  faUserShield,
  faChevronRight,
  faChevronDown
} from '@fortawesome/free-solid-svg-icons'

const props = defineProps({
  sidebarOpen: { type: Boolean, default: true }
})

const menuItems = ref([
  { label: 'Dashboard', url: route('dashboard'), icon: faTachometerAlt },
  { label: 'Perfil', url: route('profile.edit'), icon: faUser },
  { label: 'Configurações', url: '#', icon: faCog },
  { label: 'Utilizadores', url: route('users.index'), icon: faUser }
])

const pageProps = usePage().props.value || {};
const isSuperadmin = computed(() => pageProps.auth?.user?.role_id === 'superadmin')
<div class="text-xs text-red-500">
  Role: {{ pageProps.value.auth?.user?.role_id || 'não definido' }}
</div>


const submenuOpen = ref(false)
const toggleSubmenu = () => {
  submenuOpen.value = !submenuOpen.value
}
</script>
