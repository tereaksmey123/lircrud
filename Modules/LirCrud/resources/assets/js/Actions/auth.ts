import { router } from '@inertiajs/react'
import {toSetFieldsError} from '@/Modules/LirCrud/helpers/Antd/validate-antd'

const logoutAction = () => {
  router.delete('/admin/logout')
}

type LoginAction = (
  values: any,
  form?: any
) => void

const loginAction: LoginAction = (values, form = false) => {
  router.post(`${appUrl}/admin/login`, values, {
      onError: (errors) => {
        toSetFieldsError(errors, form.getFieldsValue(true), form)
      },
  })
}

export {
  logoutAction,
  loginAction
}