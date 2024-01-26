type ToSetFieldsError = (
  errors: object,
  fieldNames: Array<string|number>,
  form?: any
) => void|Array<object>

const toSetFieldsError: ToSetFieldsError = (errors, fieldNames, form = false) => {
  // format error into ant design setFields API
  // [ { name: 'field name', errors: ['error message'] } ]
  let errorNameFromServer = Object.entries(errors).filter(
      v =>  Object.keys(fieldNames).includes(v[0] ?? '')
    ).map(v => ({
      name: v[0],
      errors: Array.isArray(v[1]) ? v[1] : [v[1]]
    }))
  
  if (! form) {
    return errorNameFromServer
  }

  if (errorNameFromServer.length) {
    form.setFields(errorNameFromServer);
  }
}

export {
  toSetFieldsError
}