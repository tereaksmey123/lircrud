import {useEffect, useState} from 'react';
import { Button, Form } from 'antd';

/** Antd Form */
export default ({ form,  watchProps, buttonProps }) => {
    const [submittable, setSubmittable] = useState(false)
    const {label, props} = buttonProps ?? {}
    const button = {
      type: 'primary',
      htmlType: 'submit',
      disabled: ! submittable,
      ...props
    }
    // Watch value
    const values = Form.useWatch(watchProps && watchProps.length ? watchProps : [], form)
    
    useEffect(() => {
      form
        .validateFields({ validateOnly: true })
        .then(
          () => {
            setSubmittable(true);
          },
          () => {
            setSubmittable(false);
          },
        );
    }, [values]);
    return (
      <Button {...button} >
        {label ?? 'Submit'}
      </Button>
    );
  };