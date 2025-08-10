import { Appearance } from '@/hooks/use-appearance';
import { HeightUnit, MilkUnit, WeightUnit } from '@/types/enums';
import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User | null;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    uuid: string;
    first_name: string;
    last_name: string;
    nickname: string;
    email: string;
    avatar?: string;
    created_at: string;
    updated_at: string;
    settings: UserSetting;
    [key: string]: unknown;
}

export interface UserSetting {
    id: number;
    user_id: int;
    milk_unit: MilkUnit;
    height_unit: HeightUnit;
    weight_unit: WeightUnit;
    appearance: Appearance;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}
