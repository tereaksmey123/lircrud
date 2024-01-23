import React, { useEffect, useState, Suspense } from 'react';
import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'
import Content from '@/Modules/LirCrud/Components/Content'
// import Number from '@/Modules/LirCrud/Components/Field/Number'
// import Text from '@/Modules/LirCrud/Components/Field/Text'
import {FieldComponents} from '@/Modules/LirCrud/Components/Fields'
import FormButton from '@/Modules/LirCrud/Components/Button/FormButton'

import { Table, Row, Col, Button, Form } from 'antd';


export default ({ }) => {
  const [form] = Form.useForm()
  const { token } = useToken()
  const handileCreate = (values) => {

    console.log(values)
  }

  return (
    <Row>
      <Col span={24}>
        <h1>Create Users</h1>
      </Col>
      <Content>
      <Form form={form} onFinish={handileCreate} layout={'vertical'}>
        <Suspense fallback={'loading'}>
            {
              [
                {type: 'Field.Number', name: 'phone', rules: [{required: true}]},
                {type: 'Field.Text', name: 'first_name'},
                {type: 'Field.Text', name: 'last_name'},

              ].map(v => {
                let InputComponent = FieldComponents[v.type]
                // console.log(v.name)
                return (<InputComponent key={v.name} {...v}/>)
              })
            }
              {/* <Number></Number>
              <Text></Text> */}
              <FormButton form={form}/>
           
        </Suspense>
       </Form>
      </Content>
    </Row>
  );
};