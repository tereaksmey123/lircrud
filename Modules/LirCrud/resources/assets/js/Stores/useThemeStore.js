
import { create } from 'zustand'
import { persist } from "zustand/middleware";

const useThemeStore = create(
  persist(
    (set, get) => ({
      theme: 'light',
      setTheme: (state) => {
        get().addClassToBody(state)

        set({theme: state})
      },
      addClassToBody: (theme = false) => {
        // add class to body for tailwind dark mode
        document.body.classList.remove('dark')
        document.body.classList.remove('light')
        
        document.body.classList.add(theme ? theme : get().theme)
      }
    }),
    {name: 'lircrudThemeStore'},
  ),
)

// only work when perssit() is present. else will fall to init theme value
// addTailwindDarkModeSupport(useThemeStore.getState().theme)

export default useThemeStore