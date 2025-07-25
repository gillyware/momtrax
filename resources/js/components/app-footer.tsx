import { Link } from '@inertiajs/react';

interface FooterItem {
    title: string;
    href: string;
}

const footerItems: FooterItem[] = [
    {
        title: 'Terms of Service',
        href: '/terms',
    },
    {
        title: 'Privacy',
        href: '/privacy',
    },
];

export function AppFooter() {
    return (
        <div className="flex flex-row items-center justify-start gap-4 border-b border-sidebar-border/80 p-4">
            {footerItems.map((item) => (
                <Link key={item.title} href={item.href}>
                    {item.title}
                </Link>
            ))}
        </div>
    );
}
