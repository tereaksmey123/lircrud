import {
  UserOutlined,
  LogoutOutlined,
  AppstoreAddOutlined,
  SettingOutlined
} from '@ant-design/icons';

import {
  Layout,
  Button,
  Dropdown,
} from 'antd';

import useThemeStore from '@/Modules/LirCrud/Stores/useThemeStore'
import {DarkMode, LightMode} from '@/Modules/LirCrud/Components/Icon/ThemeMode'
import {logoutAction} from '@/Modules/LirCrud/Actions/Logout'
import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'
import ThemeButton from '@/Modules/LirCrud/Components/Button/ThemeButton'

const { Header: AntdHeader} = Layout;
const Header = () => {
  const { token } = useToken()
  
  const theme = useThemeStore(state => state.theme)
  const setTheme = useThemeStore(state => state.setTheme)
  
  
  return (
    <AntdHeader
      className={'flex align-middle'}
      style={{ background: token.colorBgContainer }}
    >
      <Button className='px-5 border-0 w-[200px] h-16 text-left'>
        <h1 className="mb-0"><AppstoreAddOutlined /> LirCrud</h1>
      </Button>

      {/*
        - Tricky way to fill space with default backgroud for mode change
        - Due to Ant design Menu is not suitable for smaller screen when collapse
      */}
      <div
        className={'!min-w-0 !flex-auto h-16 justify-end'}
        style={{ background: token.colorBgContainer }}
      ></div>

      {/* <Dropdown
        menu={{
          items: [
            {
              key: 'light', 
              label: 'Light', 
              icon: <LightMode className="w-6 h-6 " />,
              onClick: (e) => setTheme(e.key)
            },
            {
              key: 'dark', 
              label: 'Dark', 
              icon: <DarkMode className="w-6 h-6" />,
              onClick: (e) => setTheme(e.key)
            },
          ],
          selectable: true,
          selectedKeys: [theme],
        }}
      >
        <Button type="default" className={'h-16 !w-16 border-0'}>
          <Badge count={1} overflowCount={10} size="small" offset={[10, -5]}>
            <NotificationOutlined className={'!text-xl'} />
          </Badge>
        </Button>
      </Dropdown> */}
      <ThemeButton />
      {/* <Dropdown
        menu={{
          items: [
            {
              key: 'light', 
              label: 'Light', 
              icon: <LightMode className="w-6 h-6 " />,
              onClick: (e) => setTheme(e.key)
            },
            {
              key: 'dark', 
              label: 'Dark', 
              icon: <DarkMode className="w-6 h-6" />,
              onClick: (e) => setTheme(e.key)
            },
          ],
          selectable: true,
          selectedKeys: [theme],
        }}
      >
        <Button type='default' className={'h-16 !w-16 border-0'}>
          {theme === 'dark' ? <DarkMode className="w-6 h-6" /> :<LightMode className="w-6 h-6 " />}
        </Button>
      </Dropdown> */}

      <Dropdown
        menu={{ items: [
          {
            key: 'My Account',
            icon: <UserOutlined />,
            label: 'My Account',
          },
          {
            key: 'Logout',
            icon: <LogoutOutlined />,
            label: 'Logout',
            onClick: () => logoutAction()
          }
        ]}}
      >
        <Button
          type='default'
          className={'h-16 !w-16 border-0'}
          icon={<SettingOutlined className={'!text-xl'}/>}
        />
      </Dropdown>
    </AntdHeader>
  )
}

export default Header