import { Button } from 'antd';

import { DarkMode, LightMode } from '@/Modules/LirCrud/Components/Icon/ThemeMode'
import useThemeStore from '@/Modules/LirCrud/Stores/useThemeStore'

export default ({ buttonProps, iconProps }) => {
  const theme = useThemeStore(state => state.theme)
  const setTheme = useThemeStore(state => state.setTheme)

  const button = {
    type: 'text',
    className: 'h-16 !w-16 border-0',
    onClick: () => {
      setTheme(theme === 'dark' ? 'light' : 'dark')
    },
    ...buttonProps ?? {}
  }
  // Watch value

  return (
    <Button {...button}>
      {theme === 'dark'
          ? <DarkMode {...iconProps ?? {className: 'w-6 h-6'}} />
          : <LightMode {...iconProps ?? {className: 'w-6 h-6'}} />
      }
    </Button>
  )
}