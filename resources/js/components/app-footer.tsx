import { Link } from '@inertiajs/react';

interface FooterItem {
    title: string;
    href: string;
}

const footerItems: FooterItem[] = [
    { title: 'Terms of Service', href: '/terms' },
    { title: 'Privacy', href: '/privacy' },
];

export function AppFooter() {
    return (
        <div className="flex w-full flex-row justify-center">
            <div className="flex grow flex-row items-center justify-center gap-4 border-t border-sidebar-border/80 p-4 sm:justify-start md:max-w-7xl">
                {footerItems.map((item) => (
                    <Link className="hover:underline active:scale-95" key={item.title} href={item.href}>
                        {item.title}
                    </Link>
                ))}
            </div>
        </div>
    );
}
