import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  getters: {
    isSuperadmin(state) {
      return state.user ? Number(state.user.role_id) === 1 : false;
    },
  },
  actions: {
    setUser(user) {
      this.user = user;
    },
  },
});
