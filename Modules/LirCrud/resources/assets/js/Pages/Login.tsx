import { UserOutlined } from '@ant-design/icons';
import { Form, Input, Layout, Row, Card } from 'antd';
import PlainLayout from "@/lircrud/Layouts/Plain"
import FormButton from '@/lircrud/Components/Button/FormButton'

import {loginAction} from '@/lircrud/Actions/auth'

interface Login {
  rules: {
    username: Array<object>,
    password: Array<object>
  }
}

const Login = ({ rules }: Login) => {
  const [form] = Form.useForm();

  return (
    <Layout>
      <Row justify="center" align="middle" className={'h-dvh'}>
        <Card title="Login">
          <Form
            form={form}
            className={'w-[300px]'}
            size='large'
            onFinish={values => loginAction(values, form)}
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
            <FormButton
              form={form}
              label='Login'
            />
          </Form.Item>
        </Form>
      </Card>
    </Row>
  </Layout>
  );
};

Login.layout = (page: any) => <PlainLayout>{page}</PlainLayout>

export default Login;