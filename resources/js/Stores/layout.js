import { defineStore } from 'pinia'

export const useLayoutStore = defineStore('layout', {
  state: () => ({
    isAsideMobileExpanded: true,
    isAsideLgActive: false
  }),

  actions: {
    asideMobileToggle () {
      this.isAsideMobileExpanded = !this.isAsideMobileExpanded
    }
  }
})
