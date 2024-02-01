import {useEffect, useState} from 'react';
import { Button, Form } from 'antd';
import type {ButtonProps} from 'antd/lib/button/button';


interface FormButton {
  form: any,
  watchProps?: Array<string>|string,
  buttonProps?: ButtonProps,
  label: string,
}

/** Antd Form */
export default ({ form,  watchProps, buttonProps, label }: FormButton) => {
    const [submittable, setSubmittable] = useState(false)
    const defaultButton: ButtonProps = {
      type: 'primary',
      htmlType: 'submit',
      disabled: ! submittable,
    }
    // Watch value
    const values = Form.useWatch(watchProps ?? [], form)
    
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
      <Button
        {...{
          ...defaultButton,
          ...buttonProps
        }}
      >
        {label ?? 'Submit'}
      </Button>
    );
  };