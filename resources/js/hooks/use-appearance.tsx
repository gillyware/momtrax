import { useCallback, useEffect, useState } from 'react';

export type Appearance = 'light' | 'dark' | 'system' | 'theme-green' | 'theme-purple' | 'theme-orange' | 'theme-blue' | 'theme-mauve';

const prefersDark = () => {
    if (typeof window === 'undefined') {
        return false;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches;
};

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const applyTheme = (appearance: Appearance) => {
    if (appearance === 'system') {
        appearance = prefersDark() ? 'dark' : 'light';
    }

    const classList = document.documentElement.classList;

    for (const cls of Array.from(classList)) {
        if (cls === 'light' || cls === 'dark' || cls === 'system' || cls.startsWith('theme-')) {
            classList.remove(cls);
        }
    }

    classList.add(appearance);
};

export function initializeTheme() {
    const savedAppearance = (localStorage.getItem('appearance') as Appearance) || 'theme-mauve';

    applyTheme(savedAppearance);
}

export function useAppearance() {
    const [appearance, setAppearance] = useState<Appearance>('theme-mauve');

    const updateAppearance = useCallback((mode: Appearance) => {
        setAppearance(mode);

        // Store in localStorage for client-side persistence...
        localStorage.setItem('appearance', mode);

        // Store in cookie for SSR...
        setCookie('appearance', mode);

        applyTheme(mode);
    }, []);

    useEffect(() => {
        const savedAppearance = localStorage.getItem('appearance') as Appearance | null;
        updateAppearance(savedAppearance || 'theme-mauve');
    }, [updateAppearance]);

    return { appearance, updateAppearance } as const;
}
