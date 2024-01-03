import {resolvePageComponent as resolvePage} from 'laravel-vite-plugin/inertia-helpers'

/**
 * resolvePageComponent
 *
 * @param {string} name without extension
 * @returns 
 */
async function resolvePageComponent(name) {
  // due to destruct array, variable name might make confusing
  // sample:
  // LirCrud::Login = load from module
  // ::Login = load from root
  // Login = load from root
  const [path, module] = name.split('::')

  let page
  
  // due to vite dynamic import not support variable, only file name variable is allow.
  if (module && path) {
    page = await resolvePage(
      `/Modules/${path}/resources/assets/js/Pages/${module}.jsx`,
      import.meta.glob('/Modules/*/resources/assets/js/Pages/**/*.jsx')
    )
  } else {
    page = await resolvePage(
      `/resources/js/Pages/${path}.jsx`,
      import.meta.glob('/resources/js/Pages/**/*.jsx')
    )
  }

  return page
}

export default resolvePageComponent
