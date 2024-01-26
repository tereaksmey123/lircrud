import React, { Suspense } from 'react';
import Content from '@/Modules/LirCrud/Components/Content'
// import Number from '@/Modules/LirCrud/Components/Field/Number'
// import Text from '@/Modules/LirCrud/Components/Field/Text'
import {FieldComponents} from '@/Modules/LirCrud/Components/Fields'
import FormButton from '@/lircrud/Components/Button/FormButton'

import { Row, Col, Form } from 'antd';


const CrudCreate = () => {
  const [form] = Form.useForm()

  return (
    <Row>
      <Col span={24}>
        <h1>Create Users</h1>
      </Col>
      <Content>
      <Form
        form={form}
        // onFinish={handileCreate}
        layout={'vertical'}
      >
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
              <FormButton form={form} label="Save"/>
           
        </Suspense>
       </Form>
      </Content>
    </Row>
  );
};

export default CrudCreate