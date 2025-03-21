<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { TransitionRoot } from '@headlessui/vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref, watchEffect } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SharedData, User, type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Modifier un solde',
        href: '/settings/increase-balance',
    },
];

// const page = usePage();
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
const amountInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    client_id: '',
    label: '',
    amount: '',
    type: '',
});

const selectedClient = ref<User>()

defineProps<{
    clients: User[];
}>();

const types = [{label: "Créditer", value:'deposit'}, { label: "Débiter", value: 'withdraw' }];

const increaseBalance = () => {
    form.post(route('transaction.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedClient.value = null
        },
        onError: (errors: any) => {
            console.log(errors);

            if (errors.amount) {
                form.reset('amount');
                if (amountInput.value instanceof HTMLInputElement) {
                    amountInput.value.focus();
                }
            }
        },
    });
};

watchEffect(() => {
    if (selectedClient.value) {
        console.log(selectedClient.value);
        form.client_id = selectedClient.value?.id?.toString();
        console.log(form.client_id);
    }
});

onMounted(() => {
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Password settings" />

        <SettingsLayout :admin="user.is_admin">
            <div class="space-y-6">
                <HeadingSmall title="Modification de solde"
                    description="Remplissez le formulaire ci-dessous pour créditer ou débiter un solde" />

                <!-- Message de succès -->
                <div v-if="(page.props.flash as any)?.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ (page.props.flash as any)?.success }}
                </div>

                <form @submit.prevent="increaseBalance" class="space-y-6">
                    <!-- Choose client -->
                    <div class="grid gap-2">
                        <Label for="country">Client</Label>

                        <Select id="country" v-model="selectedClient" required :tabindex="6">
                            <SelectTrigger>
                                <SelectValue placeholder="Sélectionner un client" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Liste des clients</SelectLabel>
                                    <SelectItem v-for="client in clients" :key="client.id" :value="client">
                                        <span>{{ client.firstname + ' ' + client.lastname }}</span>
                                        <br>
                                        <span v-if="!selectedClient" class="text-muted-foreground text-sm">{{ client.email }}</span>
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.client_id" />
                    </div>

                    <div v-if="selectedClient" class="grid gap-2">
                        <p class="text-2xl font-semibold">Solde du client: <span class="ml-2">{{ selectedClient.balance }}</span> <span class="ml-">&#8364;</span></p>
                    </div>

                    <!-- Choose operation type -->
                    <div class="grid gap-2">
                        <Label for="type">Type d'opération</Label>

                        <Select id="type" v-model="form.type" required :tabindex="6">
                            <SelectTrigger>
                                <SelectValue placeholder="Sélectionner le type d'opération" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Type d'opération</SelectLabel>
                                    <SelectItem v-for="(item, index) in types" :key="index" :value="item.value">
                                        {{ item.label }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.client_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="rib_code">Libellé</Label>
                        <Input id="label" v-model="form.label" type="text" class="mt-1 block w-full"
                            autocomplete="label" placeholder="Libellé" />
                        <InputError :message="form.errors.label" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="amount">Montant</Label>
                        <Input id="amount" ref="amountInput" v-model="form.amount" type="number" step="0.01"
                            class="mt-1 block w-full" autocomplete="amount" placeholder="Montant" />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Valider</Button>

                        <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                            enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                            <p class="text-sm text-neutral-600">Opération réussie</p>
                        </TransitionRoot>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
