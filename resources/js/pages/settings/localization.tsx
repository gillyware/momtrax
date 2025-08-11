import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings-layout';
import { cn } from '@/lib/utils';
import { SharedData, UserSetting, type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';
import { ChevronDown } from 'lucide-react';
import { useEffect, useMemo } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Localization',
        href: '/settings/localization',
    },
];

interface LocalizationForm {
    timezone: string;
}

type TimezoneItem = string;

export default function Localization() {
    const { auth, timezoneNames } = usePage<SharedData>().props;
    const settings: UserSetting = useMemo(() => auth.settings as UserSetting, [auth]);

    const { data, setData, patch, errors, processing } = useForm<Required<LocalizationForm>>({
        timezone: settings.timezone,
    });

    const currentTimezone: TimezoneItem = useMemo(() => {
        return (timezoneNames as TimezoneItem[]).find((timezoneName: TimezoneItem) => timezoneName === settings.timezone) as TimezoneItem;
    }, [timezoneNames, settings]);

    useEffect(() => {
        patch(route('localization.update'), {
            preserveScroll: true,
        });
    }, [data, patch]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Localization" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Localization" description="Update your localization settings" />

                    <form className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="timezone">Timezone</Label>

                            <DropdownMenu>
                                <DropdownMenuTrigger disabled={processing} asChild>
                                    <Button variant="outline" className="w-64 justify-between rounded-md">
                                        <span>{currentTimezone}</span>
                                        <ChevronDown className="ml-2" />
                                    </Button>
                                </DropdownMenuTrigger>

                                <DropdownMenuContent
                                    className="max-h-72 w-64 overflow-y-auto"
                                    side="bottom"
                                    align="start"
                                    sideOffset={6}
                                    collisionPadding={12}
                                >
                                    {(timezoneNames as TimezoneItem[]).map((timezone) => (
                                        <DropdownMenuItem
                                            key={timezone}
                                            disabled={processing}
                                            className={cn('cursor-pointer', currentTimezone === timezone && 'bg-secondary')}
                                            onClick={() => setData('timezone', timezone)}
                                        >
                                            {timezone}
                                        </DropdownMenuItem>
                                    ))}
                                </DropdownMenuContent>
                            </DropdownMenu>

                            <InputError className="mt-2" message={errors.timezone} />
                        </div>
                    </form>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
