<script setup lang="ts">
import axios from 'axios';
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Progress } from '@/components/ui/progress'
import { TransitionRoot } from '@headlessui/vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, watchEffect } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Demande de prêt',
        href: '/settings/loan-request',
    },
];

const page = usePage();
const ribCodeInput = ref<HTMLInputElement | null>(null);
const amountInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    rib_code: '',
    amount: '',
});

const codeVerificationForm = useForm({
    code: ''
});

const progress = ref(page.props.loan ? (page.props.loan  as unknown as { code_verified_count: number })?.code_verified_count  * 25 : 0);
const isDialogOpened = ref(false);
const loanId = ref(page.props.loanId);
const loan = ref(null);
const latestPendingLoan = computed(() => page.props.loan);
const codeFormSubtitle = computed(() => {
    if (progress.value == 0) {
        return "Veuillez renseigner le code que votre banque vous a fourni."
    } else if (progress.value == 25) {
        return "Veuillez renseigner le deuxième code que votre banque vous a fourni."
    } else if (progress.value == 50) {
        return "Veuillez renseigner le troisième code que votre banque vous a fourni."
    } else if (progress.value == 75) {
        return "Veuillez renseigner le dernier code que votre banque vous a fourni."
    }
});

const verifyCode = () => {
    codeVerificationForm.post(route('loan.code.verify', { loan: (page.props.loan as unknown as { id: number }).id }), {
        onSuccess: () => {
            isDialogOpened.value = false;
            codeVerificationForm.reset();
            updateProgressValue();
        },
        onError: (errors: any) => {
            console.log(errors);
        }
    })
}

const updateProgressValue = () => {
    if (progress.value < 100) {
        progress.value += 25;
    }
}

watchEffect(() => {
    if (loanId.value) {
        axios.get(`/api/loans/${loanId.value}`)
            .then(response => {
                loan.value = response.data;
            })
            .catch(error => {
                console.error("Erreur lors de la récupération du prêt :", error);
            });
    }
});

const makeLoanRequest = () => {
    if (progress.value == 100) {
        progress.value = 0;
    }
    form.post(route('loan.store'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log("props", page.props);
            console.log('loan', loan.value);
            form.reset();
        },
        onError: (errors: any) => {
            console.log(errors);

            if (errors.amount) {
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

onMounted(() => {
    console.log("props", page.props);
    console.log('loan', latestPendingLoan.value);
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Password settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Demande de prêt"
                    :description="!latestPendingLoan ? 'Renseignez les informations suivantes pour faire une demande de prêt': codeFormSubtitle" />

                <form v-if="!latestPendingLoan" @submit.prevent="makeLoanRequest" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="rib_code">RIB</Label>
                        <Input id="rib_code" v-model="form.rib_code" type="text" class="mt-1 block w-full"
                            autocomplete="rib_code" placeholder="Votre RIB" />
                        <InputError :message="form.errors.rib_code" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="amount">Montant</Label>
                        <Input id="amount" ref="amountInput" v-model="form.amount" type="number"
                            class="mt-1 block w-full" autocomplete="amount" placeholder="Montant" />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Envoyer</Button>

                        <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                            enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                            <p class="text-sm text-neutral-600">Demande envoyée</p>
                        </TransitionRoot>
                    </div>
                </form>

                <form v-else-if="latestPendingLoan && progress < 100" @submit.prevent="verifyCode" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="verification_code">Code</Label>
                        <Input id="verification_code" v-model="codeVerificationForm.code" class="mt-1 block w-full"
                            autocomplete="verification_code" placeholder="Code de vérification" />
                        <InputError :message="codeVerificationForm.errors.code" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Envoyer</Button>

                        <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                            enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                            <p class="text-sm text-neutral-600">Demande envoyée</p>
                        </TransitionRoot>
                    </div>
                </form>

                <div v-if="progress == 100" class="mb-4 p-4 bg-green-100 text-green-800 rounded !mt-12">
                    Demande de prêt validée
                </div>

                <Progress v-if="progress > 0" class="!mt-12" :model-value="progress" />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
