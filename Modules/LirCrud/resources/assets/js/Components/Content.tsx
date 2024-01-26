import {useToken} from '@/Modules/LirCrud/Hooks/useAntdToken'

import { Col } from 'antd';


export default ({ children }: Readonly<ReactChildrenProps>) => {
  const { token } = useToken()

  return (
    <Col span={24} style={{background: token.colorBgContainer}} className={'p-3'}>
      {children}
    </Col>
  );
};