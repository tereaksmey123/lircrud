import { AxiosInstance } from 'axios';

declare global {
    interface Window {
        axios: AxiosInstance;
    }
    // var appUrl: string;
    // var baseUrl: string;
    // var appConfig: {
    //     locale: string
    //     fallback_locale: string
    // };
}
