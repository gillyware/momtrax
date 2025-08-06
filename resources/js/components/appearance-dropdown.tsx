import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Appearance, useAppearance } from '@/hooks/use-appearance';
import { cn } from '@/lib/utils';
import { ChevronDown, Droplet, Flame, Flower2, Leaf, LucideIcon, Monitor, Moon, Palette, Sun } from 'lucide-react';
import { HTMLAttributes, useCallback, useMemo } from 'react';

interface AppearanceTab {
    value: Appearance;
    icon: LucideIcon;
    label: string;
}

export default function AppearanceToggleDropdown({ className = '', ...props }: HTMLAttributes<HTMLDivElement>) {
    const { appearance, updateAppearance } = useAppearance();

    const tabs: AppearanceTab[] = useMemo(
        () => [
            { value: 'theme-mauve', icon: Flower2, label: 'Mauve' },
            { value: 'theme-green', icon: Leaf, label: 'Green' },
            { value: 'theme-purple', icon: Palette, label: 'Purple' },
            { value: 'theme-orange', icon: Flame, label: 'Orange' },
            { value: 'theme-blue', icon: Droplet, label: 'Blue' },
            { value: 'light', icon: Sun, label: 'Light' },
            { value: 'dark', icon: Moon, label: 'Dark' },
            { value: 'system', icon: Monitor, label: 'System' },
        ],
        [],
    );

    const getCurrentTab = useCallback((): AppearanceTab => {
        return tabs.find((tab: AppearanceTab) => tab.value === appearance) as AppearanceTab;
    }, [appearance, tabs]);

    const currentAppearance: AppearanceTab = useMemo(() => getCurrentTab(), [getCurrentTab]);

    return (
        <div className={className} {...props}>
            <DropdownMenu>
                <DropdownMenuTrigger className="w-50" asChild>
                    <Button variant="outline" size="icon" className="rounded-md">
                        <div className="flex w-full flex-row items-center justify-between px-4">
                            <span className="flex items-center gap-2">
                                <currentAppearance.icon className="h-5 w-5" />
                                {currentAppearance.label}
                            </span>

                            <ChevronDown className="s-3 ml-2" />
                        </div>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent className="w-50" align="start">
                    {tabs.map((tab: AppearanceTab) => (
                        <DropdownMenuItem
                            key={tab.value}
                            className={cn('cursor-pointer', appearance === tab.value && 'bg-secondary')}
                            onClick={() => updateAppearance(tab.value)}
                        >
                            <span className="flex items-center gap-2">
                                <tab.icon className="h-5 w-5 text-primary" />
                                {tab.label}
                            </span>
                        </DropdownMenuItem>
                    ))}
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    );
}
