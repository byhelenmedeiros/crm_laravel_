<script setup>
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';

// Importação dos ícones do Font Awesome
import { 
  faTachometerAlt, 
  faUsers, 
  faIdBadge, 
  faDollarSign, 
  faClipboardList, 
  faChartLine, 
  faFolder, 
  faFileAlt, 
  faUserTie, 
  faNewspaper, 
  faTh, 
  faMobileAlt,
  faBars,
  faTimes,
  faEnvelope,
  faBell,
  faCog
} from '@fortawesome/free-solid-svg-icons';

// Variável para controlar se a sidebar está expandida ou recolhida
const sidebarOpen = ref(true);

// Array simulando os itens do menu
const menuItems = [
  { label: 'Dashboard', icon: faTachometerAlt },
  { label: 'Employees', icon: faUsers },
  { label: 'Core HR', icon: faIdBadge },
  { label: 'Finance', icon: faDollarSign },
  { label: 'Tasks', icon: faClipboardList },
  { label: 'Performance', icon: faChartLine },
  { label: 'Projects', icon: faFolder },
  { label: 'Reports', icon: faFileAlt },
  { label: 'Manage Clients', icon: faUserTie },
  { label: 'Blog', icon: faNewspaper },
  { label: 'SVG Icons', icon: faTh },
  { label: 'Apps', icon: faMobileAlt },
];
</script>

<template>
  <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white border-r border-gray-200 transition-all duration-300 overflow-hidden">
      <!-- Cabeçalho da Sidebar: Título e botão de toggle -->
      <div class="p-4 flex items-center justify-between">
        <!-- Exibe "Uin Sports" quando expandida; caso contrário, uma abreviação "US" -->
        <span class="text-xl font-bold text-gray-800" v-if="sidebarOpen">Uin Sports</span>
        <span class="text-xl font-bold text-gray-800" v-else>US</span>
        <!-- Botão para expandir/recolher -->
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 focus:outline-none">
          <FontAwesomeIcon v-if="sidebarOpen" :icon="faTimes" class="w-6 h-6" />
          <FontAwesomeIcon v-else :icon="faBars" class="w-6 h-6" />
        </button>
      </div>
      <!-- Menu de navegação simulado -->
      <nav>
        <ul>
          <li v-for="(item, index) in menuItems" :key="index" class="flex items-center px-4 py-2 hover:bg-gray-200">
            <FontAwesomeIcon :icon="item.icon" class="w-6 h-6" />
            <!-- Exibe o nome somente se a sidebar estiver expandida -->
            <span v-if="sidebarOpen" class="ml-3 text-gray-700">{{ item.label }}</span>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Área Principal: Top bar + conteúdo -->
    <div class="flex-1 flex flex-col">
      <!-- Top Bar -->
      <header class="flex items-center justify-between bg-white border-b border-gray-200 p-4">
        <!-- Barra de pesquisa -->
        <div class="flex-1">
          <input 
            type="text" 
            placeholder="Pesquisar..." 
            class="w-full p-2 border border-gray-300 rounded" 
          />
        </div>
        <!-- Área de usuário e ícones -->
        <div class="ml-4 flex items-center space-x-4">
          <!-- Exibição condicional do nome/email do usuário -->
          <div class="hidden md:block text-right">
            <div class="font-semibold text-gray-800">{{ $page.props.auth.user.name }}</div>
            <div class="text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>
          <!-- Ícones do Font Awesome -->
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faEnvelope" class="w-6 h-6" />
          </button>
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faBell" class="w-6 h-6" />
          </button>
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faCog" class="w-6 h-6" />
          </button>
        </div>
      </header>

      <!-- Conteúdo Principal -->
      <main class="flex-1 p-4">
        <slot />
      </main>
    </div>
  </div>
</template>
