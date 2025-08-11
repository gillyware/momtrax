import HeadingSmall from '@/components/heading-small';
import PumpingForm from '@/components/pumpings/pumping-form';
import AppLayout from '@/layouts/app-layout';
import PumpingsLayout from '@/layouts/pumpings-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Pumping',
        href: '/pumpings/new',
    },
];

export default function CreatePumping() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Pumping" />

            <PumpingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Create Pumping" description="Add a new pumping entry" />
                    <PumpingForm />
                </div>
            </PumpingsLayout>
        </AppLayout>
    );
}
