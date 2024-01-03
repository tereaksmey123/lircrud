import React from 'react';
import { UploadOutlined, UserOutlined, VideoCameraOutlined } from '@ant-design/icons';
import { Button, Checkbox, Form, Input, Layout, theme, Row, Card } from 'antd';
import PlainLayout from "@/Modules/LirCrud/Layouts/PlainLayout"
import { router } from '@inertiajs/react'

import FormButton from '@/lircrud/Components/Button/FormButton'

import {toSetFieldsError} from '@/Modules/LirCrud/helpers/Antd/ValidateAntd'

const Login = ({ rules, auth }) => {
  const [form] = Form.useForm();
  // console.log(auth)
  const onFinish = (values) => {

    router.post(`${appUrl}/admin/login`, values, {
      // onSuccess: (page) => {
      //   console.log(1)
      // },
      onError: (errors) => {
        toSetFieldsError(errors, form.getFieldsValue(true), form)
      },
    })

    // axios.post(`${appUrl}/admin/login`, values)
    //   .then(res => {
  
    //   })
    //   .catch(e => console.log(e))
    // console.log('Success:', values);
  };

  // const onFinishFailed = (errorInfo) => {
  //   console.log('Failed:', errorInfo);
  // };

  return (
    <Layout>
      <Row type="flex" justify="center" align="middle" style={{minHeight: '100vh'}}>
        <Card title="Login">
          <Form
            form={form}
            style={{ width: 300 }}
            initialValues={{
              remember: false,
            }}
            size='large'
            onFinish={onFinish}
            // onFinishFailed={onFinishFailed}
            autoComplete="off"
        >
          <Form.Item
            name="username"
            rules={rules.username}
          >
            <Input suffix={<UserOutlined className="site-form-item-icon" />} placeholder="012xxxxxxx" />
          </Form.Item>

          <Form.Item
            name="password"
            rules={rules.password}
          >
            <Input.Password />
          </Form.Item>

          <Form.Item>
            <Form.Item
              name="remember"
              valuePropName="checked"
            >
              <Checkbox >Remember me</Checkbox>
            </Form.Item>
            <a className="login-form-forgot" href="">Forgot password</a>
          </Form.Item>

          <Form.Item>
            <FormButton
              form={form}
              buttonProps={{props: {className: "login-form-button"}, label: 'Login' }}
            />
            Or <a href="">register now!</a>
          </Form.Item>
        </Form>
      </Card>
    </Row>
  </Layout>
  );
};

Login.layout = page => <PlainLayout children={page}/>

export default Login;