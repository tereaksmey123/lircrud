import { router } from '@inertiajs/react'

const logoutAction = () => {
    router.delete('/admin/logout')
}

const loginAction = () => {

}

export {
    logoutAction,
    loginAction
}