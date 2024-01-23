import React, { useEffect, useState } from 'react';
import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'

import { Table, Row, Col, Button, Form, Input } from 'antd';


export default ({ name }) => {
  const { token } = useToken()

  return (
    <Form.Item name={name} label={'te'}>
      <Input />
    </Form.Item>
  );
};