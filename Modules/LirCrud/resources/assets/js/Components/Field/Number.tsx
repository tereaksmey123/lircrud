import { Form, InputNumber } from 'antd';


export default ({ name, rules }: {name: string, rules: Array<object>}) => {
  return (
    <Form.Item name={name} rules={rules} label={(<span></span>)}>
      <InputNumber />
    </Form.Item>
  );
};