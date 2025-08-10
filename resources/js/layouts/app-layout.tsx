import { AppContent } from '@/components/app-content';
import { AppFooter } from '@/components/app-footer';
import { AppHeader } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, breadcrumbs }: AppLayoutProps) => (
    <AppShell>
        <AppHeader breadcrumbs={breadcrumbs} />
        <AppContent>{children}</AppContent>
        <AppFooter />
    </AppShell>
);
