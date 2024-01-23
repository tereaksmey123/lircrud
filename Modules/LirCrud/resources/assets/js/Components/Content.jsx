import React, { useEffect, useState } from 'react';
import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'

import { Table, Row, Col, Button } from 'antd';


export default ({ children }) => {
  const { token } = useToken()

  return (
    <Col span={24} style={{background: token.colorBgContainer}} className={'p-3'}>
      {children}
    </Col>
  );
};