import { router } from '@inertiajs/react'
import {ini} from 'flowbite-react'

router.on('success', (event) => {
  initFlowbite()
})
// import 'flowbite';