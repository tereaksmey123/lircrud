import { Button } from 'antd';

import { DarkMode, LightMode } from '@/Modules/LirCrud/Components/Icon/ThemeMode'
import {useThemeMode, LIGHT, DARK} from '@/lircrud/Stores/useThemeMode'

interface ThemeButton {
  buttonProps?: any,
  iconProps?: any
}

const ThemeButton = ({ buttonProps, iconProps }: ThemeButton) => {
  const theme = useThemeMode(state => state.theme)
  const setTheme = useThemeMode(state => state.setTheme)

  const button = {
    type: 'text',
    className: 'h-16 !w-16 border-0',
    onClick: () => {
      setTheme(theme === 'dark' ? LIGHT : DARK)
    },
    ...buttonProps ?? {}
  }
  // Watch value

  return (
    <Button {...button}>
      {theme === DARK
          ? <DarkMode {...iconProps ?? {className: 'w-6 h-6'}} />
          : <LightMode {...iconProps ?? {className: 'w-6 h-6'}} />
      }
    </Button>
  )
}

export default ThemeButton