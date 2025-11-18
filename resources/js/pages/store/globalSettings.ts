import { reactive } from 'vue';
import { AppSettings } from '@/types';

const initialSettings: AppSettings = window.AppConfig;

export const useGlobalSettings = reactive(initialSettings);
