import {resolvePageComponent as resolvePage} from 'laravel-vite-plugin/inertia-helpers'
import React from 'react'
/**,
 * resolvePageComponent
 *
 * LirCrud::Login = load from module
 *
 * ::Login = load from root
 *
 * Login = load from root
 */
async function resolvePageComponent(name: string): Promise<any> {
  // sample:
  // LirCrud::Login = load from module
  // ::Login = load from root
  // Login = load from root
  const [path, module] = name.split('::')

  // let page
  
  // due to vite dynamic import not support variable, only file name variable is allow.
  if (module && path) {
    return await resolvePage(
      `/Modules/${path}/resources/assets/js/Pages/${module}.tsx`,
      import.meta.glob('/Modules/*/resources/assets/js/Pages/**/*.tsx')
    )
  }
  
  return await resolvePage(
    `/resources/js/Pages/${path}.tsx`,
    import.meta.glob('/resources/js/Pages/**/*.tsx')
  )
}

export default resolvePageComponent
