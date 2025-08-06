import { FeatureCard } from '@/components/landing/feature-card';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Mailto } from '@/components/ui/mailto';
import AppLayout from '@/layouts/app-layout';
import landingText from '@/lib/lang/en/landing';
import { image } from '@/lib/utils';
import { Head, Link } from '@inertiajs/react';
import { Baby, Ban, Droplet, LucideIcon, Moon, NotebookText, Ruler, Share2, Toilet, Utensils } from 'lucide-react';
import React from 'react';

type Tile = {
    title: string;
    icon: LucideIcon;
    description: string;
};

export default function Welcome() {
    const tiles: Tile[] = [
        {
            title: landingText.features.tiles.pumpingTrackingText.title,
            icon: Droplet,
            description: landingText.features.tiles.pumpingTrackingText.description,
        },
        {
            title: landingText.features.tiles.childProfilesText.title,
            icon: Baby,
            description: landingText.features.tiles.childProfilesText.description,
        },
        {
            title: landingText.features.tiles.feedingTrackingText.title,
            icon: Utensils,
            description: landingText.features.tiles.feedingTrackingText.description,
        },
        {
            title: landingText.features.tiles.sleepTrackingText.title,
            icon: Moon,
            description: landingText.features.tiles.sleepTrackingText.description,
        },
        {
            title: landingText.features.tiles.diaperTrackingText.title,
            icon: Toilet,
            description: landingText.features.tiles.diaperTrackingText.description,
        },
        {
            title: landingText.features.tiles.growthTrackingText.title,
            icon: Ruler,
            description: landingText.features.tiles.growthTrackingText.description,
        },
        {
            title: landingText.features.tiles.noAdsText.title,
            icon: Ban,
            description: landingText.features.tiles.noAdsText.description,
        },
    ];

    const premiumTiles: Tile[] = [
        {
            title: landingText.features.premiumTiles.profileSharingText.title,
            icon: Share2,
            description: landingText.features.premiumTiles.profileSharingText.description,
        },
        {
            title: landingText.features.premiumTiles.notebookText.title,
            icon: NotebookText,
            description: landingText.features.premiumTiles.notebookText.description,
        },
    ];

    return (
        <AppLayout>
            <Head title={landingText.title} />
            <div className="flex w-full grow flex-col items-center">
                <div className="flex w-full flex-col items-center gap-4 bg-secondary p-4">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">{landingText.buttonContainer.appName}</div>
                    <div className="text-md text-center">{landingText.buttonContainer.subHeader}</div>
                    <div className="flex flex-row flex-wrap items-center justify-center gap-6 p-4">
                        <Button className="rounded-md" variant="default" asChild>
                            <Link href="#features">{landingText.buttonContainer.exploreFeatures}</Link>
                        </Button>
                        <Button className="rounded-md" variant="outline" asChild>
                            <Link href="#premium">{landingText.buttonContainer.goPremium}</Link>
                        </Button>
                        <Button className="rounded-md" variant="tertiary" asChild>
                            <Link href="#download">{landingText.buttonContainer.download}</Link>
                        </Button>
                    </div>
                </div>
                <div id="features" className="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:max-w-5xl xl:grid-cols-3">
                    {tiles.map((tile: Tile) => (
                        <FeatureCard key={tile.title} tile={tile} />
                    ))}
                    {premiumTiles.map((tile: Tile) => (
                        <FeatureCard key={tile.title} tile={tile} isPremium />
                    ))}
                </div>
                <div className="flex w-full items-center justify-center p-6 md:max-w-5xl">
                    <div className="flex w-full flex-col items-center justify-center gap-4 rounded-lg border bg-primary p-4 text-primary-foreground">
                        <div className="text-lg">{landingText.features.personalize.header}</div>
                        <div className="text-md">{landingText.features.personalize.subHeader}</div>
                    </div>
                </div>
                <div id="premium" className="flex w-full flex-col items-center justify-center gap-6 bg-secondary px-6 pt-6 pb-15">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">{landingText.premium.header}</div>
                    <div className="text-md text-center">{landingText.premium.subHeader}</div>
                    <Card className="flex flex-col transition-shadow hover:shadow-md">
                        <CardHeader className="flex flex-row flex-wrap items-center justify-between gap-2 space-y-0">
                            <CardTitle className="text-center text-lg">{landingText.premium.modal.header}</CardTitle>
                            <CardTitle className="text-lg font-medium">{landingText.premium.modal.prices}</CardTitle>
                        </CardHeader>
                        <CardContent className="flex flex-1 flex-col items-start justify-center gap-4 sm:gap-6">
                            <p className="text-sm text-muted-foreground">{landingText.features.premiumTiles.profileSharingText.description}</p>
                            <div className="flex w-full flex-row justify-start sm:justify-center">
                                <Button className="rounded-full">{landingText.premium.modal.button}</Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>
                <div id="download" className="flex w-full flex-col items-center gap-6 px-4 pt-6 pb-9">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">{landingText.download.title}</div>
                    <a className="active:scale-95" href="https://apps.apple.com/us/app/momtrax/id6741926859" target="_blank">
                        <img src={image('app-store-badge')} alt={landingText.download.buttonAlt} className="w-[160px]" />
                    </a>
                </div>
                <div className="flex w-full flex-col items-center gap-6 bg-secondary p-6">
                    <div className="text-center text-[32px] font-bold sm:text-[40px]">{landingText.contact.title}</div>
                    <div className="text-md text-center">
                        {landingText.contact.message.split('{email}').map((part, i) => (
                            <React.Fragment key={i}>
                                {part}
                                {i === 0 && <Mailto className="text-md p-0" email="support@momtrax.com" />}
                            </React.Fragment>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
