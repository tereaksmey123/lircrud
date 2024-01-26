
import { create } from 'zustand'
import { persist } from "zustand/middleware";

interface UseThemeMode {
  theme: string,
  setTheme: (theme: string) => void,
  addClassToBody: (theme: string|false) => void
}

const LIGHT: string = 'light'
const DARK: string = 'dark'

const useThemeMode = create<UseThemeMode>()(
  persist(
    (set, get) => ({
      theme: LIGHT,

      setTheme: (theme) => {
        get().addClassToBody(theme)

        set({theme: theme})
      },

      addClassToBody: (theme = false) => {
        // add class to body for tailwind dark mode
        document.body.classList.remove(DARK)
        document.body.classList.remove(LIGHT)
        document.body.classList.add(theme || get().theme)
      }
    }),
    
    {name: appName + '_lircrudThemeStore'},
  ),
)

// only work when perssit() is present. else will fall to init theme value
// addTailwindDarkModeSupport(useThemeStore.getState().theme)

export {useThemeMode, LIGHT, DARK}