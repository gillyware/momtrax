import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function image(filename: string, extension: string = 'png') {
    return `/assets/images/${filename}.${extension}`;
}
