import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    setUser(user) {
      this.user = user;
      console.log('[authStore] Usuário atualizado:', user);
    },
  },
  getters: {
    isSuperadmin(state) {
      return state.user ? Boolean(state.user.isSuperadmin) : false;
    },
    isAdmin(state) {
      return state.user ? Boolean(state.user.isAdmin) : false;
    },
  },
});
