<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { SharedData, User, type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres d'apparence" />

        <SettingsLayout :admin="user.is_admin">
            <div class="space-y-6">
                <HeadingSmall title="Appearance settings" description="Changer l'apparence du site" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
