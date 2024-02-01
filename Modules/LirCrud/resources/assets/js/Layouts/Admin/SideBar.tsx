import { useState } from 'react';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UserOutlined,
} from '@ant-design/icons';

import {
  Layout,
  Menu,
} from 'antd';
import {useSideBar} from '@/lircrud/Stores/useSideBar'

const { Sider } = Layout;


export default function SideBar() {
  const [collapsed, setCollapsed] = useState(false);
  const {selectedKeys, openKeys, setActiveMenu} = useSideBar()

  return (
    <Sider
      breakpoint='sm'
      collapsible
      trigger={collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}
      collapsed={collapsed}
      onCollapse={() => setCollapsed(! collapsed)}
    >
      <Menu
        mode="inline"
        className={'h-dvh'}
        defaultSelectedKeys={selectedKeys.length ? selectedKeys : []}
        defaultOpenKeys={openKeys.length ? openKeys : []}
        
        // onSelect={(e) => console.log(e)}
        items={[
          {
            key: 'Setting',
            // icon: <VideoCameraOutlined />,
            label: 'Setting',
            onClick: (e) => setActiveMenu(e, '/admin/setting')
          },
          {
            key: 'Authorization',
            icon: <UserOutlined />,
            label: 'Authorization',
            children: [
              {
                key: 'User',
                // icon: <UserOutlined />,
                label: 'User',
                onClick: (e) => setActiveMenu(e, '/admin/user')
              },
              {
                key: 'Role',
                // icon: <VideoCameraOutlined />,
                label: 'Role',
                onClick: (e) => setActiveMenu(e)
              },
              {
                key: 'Permission',
                // icon: <UploadOutlined />,
                label: 'Permission',
                children: [
                  {
                    key: 'Role1',
                    // icon: <VideoCameraOutlined />,
                    label: 'Role1',
                    onClick: (e) => setActiveMenu(e)
                  },
                  {
                    key: 'Role11',
                    // icon: <VideoCameraOutlined />,
                    label: 'Role11',
                    children: [
                      {
                        key: 'Role111',
                        // icon: <VideoCameraOutlined />,
                        label: 'Role111',
                        onClick: (e) => setActiveMenu(e)
                      },
                    ]
                  },
                ]
              },
            ]
          },
          
        ]}
      />
    </Sider>
  )
}