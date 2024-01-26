import { useState, useEffect } from "react";

type UseLocalStorage = (key: string, defaultValue: any) => Array<any>

const useLocalStorage: UseLocalStorage = (key, defaultValue) => {
  const [value, setValue] = useState(() => {
    let currentValue;

    try {
      currentValue = JSON.parse(
        localStorage.getItem(key) ?? String(defaultValue)
      );
    } catch (error) {
      // console.log(error)
      currentValue = defaultValue;
    }

    return currentValue;
  });

  useEffect(() => {
    localStorage.setItem(key, JSON.stringify(value));
  }, [value, key]);

  return [value, setValue];
};

export {useLocalStorage};