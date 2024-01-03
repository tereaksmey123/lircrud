import React, { useState, useEffect } from 'react';

import {
  ConfigProvider,
  App as MyApp,
  Layout,
  Menu,
  Button,
  theme,
  Dropdown,
  Space,
  Avatar,
  Badge
} from 'antd';
// import { StyleProvider } from '@ant-design/cssinjs';

import Header from "@/lircrud/Layouts/Admin/Header"
import LeftSideBar from "@/lircrud/Layouts/Admin/LeftSideBar"
import useThemeStore from '@/Modules/LirCrud/Stores/useThemeStore'

const { Content } = Layout;


export default function AdminLayout({ children }) {
  const getTheme = useThemeStore(state => state.theme)
  const addClassToBody = useThemeStore(state => state.addClassToBody)
  
  useEffect(() => addClassToBody(getTheme), [])

  return (
    <ConfigProvider
      theme={{
        components: {
          Layout: {
            headerPadding: 0
          },
          Menu: {
            itemMarginBlock: 0,
            itemMarginInline: 0,
          },
        },
        token: {
          borderRadius: 0,
        },
        // cssVar: true,
        hashed: false,
        algorithm: [getTheme === 'dark' ? theme.darkAlgorithm : theme.defaultAlgorithm]
      }}
    >
      {/* <StyleProvider hashPriority='high'> */}
      <MyApp>
        <Layout>
          <Header />

          <Layout className={'border-solid border-t-slate-50 dark:border-t-neutral-600 border-b-0 border-x-0'}>
            <LeftSideBar />
            
            <Content className={'mx-5 mt-5'} >
              { children }
            </Content>
          </Layout>
        </Layout>
      </MyApp>
      {/* </StyleProvider> */}
    </ConfigProvider>
  )
}