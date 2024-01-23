import path from 'path';

/**
 * importFromJs
 *
 * @param {String} fileName - with extension
 * @returns {object}
 */
const importFromJs = async (fileName) => {
  let componentAlias = {}
  
  // due to Vite dynamic import limitation, only file name variable is allowed
  try {
    const moduleAlias = await import(path.join(
      __dirname,
      '../../../../../../../Modules/LirCrud/alias/'+ fileName
    )).then(m => m.default)

    componentAlias = {...componentAlias, ...moduleAlias}
  } catch (error) {
    
  }

  try {
    const rootAlias = await import(path.join(
        __dirname,
        '../../../../../../../storage/app/lircrud/alias/' + fileName
    )).then(m => m.default)

    componentAlias = {...componentAlias, ...rootAlias}

  } catch (error) {}

  return componentAlias
}

/**
 * combine
 *
 * @param {String|Array} fileName - with extension
 * @returns {object}
 */
const combine = async (fileName = 'component.js') => {
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
 * lircrudAlias
 *
 * @param {Array} fileNames - with extension
 * @returns {object}
 */
const alias = (fileNames = []) => {
  return combine([
    ...[
      'component.js',
      'helpers.js',
      'admin-layout.js'
    ],
    ...fileNames
  ])
}

export default alias;
