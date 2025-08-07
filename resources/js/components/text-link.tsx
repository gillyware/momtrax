import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { ComponentProps } from 'react';

type LinkProps = ComponentProps<typeof Link>;

export default function TextLink({ className = '', children, ...props }: LinkProps) {
    return (
        <Button className="p-0" variant="link" asChild>
            <Link
                className={cn(
                    'text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! active:scale-95 dark:decoration-neutral-500',
                    className,
                )}
                {...props}
            >
                {children}
            </Link>
        </Button>
    );
}
