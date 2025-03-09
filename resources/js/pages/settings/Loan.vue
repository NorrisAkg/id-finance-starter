<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { TransitionRoot } from '@headlessui/vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Demande de prêt',
        href: '/settings/loan-request',
    },
];

const ribCodeInput = ref<HTMLInputElement | null>(null);
const amountInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    rib_code: '',
    amount: '',
});

const makeLoanRequest = () => {
    form.post(route('loan.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors: any) => {
            console.log(errors);

            if (errors.password) {
                form.reset('amount');
                if (amountInput.value instanceof HTMLInputElement) {
                    amountInput.value.focus();
                }
            }

            if (errors.rib_code) {
                form.reset('rib_code');
                if (ribCodeInput.value instanceof HTMLInputElement) {
                    ribCodeInput.value.focus();
                }
            }
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Password settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Demande de prêt" description="Renseignez les informations suivantes pour faire une demande de prêt" />

                <form @submit.prevent="makeLoanRequest" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="rib_code">RIB</Label>
                        <Input
                            id="rib_code"
                            v-model="form.rib_code"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="rib_code"
                            placeholder="Votre RIB"
                        />
                        <InputError :message="form.errors.rib_code" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="amount">Montant</Label>
                        <Input
                            id="amount"
                            ref="amountInput"
                            v-model="form.amount"
                            type="number"
                            class="mt-1 block w-full"
                            autocomplete="amount"
                            placeholder="Montant"
                        />
                        <InputError :message="form.errors.amount" />
                    </div>



                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Envoyer</Button>

                        <TransitionRoot
                            :show="form.recentlySuccessful"
                            enter="transition ease-in-out"
                            enter-from="opacity-0"
                            leave="transition ease-in-out"
                            leave-to="opacity-0"
                        >
                            <p class="text-sm text-neutral-600">Saved</p>
                        </TransitionRoot>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
