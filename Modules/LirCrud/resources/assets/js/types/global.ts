import React from 'react'

declare global {
    interface ReactChildrenProps {
        children: React.ReactNode
    }

    interface DynamicImportComponentObjectName {
        // TO DO LIST
        // as currently not able to define correct type of it usage
        // need to skip type error by set it to: any
        [key: string]: any
    }
}