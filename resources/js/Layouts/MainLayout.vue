<template>
  <div class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Cabeçalho -->
    <header class="bg-gray-800 p-4">
      <h1 class="text-2xl font-bold">Uin Sports CRM</h1>
    </header>

    <div class="flex flex-1">
      <!-- Sidebar (pode ser um componente separado) -->
      <Sidebar class="w-64" />

      <!-- Conteúdo da página -->
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
    
    <!-- Rodapé -->
    <footer class="bg-gray-800 p-2 text-center text-sm">
      &copy; {{ new Date().getFullYear() }} Uin Sports
    </footer>
  </div>
</template>

<script>
//import Sidebar from '@/Components/Sidebar.vue';
export default {
  components: {
    Sidebar
  }
}
</script>
