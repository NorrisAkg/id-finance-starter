<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { onMounted } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    client_code: '',
    remember: false,
});

const { props } = usePage();

const submit = () => {
    form.post(route('login'), {
        onSuccess: () => {
            form.reset();
        },
        // onFinish: () => form.reset('password'),
        onError: (e) => {
            console.log(e);
            // form.reset('password');
        },
    });
};

onMounted(() => {
    console.log("props", props);
})
</script>

<template>
    <AuthBase single-column title="Connexion" description="Entrez vos informations pour vous connecter">

        <Head title="Connexion" />

        <!-- Message de succès -->
        <div v-if="(props.flash as any)?.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ (props.flash as any)?.success }}
        </div>

        <div v-else-if="status" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Adresse email</Label>
                    <Input id="email" type="email" required autofocus :tabindex="1" autocomplete="email"
                        v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Mot de passe</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm"
                            :tabindex="5">
                            Mot de passe oublié ?
                        </TextLink>
                    </div>
                    <Input id="password" type="password" required :tabindex="2" autocomplete="current-password"
                        v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Code client</Label>
                    </div>
                    <Input id="client_code" type="text" required :tabindex="3" v-model="form.client_code"
                        placeholder="Code client" />
                    <InputError :message="form.errors.client_code" />
                </div>

                <div class="flex items-center justify-between" :tabindex="3">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
                        <span>Se souvenir de moi</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full text-white" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Se connecter
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Pas encore de compte ?
                <TextLink :href="route('register')" :tabindex="5">S'inscrire</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
