import React, { useEffect, useState } from 'react';
import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'

import { Table, Row, Col, Button, Form, Input, InputNumber } from 'antd';


export default ({ name, rules }) => {
  const { token } = useToken()
  console.log(name)
  return (
    <Form.Item name={name} col={'16'} rules={rules} label={(<span></span>)}>
      <InputNumber />
    </Form.Item>
  );
};