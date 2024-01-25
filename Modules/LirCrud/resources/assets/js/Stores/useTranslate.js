
import { create } from 'zustand'
import { persist } from "zustand/middleware";
import useSWRImmutable from 'swr/immutable'
import axios from 'axios'

const useTranslate = create(
  persist(
    (set, get) => ({
      locale: config?.locale ?? config?.fallback_locale ?? 'en_GB',

      setLocale: (locale) => set({locale}),
      // laravel
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
      // i18n
      t: (key, replace = false) => get().__(key, replace),
      // laravel
      trans: (key, replace = false) => get().__(key, replace)
    }),
    {name: appName + '_lircrudTranslateStore'},
  ),
)

export {useTranslate}