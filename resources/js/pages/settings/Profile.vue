<script setup lang="ts">
import { TransitionRoot } from '@headlessui/vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Country, type BreadcrumbItem, type SharedData, type User } from '@/types';
import { LassoSelect } from 'lucide-vue-next';
import { computed, onMounted } from 'vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
    country: Country;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Paramètres de compte',
        href: '/settings/profile',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    firstname: user.firstname,
    lastname: user.lastname,
    email: user.email,
    telephone: user.telephone,
    mobile_phone: user.mobile_phone,
    address: user.address,
    city: user.city,
    postal_code: user.postal_code,
    country_id: user.country_id,
    identifiant: user.identifiant,
    piece_number: user.piece_number,
});

const fullname = computed(() => form.firstname + ' ' + form.lastname);

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};

onMounted(() => {
    console.log("user", user);
    console.log("form", form);
    console.log("props", props);
})
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Vos informations personnelles" :with-description="false" description="Update your name and email address" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <Label for="firstname">Identité</Label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div class="grid gap-2">
                                <Input readonly id="firstname" class="mt-1 block w-full" v-model="form.firstname" required
                                    autocomplete="firstname" placeholder="Prénom" />
                                <InputError class="mt-2" :message="form.errors.firstname" />
                            </div>

                            <div class="grid gap-2">
                                <!-- <Label for="lastname">Nom</Label> -->
                                <Input readonly id="lastname" class="mt-1 block w-full" v-model="form.lastname" required
                                    autocomplete="lastname" placeholder="Nom" />
                                <InputError class="mt-2" :message="form.errors.lastname" />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="grid gap-2">
                            <Label for="country">Pays</Label>
                            <div class="relative">
                                <Input id="country" readonly class="mt-1 block w-full" :model-value="country.flag + ' ' + country.name" required
                                    autocomplete="country" placeholder="Pays" />
                            </div>
                            <InputError class="mt-2" :message="form.errors.country_id" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="city">Ville</Label>
                            <Input readonly id="city" class="mt-1 block w-full" v-model="form.city" required
                                autocomplete="city" placeholder="Ville" />
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="grid gap-2">
                            <Label for="address">Adresse</Label>
                            <Input readonly id="address" class="mt-1 block w-full" v-model="form.address" required
                                autocomplete="address" placeholder="Pays" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="postal_code">Code postal</Label>
                            <Input readonly id="postal_code" class="mt-1 block w-full" v-model="form.postal_code" required
                                autocomplete="postal_code" placeholder="Ville" />
                            <InputError class="mt-2" :message="form.errors.postal_code" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="grid gap-2">
                            <Label for="telephone">Téléphone</Label>
                            <Input readonly id="telephone" class="mt-1 block w-full" v-model="form.telephone" required
                                autocomplete="telephone" placeholder="Pays" />
                            <InputError class="mt-2" :message="form.errors.telephone" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="mobile_phone">Mobile</Label>
                            <Input readonly id="mobile_phone" class="mt-1 block w-full" v-model="form.mobile_phone" required
                                autocomplete="mobile_phone" placeholder="Ville" />
                            <InputError class="mt-2" :message="form.errors.mobile_phone" />
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input readonly id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autocomplete="email" placeholder="Email address" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- <div v-if="true">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link :href="route('verification.send')" method="post" as="button"
                                class="hover:!decoration-current text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out dark:decoration-neutral-500">
                            Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div> -->

                    <!-- <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                            enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                            <p class="text-sm text-neutral-600">Saved.</p>
                        </TransitionRoot>
                    </div> -->
                </form>
            </div>

            <!-- <DeleteUser /> -->
        </SettingsLayout>
    </AppLayout>
</template>
