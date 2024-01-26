import path from 'path';

const importFromJs = async (fileName: string): Promise<object> => {
  let componentAlias = {}
  
  // due to Vite dynamic import limitation, only file name variable is allowed
  try {
    const moduleAlias = await import(path.join(
      __dirname,
      '../../../../../../../Modules/LirCrud/alias/'+ fileName
    )).then(m => m.default)

    componentAlias = {...componentAlias, ...moduleAlias}
  } catch (error) {}

  try {
    const rootAlias = await import(path.join(
        __dirname,
        '../../../../../../../resources/js/lircrud/alias/' + fileName
    )).then(m => m.default)

    componentAlias = {...componentAlias, ...rootAlias}

  } catch (error) {}

  return componentAlias
}

const combine = async (fileName: string | Array<string> = 'component.js'): Promise<object> => {
  let componentAlias = {}

  if (Array.isArray(fileName)) {
    for (const name of fileName) {
      let alias = await importFromJs(name).then(res => res)

      componentAlias = {...componentAlias, ...alias}
    }
  } else {
    const alias = await importFromJs(fileName).then(res => res)

    componentAlias = {...componentAlias, ...alias}
  }
  
  return componentAlias;
}

/**
 * Registered alias
 * - list in module: Modules/LirCrud/alias
 * - list that allow to add or override: resources/js/lircrud/alias
 *   - higher priority than module list as it able to override if same key
 */
const alias = async (fileNames: Array<string> = []) => {
  return combine([
    ...[
      'action.js',
      'component.js',
      // 'helper.js',
      'admin-layout.js',
      'store.js'
    ],
    ...fileNames
  ])
}

export {alias};
