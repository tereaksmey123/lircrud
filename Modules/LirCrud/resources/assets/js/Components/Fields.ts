import React, {lazy} from 'react'

interface FieldComponents {
  [key: string]: any
}

const FieldComponents: FieldComponents = {
  'Field.Number': lazy(() => import('@/Modules/LirCrud/Components/Field/Number')),
  'Field.Text': lazy(() => import('@/Modules/LirCrud/Components/Field/Text')),
}

export {FieldComponents}