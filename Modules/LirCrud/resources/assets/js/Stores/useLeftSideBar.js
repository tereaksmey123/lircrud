
import { create } from 'zustand'
import { persist } from "zustand/middleware";
import { router } from '@inertiajs/react'

const useLeftSideBar = create(
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
    {name: 'lircrudLeftSideBar'},
  ),
)

export default useLeftSideBar