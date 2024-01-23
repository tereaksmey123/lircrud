
import { create } from 'zustand'
import { persist } from "zustand/middleware";

const LIGHT = 'light'
const DARK = 'dark'

const useThemeStore = create(
  persist(
    (set, get) => ({
      theme: LIGHT,
      setTheme: (state) => {
        get().addClassToBody(state)

        set({theme: state})
      },
      addClassToBody: (theme = false) => {
        // add class to body for tailwind dark mode
        document.body.classList.remove(DARK)
        document.body.classList.remove(LIGHT)
        document.body.classList.add(theme || get().theme)
      }
    }),
    {name: 'lircrudThemeStore'},
  ),
)

// only work when perssit() is present. else will fall to init theme value
// addTailwindDarkModeSupport(useThemeStore.getState().theme)

export default useThemeStore