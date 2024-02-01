import React, {lazy, LazyExoticComponent, ComponentType} from 'react'

const FieldComponents: DynamicImportComponentObjectName = {
  'Field.Number': lazy(() => import('@/Modules/LirCrud/Components/Field/Number')) ,
  'Field.Text': lazy(() => import('@/Modules/LirCrud/Components/Field/Text')),
  'Columns.Section': lazy(() => import('@/Modules/LirCrud/Components/Column/Text')),
}

export {FieldComponents}