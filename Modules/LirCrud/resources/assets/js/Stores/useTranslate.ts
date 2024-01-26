
import { create } from 'zustand'
import { persist } from "zustand/middleware";
import useSWRImmutable from 'swr/immutable'
import axios from 'axios'

type TranslateFunction = (key: string, replace?: false) => string

interface UseTranslate {
  locale: string,
  __: TranslateFunction,
  t: TranslateFunction,
  trans: TranslateFunction,
  setLocale: (locale: string) => void
}

const useTranslate = create<UseTranslate>()(
  persist(
    (set, get) => ({
      locale: appConfig?.locale ?? appConfig?.fallback_locale ?? 'en_GB',

      setLocale: (locale) => set({locale}),
      
      __: (key, replace = false) => {
        const { data } = useSWRImmutable(
            [baseUrl + '/api/locales', get().locale],
            ([url, locale]) => axios.get(url).then(res => res.data),
            { revalidateOnMount: true }
        )

        // when not found return last string after dot

        // default.reserve_at = reserve_at
        // modules.lircrud.default.reserve_at = reserve_at
        // reserve_at = reserve_at
        const guessValue = key.split('.').reverse()[0] ?? key

        // wrap with try cache to avoid undefine index during reduce() as request is not done yet.
        try {
            return key.split('.').reduce((acc, curr) => acc[curr], data?.data) ?? guessValue
        } catch (error) {
            return guessValue
        }
      },

      t: (key, replace = false) => get().__(key, replace),
      
      trans: (key, replace = false) => get().__(key, replace)
    }),
    {name: appName + '_lircrudTranslateStore'},
  ),
)

export {useTranslate}