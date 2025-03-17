<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { SharedData, User, type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Solde',
        href: '/settings/balance',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Solde" />

        <SettingsLayout :admin="user.is_admin">
            <div class="space-y-6">
                <HeadingSmall title="Solde"
                    description="Consultez votre solde" />

                <p class="text-3xl font-semibold">{{ user.balance }} <span class="ml-2">&#8364;</span></p>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
