<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faBars,
  faTimes,
  faEnvelope,
  faBell,
  faCog,
  faTachometerAlt,
  faUser,
} from "@fortawesome/free-solid-svg-icons";
import SidebarMenu from "@/Components/SidebarMenu.vue";

// Estado reativo da sidebar e função de toggle
const sidebarOpen = ref(true);
const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

</script>

<template>
  <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside
      :class="sidebarOpen ? 'w-64' : 'w-16'"
      class="bg-white border-r border-gray-200 transition-all ease-in-out duration-300 overflow-hidden"
    >
      <div class="p-4 flex items-center justify-between">
        <span class="text-lg font-bold text-gray-800 transition-none" v-show="sidebarOpen">
          Uin Sports
        </span>
        <button @click="toggleSidebar" class="p-2 focus:outline-none">
          <FontAwesomeIcon v-if="sidebarOpen" :icon="faTimes" class="w-4 h-4" />
          <FontAwesomeIcon v-else :icon="faBars" class="w-4 h-4" />
        </button>
      </div>
      <!-- Menu separado -->
      <SidebarMenu :sidebarOpen="sidebarOpen" />
    </aside>

    <!-- Área Principal -->
    <div class="flex-1 flex flex-col">
      <header class="flex items-center justify-between bg-white border-b border-gray-200 p-2 transition-all ease-in-out duration-300">
        <div class="flex-1">
          <!-- Barra de pesquisa sera criado componente separado futuramente-->
          <input
            type="text"
            placeholder="Pesquisar..."
            class="w-64 p-1 border border-gray-300 text-sm transition-all ease-in-out duration-300"
          />
        </div>
        <div class="ml-4 flex items-center space-x-3">
          <div class="hidden md:block mr-4 text-right">
            <div class="font-semibold text-sm text-gray-800">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="text-xs text-gray-500">
              {{ $page.props.auth.user.email }}
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
      </header>
      <!-- Conteúdo injetado via slot -->
      <main class="flex-1 p-4 text-sm transition-all ease-in-out duration-300">
        <slot />
      </main>
    </div>
  </div>
</template>
