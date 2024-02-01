import React, { useState, Suspense, lazy } from 'react';
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
        // onFieldsChange={}
        layout={'vertical'}
      >
        <Suspense fallback={'loading'}>
            {
              [
                {type: 'Fields.Number', name: 'phone', rules: [{required: true}]},
                {type: 'Fields.Text', name: 'first_name1', component: {type: 'Fields.Text'}},
                {type: 'Field.Text', name: 'last_name'},

              ].map(v => {
                const fields = FieldComponents
                let Component =  Object.hasOwn(fields, v.type) ? fields[v.type] : () => (<></>)

                if (v?.component?.type ?? false) {
                  let ComponentWrapper = Object.hasOwn(fields, v?.component?.type ?? 'asda')
                    ? fields[v?.component?.type ?? 0]
                    : () => (<></>)

                  return <ComponentWrapper key={v.name+(v?.component?.type ?? 'asd')}>
                  <Component key={v.name} {...v}/>
                </ComponentWrapper>
                }
                
                return <Component key={v.name} {...v}/>
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