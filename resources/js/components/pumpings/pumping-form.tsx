import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { SharedData, UserSetting } from '@/types';
import { Textarea, Transition } from '@headlessui/react';
import { useForm, usePage } from '@inertiajs/react';
import { ChevronDown, ChevronUp } from 'lucide-react';
import { FormEventHandler, useMemo, useState } from 'react';

type PumpingForm = {
    left_breast_amount: number | null;
    right_breast_amount: number | null;
    total_amount: number;
    duration_in_minutes: number;
    notes: string | null;
    date_time: string;
};

export default function PumpingForm() {
    const { auth } = usePage<SharedData>().props;
    const settings = auth.settings as UserSetting;

    console.log(settings);

    const nowLocal = useMemo(() => {
        const d = new Date();
        const pad = (n: number) => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }, []);

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm<Required<PumpingForm>>({
        left_breast_amount: null,
        right_breast_amount: null,
        total_amount: 0,
        duration_in_minutes: 0,
        notes: null,
        date_time: nowLocal,
    });

    const [useCombinedTotal, setUseCombinedTotal] = useState(true);
    const [showNotes, setShowNotes] = useState(false);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if (!useCombinedTotal) {
            const left = Number(data.left_breast_amount ?? 0);
            const right = Number(data.right_breast_amount ?? 0);
            setData('total_amount', left + right);
        }

        post(route('pumpings.store'), { preserveScroll: true });
    };

    return (
        <form onSubmit={submit} className="space-y-6">
            <div className="grid gap-2">
                <Label htmlFor="date_time">Date & time</Label>
                <Input
                    id="date_time"
                    type="datetime-local"
                    className="mt-1 block w-full"
                    value={data.date_time}
                    onChange={(e) => setData('date_time', e.target.value)}
                    required
                />
                <InputError className="mt-2" message={errors.date_time} />
            </div>

            <div className="grid gap-2">
                <Label>Entry mode</Label>
                <div className="flex items-center gap-2">
                    <Button
                        type="button"
                        variant={useCombinedTotal ? 'default' : 'outline'}
                        onClick={() => setUseCombinedTotal(true)}
                        disabled={processing}
                    >
                        Total
                    </Button>
                    <Button
                        type="button"
                        variant={!useCombinedTotal ? 'default' : 'outline'}
                        onClick={() => setUseCombinedTotal(false)}
                        disabled={processing}
                    >
                        Left / Right
                    </Button>
                </div>
            </div>

            {useCombinedTotal ? (
                <div className="grid gap-2">
                    <Label htmlFor="total_amount">Total amount</Label>
                    <Input
                        id="total_amount"
                        inputMode="decimal"
                        type="number"
                        step="any"
                        min="0"
                        className="mt-1 block w-full"
                        value={data.total_amount}
                        onChange={(e) => setData('total_amount', Number(e.target.value))}
                        required
                    />
                    <InputError className="mt-2" message={errors.total_amount} />
                </div>
            ) : (
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div className="grid gap-2">
                        <Label htmlFor="left_breast_amount">Left amount</Label>
                        <Input
                            id="left_breast_amount"
                            inputMode="decimal"
                            type="number"
                            step="any"
                            min="0"
                            className="mt-1 block w-full"
                            value={data.left_breast_amount ?? ''}
                            onChange={(e) => setData('left_breast_amount', e.target.value === '' ? null : Number(e.target.value))}
                            required
                        />
                        <InputError className="mt-2" message={errors.left_breast_amount} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="right_breast_amount">Right amount</Label>
                        <Input
                            id="right_breast_amount"
                            inputMode="decimal"
                            type="number"
                            step="any"
                            min="0"
                            className="mt-1 block w-full"
                            value={data.right_breast_amount ?? ''}
                            onChange={(e) => setData('right_breast_amount', e.target.value === '' ? null : Number(e.target.value))}
                            required
                        />
                        <InputError className="mt-2" message={errors.right_breast_amount} />
                    </div>
                </div>
            )}

            <div className="grid gap-2">
                <Label htmlFor="duration_in_minutes">Duration (minutes)</Label>
                <Input
                    id="duration_in_minutes"
                    inputMode="numeric"
                    type="number"
                    step="1"
                    min="0"
                    className="mt-1 block w-full"
                    value={data.duration_in_minutes}
                    onChange={(e) => setData('duration_in_minutes', Number(e.target.value))}
                    required
                />
                <InputError className="mt-2" message={errors.duration_in_minutes} />
            </div>

            <div className="space-y-2">
                <Button type="button" variant="outline" className="flex items-center gap-2" onClick={() => setShowNotes((s) => !s)}>
                    {showNotes ? <ChevronUp className="h-4 w-4" /> : <ChevronDown className="h-4 w-4" />}
                    {showNotes ? 'Hide notes' : 'Add notes'}
                </Button>

                <Transition
                    show={showNotes}
                    enter="transition duration-150 ease-out"
                    enterFrom="opacity-0 -translate-y-1"
                    enterTo="opacity-100 translate-y-0"
                    leave="transition duration-150 ease-in"
                    leaveFrom="opacity-100 translate-y-0"
                    leaveTo="opacity-0 -translate-y-1"
                >
                    <div className="grid gap-2">
                        <Label htmlFor="notes">Notes</Label>
                        <Textarea
                            id="notes"
                            className="mt-1 block w-full"
                            rows={4}
                            value={data.notes ?? ''}
                            onChange={(e) => setData('notes', e.target.value === '' ? null : e.target.value)}
                            placeholder="Optional notes…"
                        />
                        <InputError className="mt-2" message={errors.notes} />
                    </div>
                </Transition>
            </div>

            <div className="flex items-center gap-4">
                <Button disabled={processing}>Save</Button>

                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterFrom="opacity-0"
                    leave="transition ease-in-out"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-neutral-600">Saved</p>
                </Transition>
            </div>
        </form>
    );
}
