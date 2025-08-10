import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { cn } from '@/lib/utils';
import { SharedData, UserSetting, type BreadcrumbItem } from '@/types';
import { HeightUnit, MilkUnit, WeightUnit } from '@/types/enums';
import { Head, useForm, usePage } from '@inertiajs/react';
import { ChevronDown } from 'lucide-react';
import { useEffect, useMemo } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Units',
        href: '/settings/units',
    },
];

interface UnitsForm {
    milk_unit: MilkUnit;
    height_unit: HeightUnit;
    weight_unit: WeightUnit;
}

interface MilkUnitItem {
    value: MilkUnit;
    label: string;
}

interface HeightUnitItem {
    value: HeightUnit;
    label: string;
}

interface WeightUnitItem {
    value: WeightUnit;
    label: string;
}

export default function Units() {
    const { auth } = usePage<SharedData>().props;
    const settings: UserSetting = useMemo(() => auth.user?.settings as UserSetting, [auth]);

    const { data, setData, patch, errors, processing } = useForm<Required<UnitsForm>>({
        milk_unit: settings.milk_unit,
        height_unit: settings.height_unit,
        weight_unit: settings.weight_unit,
    });

    const milkUnitItems: MilkUnitItem[] = useMemo(
        () => [
            { value: 'ml', label: 'mL' },
            { value: 'oz', label: 'US fl oz' },
        ],
        [],
    );

    const heightUnitItems: HeightUnitItem[] = useMemo(
        () => [
            { value: 'in', label: 'in' },
            { value: 'cm', label: 'cm' },
        ],
        [],
    );

    const weightUnitItems: WeightUnitItem[] = useMemo(
        () => [
            { value: 'lbs', label: 'lbs' },
            { value: 'kg', label: 'kg' },
        ],
        [],
    );

    const currentMilkUnit: MilkUnitItem = useMemo(() => {
        return milkUnitItems.find((unitItem) => unitItem.value === settings.milk_unit) as MilkUnitItem;
    }, [milkUnitItems, settings]);

    const currentHeightUnit: HeightUnitItem = useMemo(() => {
        return heightUnitItems.find((unitItem) => unitItem.value === settings.height_unit) as HeightUnitItem;
    }, [heightUnitItems, settings]);

    const currentWeightUnit: WeightUnitItem = useMemo(() => {
        return weightUnitItems.find((unitItem) => unitItem.value === settings.weight_unit) as WeightUnitItem;
    }, [weightUnitItems, settings]);

    useEffect(() => {
        patch(route('units.update'), {
            preserveScroll: true,
        });
    }, [data, patch]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Preferred units settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Preferred units" description="Update your preferred units" />

                    <form className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="milk_unit">Milk unit</Label>

                            <DropdownMenu>
                                <DropdownMenuTrigger disabled={processing} className="w-50" asChild>
                                    <Button variant="outline" size="icon" className="rounded-md">
                                        <div className="flex w-full flex-row items-center justify-between px-4">
                                            <span className="items-center">{currentMilkUnit.label}</span>
                                            <ChevronDown className="s-3 ml-2" />
                                        </div>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent className="w-50" align="start">
                                    {milkUnitItems.map((unitItem: MilkUnitItem) => (
                                        <DropdownMenuItem
                                            disabled={processing}
                                            key={unitItem.value}
                                            className={cn('cursor-pointer', currentMilkUnit.value === unitItem.value && 'bg-secondary')}
                                            onClick={() => setData('milk_unit', unitItem.value)}
                                        >
                                            <span className="items-center">{unitItem.label}</span>
                                        </DropdownMenuItem>
                                    ))}
                                </DropdownMenuContent>
                            </DropdownMenu>

                            <InputError className="mt-2" message={errors.milk_unit} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="height_unit">Height unit</Label>

                            <DropdownMenu>
                                <DropdownMenuTrigger disabled={processing} className="w-50" asChild>
                                    <Button variant="outline" size="icon" className="rounded-md">
                                        <div className="flex w-full flex-row items-center justify-between px-4">
                                            <span className="items-center">{currentHeightUnit.label}</span>
                                            <ChevronDown className="s-3 ml-2" />
                                        </div>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent className="w-50" align="start">
                                    {heightUnitItems.map((unitItem: HeightUnitItem) => (
                                        <DropdownMenuItem
                                            disabled={processing}
                                            key={unitItem.value}
                                            className={cn('cursor-pointer', currentHeightUnit.value === unitItem.value && 'bg-secondary')}
                                            onClick={() => setData('height_unit', unitItem.value)}
                                        >
                                            <span className="items-center">{unitItem.label}</span>
                                        </DropdownMenuItem>
                                    ))}
                                </DropdownMenuContent>
                            </DropdownMenu>

                            <InputError className="mt-2" message={errors.height_unit} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="weight_unit">Weight unit</Label>

                            <DropdownMenu>
                                <DropdownMenuTrigger disabled={processing} className="w-50" asChild>
                                    <Button variant="outline" size="icon" className="rounded-md">
                                        <div className="flex w-full flex-row items-center justify-between px-4">
                                            <span className="items-center">{currentWeightUnit.label}</span>
                                            <ChevronDown className="s-3 ml-2" />
                                        </div>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent className="w-50" align="start">
                                    {weightUnitItems.map((unitItem: WeightUnitItem) => (
                                        <DropdownMenuItem
                                            disabled={processing}
                                            key={unitItem.value}
                                            className={cn('cursor-pointer', currentWeightUnit.value === unitItem.value && 'bg-secondary')}
                                            onClick={() => setData('weight_unit', unitItem.value)}
                                        >
                                            <span className="items-center">{unitItem.label}</span>
                                        </DropdownMenuItem>
                                    ))}
                                </DropdownMenuContent>
                            </DropdownMenu>

                            <InputError className="mt-2" message={errors.weight_unit} />
                        </div>
                    </form>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
