import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <AppLayout>
            <Head title="Your Mom Life, Simplified">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex w-full grow flex-col items-center">
                <div>MomTrax</div>
                <div className="flex w-full flex-col items-center gap-4 p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[48px]">MomTrax: Built for You</div>
                    <div className="text-center text-sm">Track your mom moments with a tool that bends to your needs.</div>
                    <div className="flex flex-col items-center justify-center gap-4 p-4 sm:flex-row sm:gap-6">
                        <Button clasName="rounded-md" variant="default" asChild>
                            <Link href="#features">Explore Features</Link>
                        </Button>
                        <Button clasName="rounded-md" variant="ghost" asChild>
                            <Link href="#premium">Go Premium</Link>
                        </Button>
                        <Button clasName="rounded-md" variant="secondary" asChild>
                            <Link href="#download">Get It Free on iOS</Link>
                        </Button>
                    </div>
                </div>
                <div className="flex w-full flex-col items-center bg-zinc-200 p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[48px]">A Day in Your Life</div>
                    <div className="text-center text-sm italic">Take back your day with tools that work as hard as you do.</div>
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
