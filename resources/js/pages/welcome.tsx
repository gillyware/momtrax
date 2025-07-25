import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import landingText from '@/lib/lang/en/landing';
import { Head, Link } from '@inertiajs/react';
import { Baby, Ban, Droplet, LucideIcon, Moon, NotebookText, Ruler, Share2, Toilet, Utensils } from 'lucide-react';

export default function Welcome() {
    type Tile = {
        title: string;
        icon: LucideIcon;
        description: string;
    };

    const tiles: Tile[] = [
        {
            title: landingText.tiles.pumpingTrackingText.title,
            icon: Droplet,
            description: landingText.tiles.pumpingTrackingText.description,
        },
        {
            title: landingText.tiles.childProfilesText.title,
            icon: Baby,
            description: landingText.tiles.childProfilesText.description,
        },
        {
            title: landingText.tiles.feedingTrackingText.title,
            icon: Utensils,
            description: landingText.tiles.feedingTrackingText.description,
        },
        {
            title: landingText.tiles.sleepTrackingText.title,
            icon: Moon,
            description: landingText.tiles.sleepTrackingText.description,
        },
        {
            title: landingText.tiles.diaperTrackingText.title,
            icon: Toilet,
            description: landingText.tiles.diaperTrackingText.description,
        },
        {
            title: landingText.tiles.growthTrackingText.title,
            icon: Ruler,
            description: landingText.tiles.growthTrackingText.description,
        },
        {
            title: landingText.tiles.noAdsText.title,
            icon: Ban,
            description: landingText.tiles.noAdsText.description,
        },
    ];

    const premiumTiles: Tile[] = [
        {
            title: landingText.premiumTiles.profileSharingText.title,
            icon: Share2,
            description: landingText.premiumTiles.profileSharingText.description,
        },
        {
            title: landingText.premiumTiles.notebookText.title,
            icon: NotebookText,
            description: landingText.premiumTiles.notebookText.description,
        },
    ];

    return (
        <AppLayout>
            <Head title="Your Mom Life, Simplified">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex w-full grow flex-col items-center">
                <div>MomTrax</div>
                <div className="flex w-full flex-col items-center gap-4 p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">MomTrax: Built for You</div>
                    <div className="text-center text-sm">Track your mom moments with a tool that bends to your needs.</div>
                    <div className="flex flex-row flex-wrap items-center justify-center gap-6 p-4">
                        <Button className="rounded-md" variant="default" asChild>
                            <Link href="#features">Explore Features</Link>
                        </Button>
                        <Button className="rounded-md" variant="ghost" asChild>
                            <Link href="#premium">Go Premium</Link>
                        </Button>
                        <Button className="rounded-md" variant="secondary" asChild>
                            <Link href="#download">Get It Free on iOS</Link>
                        </Button>
                    </div>
                </div>
                <div className="flex w-full flex-col items-center bg-zinc-400 p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">A Day in Your Life</div>
                    <div className="text-center text-sm italic">Take back your day with tools that work as hard as you do.</div>
                </div>
                <div className="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:max-w-4xl lg:grid-cols-3">
                    {tiles.map((tile: Tile) => (
                        <Card key={tile.title} className="flex h-full min-h-[140px] flex-col transition-shadow hover:shadow-md">
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-lg font-medium">{tile.title}</CardTitle>
                                {<tile.icon className="h-5 w-5 text-primary" />}
                            </CardHeader>
                            <CardContent className="flex-1">
                                <p className="text-sm text-muted-foreground">{tile.description}</p>
                            </CardContent>
                        </Card>
                    ))}
                    {premiumTiles.map((tile: Tile) => (
                        <Card key={tile.title} className="flex h-full min-h-[140px] flex-col transition-shadow hover:shadow-md">
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-lg font-medium">{tile.title}</CardTitle>
                                {<tile.icon className="h-5 w-5 text-primary" />}
                            </CardHeader>
                            <CardContent className="flex-1">
                                <p className="text-sm text-muted-foreground">{tile.description}</p>
                            </CardContent>
                        </Card>
                    ))}
                </div>
                <div className="flex w-full items-center justify-center p-6 md:max-w-4xl">
                    <div className="flex w-full flex-col items-center justify-center gap-4 rounded-lg border p-4">
                        <div className="text-lg">Personalize Your Experience</div>
                        <div className="text-md">Cuts the noise by hiding unused tools, focusing only on what your family needs.</div>
                    </div>
                </div>
                <div className="flex flex-col items-center justify-center gap-6 p-6">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">Upgrade to Premium</div>
                    <div className="text-md text-center">Unlock the full MomTrax experience.</div>
                    <Card className="flex flex-col transition-shadow hover:shadow-md">
                        <CardHeader className="flex flex-row flex-wrap items-center justify-between gap-2 space-y-0">
                            <CardTitle className="text-center text-lg">{'MomTrax Premium'}</CardTitle>
                            <CardTitle className="text-lg font-medium">{'$4.99/month or $49.99/year'}</CardTitle>
                        </CardHeader>
                        <CardContent className="flex flex-1 flex-col items-start justify-center gap-4 sm:gap-6">
                            <p className="text-sm text-muted-foreground">{landingText.premiumTiles.profileSharingText.description}</p>
                            <div className="flex w-full flex-row justify-start sm:justify-center">
                                <Button className="rounded-full">Go Premium</Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>
                <div className="flex w-full flex-col items-center gap-6 bg-zinc-400 p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">Ready for a Helping Hand?</div>
                    <div className="text-center text-sm">Get MomTrax Free on iOS</div>
                    <Link href="https://apps.apple.com/us/app/momtrax/id6741926859">
                        <Button>iOS Image</Button>
                    </Link>
                </div>
                <div></div>
            </div>
        </AppLayout>
    );
}
