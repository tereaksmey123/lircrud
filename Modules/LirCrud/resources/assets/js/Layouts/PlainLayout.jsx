import React from "react";
import { ConfigProvider, App as MyApp, theme } from 'antd';
// import {Navbar, NavbarBrand, NavbarContent, NavbarItem, Link, Button, Image} from "@nextui-org/react";
// import { button as buttonStyles } from "@nextui-org/theme";

export default function PlainLayout({ children }) {
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