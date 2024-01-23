import {lazy} from 'react'

const FieldComponents = {
  'Field.Number': lazy(() => import('@/Modules/LirCrud/Components/Field/Number')),
  'Field.Text': lazy(() => import('@/Modules/LirCrud/Components/Field/Text')),
}

export {FieldComponents}