<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
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

// Controle do estado da sidebar: expandida ou recolhida
const sidebarOpen = ref(true);

// Array de itens do menu com rotas reais (ajuste os nomes das rotas conforme sua aplicação)
const menuItems = [
  { label: 'Dashboard', url: route('dashboard'), icon: faTachometerAlt },
  { label: 'Employees', url: route('employees.index'), icon: faUsers },
  { label: 'Core HR', url: route('core-hr.index'), icon: faIdBadge },
  { label: 'Finance', url: route('finance.index'), icon: faDollarSign },
  { label: 'Tasks', url: route('tasks.index'), icon: faClipboardList },
  { label: 'Performance', url: route('performance.index'), icon: faChartLine },
  { label: 'Projects', url: route('projects.index'), icon: faFolder },
  { label: 'Reports', url: route('reports.index'), icon: faFileAlt },
  { label: 'Manage Clients', url: route('clients.index'), icon: faUserTie },
  { label: 'Blog', url: route('blog.index'), icon: faNewspaper },
  { label: 'SVG Icons', url: route('svgs.index'), icon: faTh },
  { label: 'Apps', url: route('apps.index'), icon: faMobileAlt },
];
</script>

<template>
  <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar com transição suave entre larguras -->
    <aside
      :class="sidebarOpen ? 'w-64' : 'w-16'"
      class="bg-white border-r border-gray-200 transition-all duration-300 overflow-hidden"
    >
      <!-- Cabeçalho da sidebar com título e botão toggle -->
      <div class="p-4 flex items-center justify-between">
        <span v-if="sidebarOpen" class="text-xl font-bold text-gray-800">Uin Sports</span>
        <span v-else class="text-xl font-bold text-gray-800">US</span>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 focus:outline-none">
          <FontAwesomeIcon v-if="sidebarOpen" :icon="faTimes" class="w-6 h-6" />
          <FontAwesomeIcon v-else :icon="faBars" class="w-6 h-6" />
        </button>
      </div>
      <!-- Menu de navegação com links reais -->
      <nav>
        <ul>
          <li 
            v-for="(item, index) in menuItems" 
            :key="index" 
            class="flex items-center px-4 py-2 transition-colors duration-200 hover:bg-gray-200"
          >
            <Link :href="item.url" class="flex items-center w-full">
              <!-- Os ícones ficam um pouco menores quando a sidebar está recolhida -->
              <FontAwesomeIcon :icon="item.icon" :class="sidebarOpen ? 'w-6 h-6 text-gray-500' : 'w-5 h-5 text-gray-500'" />
              <span 
                v-if="sidebarOpen" 
                class="ml-3 text-sm text-gray-500 hover:text-black transition-colors duration-200"
              >
              
                {{ item.label }}
              </span>
            </Link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Área Principal -->
    <div class="flex-1 flex flex-col">
      <!-- Top Bar com busca e informações do usuário -->
      <header class="flex items-center justify-between bg-white border-b border-gray-200 p-4">
        <div class="flex-1">
          <input
            type="text"
            placeholder="Pesquisar..."
            class="w-full p-2 border border-gray-300 rounded"
          />
        </div>
        <div class="ml-4 flex items-center space-x-4">
          <div class="hidden md:block text-right">
            <div class="font-semibold text-gray-800">{{ $page.props.auth.user.name }}</div>
            <div class="text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>
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

      <!-- Conteúdo dinâmico injetado via slot -->
      <main class="flex-1 p-4">
        <slot />
      </main>
    </div>
  </div>
</template>
