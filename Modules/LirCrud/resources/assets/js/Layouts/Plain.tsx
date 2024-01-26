import React from "react";
import { ConfigProvider, App as MyApp, theme } from 'antd';

export default function PlainLayout({ children }: Readonly<ReactChildrenProps>) {
  return (
    <ConfigProvider
      theme={{
        // cssVar: true,
        hashed: false,
        algorithm: [theme.darkAlgorithm, theme.compactAlgorithm]
      }}
    >
      <MyApp>
        { children }
      </MyApp>
    </ConfigProvider>
  )
}