<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white border-r border-gray-200 transition-all duration-300 overflow-hidden">
      <div class="p-4 flex items-center justify-between">
        <span v-if="sidebarOpen" class="text-lg font-bold text-gray-800">Uin Sports</span>
        <button @click="toggleSidebar" class="p-2 focus:outline-none">
          <FontAwesomeIcon v-if="sidebarOpen" :icon="faTimes" class="w-4 h-4" />
          <FontAwesomeIcon v-else :icon="faBars" class="w-4 h-4" />
        </button>
      </div>
      <SidebarMenu :sidebarOpen="sidebarOpen" />
    </aside>

    <!-- Área Principal -->
    <div class="flex-1 flex flex-col">
      <header class="flex items-center justify-between bg-white border-b border-gray-200 p-2 transition-all duration-300">
        <div class="flex-1">
          <input type="text" placeholder="Pesquisar..." class="w-64 p-1 border border-gray-300 text-sm transition-all duration-300" />
        </div>
        <div class="ml-4 flex items-center space-x-3">
          <!-- Acesse os dados via a variável 'page' -->
          <div v-if="page.props.auth" class="hidden md:block mr-4 text-right">
            <div class="font-semibold text-sm text-gray-800">
              {{ page.props.auth.user.name }}
            </div>
            <div class="text-xs text-gray-500">
              {{ page.props.auth.user.email }}
            </div>
          </div>
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faEnvelope" class="w-5 h-5" />
          </button>
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faBell" class="w-5 h-5" />
          </button>
          <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <FontAwesomeIcon :icon="faCog" class="w-5 h-5" />
          </button>
        </div>
        <div class="ml-4">
          <!-- botao para logout -->
         <Link :href="route('logout')" method="post" as="button" class="text-gray-600 hover:text-gray-800 focus:outline-none">
  Sair
</Link>

        </div>
      </header>

      <!-- Conteúdo dinâmico injetado via slot -->
      <main class="flex-1 p-2 text-sm transition-all duration-300">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBars, faTimes, faEnvelope, faBell, faCog } from '@fortawesome/free-solid-svg-icons';
import SidebarMenu from '@/Components/SidebarMenu.vue';
import { useForm } from '@inertiajs/vue3';
import { usePage, Link } from '@inertiajs/vue3';  
const sidebarOpen = ref(true);
const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const page = usePage();
</script>
