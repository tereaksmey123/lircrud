
import { create } from 'zustand'
import { persist } from "zustand/middleware";
import { router } from '@inertiajs/react'

interface UseSideBar {
  selectedKeys: Array<string>,
  openKeys: Array<string>,
  setActiveMenu: (
    activeMenu: {key: string, keyPath: Array<string>},
    to?: string|false
  ) => void
  goToPage: (to: string) => void,
  
}

const useSideBar = create<UseSideBar>()(
  persist(
    (set, get) => ({
      selectedKeys: [],

      openKeys: [],
      
      setActiveMenu: (activeMenu, to = false) => {
        set({selectedKeys: [activeMenu.key], openKeys: activeMenu.keyPath})

        if (to) {
          get().goToPage(to)
        }
      },

      goToPage: (to) => {
        router.visit(to)
      }
    }),

    {name: appName + '_lircrudSideBar'},
  ),
)

export {useSideBar}