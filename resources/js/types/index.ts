import { Country } from './index';
import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    firstname: string;
    lastname: string;
    email: string;
    telephone: string;
    country_id: number;
    country: Country;
    city: string;
    address: string;
    postal_code: string;
    mobile_phone: string;
    piece_number: string;
    identifiant: string;
    picture: string;
    balance: number;
    is_admin: boolean;
    created_at: string;
    updated_at: string;
}

export interface Country {
    id: number;
    name: string;
    code: string;
    flag: string;
    created_at: string;
    updated_at: string;
}

export interface Loan {
    id: number;
    user_id: number;
    rib_code: string;
    amount: number;
    created_at: string;
    updated_at: string;
    user: User;
}

export interface LoanTransaction {
    id: number;
    label: string;
    user_id: number;
    amount: number;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
