
import { create } from 'zustand'
import { persist } from "zustand/middleware";

const useLeftSideBar = create(
  persist(
    (set, get) => ({
      selectedKeys: [],
      openKeys: [],
      setActiveMenu: (activeMenu) => {
        set({selectedKeys: [activeMenu.key], openKeys: activeMenu.keyPath})
      }
    }),
    {name: 'lircrudLeftSideBar'},
  ),
)

export default useLeftSideBar