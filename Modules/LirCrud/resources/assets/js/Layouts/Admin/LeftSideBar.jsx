import React, { useState } from 'react';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UserOutlined,
} from '@ant-design/icons';

import {
  Layout,
  Menu,
} from 'antd';
import useLeftSideBar from '@/Modules/LirCrud/Stores/useLeftSideBar'

const { Sider } = Layout;


export default function Admin() {
  const [collapsed, setCollapsed] = useState(false);
  const {selectedKeys, openKeys, setActiveMenu} = useLeftSideBar()

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
            key: 'Authorization',
            icon: <UserOutlined />,
            label: 'Authorization',
            children: [
              {
                key: 'User',
                // icon: <UserOutlined />,
                label: 'User',
                onClick: (e) => setActiveMenu(e)
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