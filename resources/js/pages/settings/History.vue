<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { LoanTransaction, SharedData, User, type BreadcrumbItem } from '@/types';

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Historique des transactions',
        href: '/settings/balance',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;
const transactions: Array<LoanTransaction> = page.props.transactions as LoanTransaction[];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Historique des transactions" />

        <SettingsLayout :admin="user.is_admin">
            <div class="space-y-6">
                <HeadingSmall title="Historique des transactions" description="Informations sur vos transactions" />

                <Table>
                    <!-- <TableCaption>A list of your recent invoices.</TableCaption> -->
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[250px]">
                                Intitulé
                            </TableHead>
                            <TableHead>Montant</TableHead>
                            <TableHead class="text-right">Date</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(transaction, index) in transactions" :key="index">
                            <TableCell class="font-medium">
                                {{ transaction.label }}
                            </TableCell>
                            <TableCell class="font-bold">{{ transaction.amount }} <span class="ml-2">&#8364;</span></TableCell>
                            <TableCell class="text-right">{{ transaction.created_at }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
