import AppLayout from '@/layouts/app-layout';
import { type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import {Link} from "@inertiajs/react";

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <AppLayout>
            <Head title="Your Mom Life, Simplified">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex w-full grow flex-col items-center">
                <div>
                    MomTrax
                </div>
                <div className="p-4 w-full flex flex-col gap-4 items-center w-full">
                    <div className="text-center text-[32px] sm:text-[48px] font-bold">MomTrax: Built for You</div>
                    <div className="text-sm text-center">Track your mom moments with a tool that bends to your needs.</div>
                    <div className="p-4 flex flex-col gap-4 sm:gap-6 items-center justify-center sm:flex-row">
                        <Button clasName="rounded-md" variant="default" asChild><Link href="#features">Explore Features</Link></Button>
                        <Button clasName="rounded-md" variant="ghost" asChild><Link href="#premium">Go Premium</Link></Button>
                        <Button clasName="rounded-md" variant="secondary" asChild><Link href="#download">Get It Free on iOS</Link></Button>
                    </div>
                </div>
                <div className="w-full p-4 flex flex-col items-center bg-zinc-200">
                    <div className=" text-center text-[32px] sm:text-[48px] font-bold">A Day in Your Life</div>
                    <div className="text-sm italic text-center">Take back your day with tools that work as hard as you do.</div>
                </div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </AppLayout>
    );
}
