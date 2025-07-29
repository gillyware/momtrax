import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { cn } from '@/lib/utils';
import { LucideIcon } from 'lucide-react';

type Tile = {
    title: string;
    icon: LucideIcon;
    description: string;
};

interface FeatureCardProps {
    tile: Tile;
    isPremium?: boolean;
}

export function FeatureCard({ tile, isPremium = false }: FeatureCardProps) {
    return (
        <Card
            key={tile.title}
            className={cn('flex h-full min-h-[140px] flex-col transition-shadow hover:shadow-md', isPremium && 'border-primary bg-muted')}
        >
            <CardHeader className="flex flex-row items-center justify-between gap-4 space-y-0 pb-2">
                <CardTitle className="flex grow flex-row items-center justify-between gap-3 text-lg font-medium">
                    <span>{tile.title}</span>
                    {isPremium && <span className="rounded-md border border-primary bg-secondary px-2 py-1 text-sm">Premium</span>}
                </CardTitle>

                {<tile.icon className="h-5 w-5 text-primary" />}
            </CardHeader>
            <CardContent className="flex-1">
                <p className="text-sm text-muted-foreground">{tile.description}</p>
            </CardContent>
        </Card>
    );
}
