import { Form, Input } from 'antd';


export default ({ name }: {name: string}) => {
  return (
    <Form.Item name={name} label={'te'}>
      <Input />
    </Form.Item>
  );
};