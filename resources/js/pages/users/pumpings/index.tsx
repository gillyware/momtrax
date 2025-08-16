import HeadingSmall from '@/components/heading-small';
import AppLayout from '@/layouts/app-layout';
import PumpingsLayout from '@/layouts/pumpings-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pumpings',
        href: '/pumpings',
    },
];

export default function PumpingIndex() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Pumpings" />

            <PumpingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Pumpings" description="Take stock of your pumpings" />
                </div>
            </PumpingsLayout>
        </AppLayout>
    );
}
