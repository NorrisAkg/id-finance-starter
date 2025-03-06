<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Country } from '@/types';
import { onMounted, ref } from 'vue';

const form = useForm({
    firstname: '',
    lastname: '',
    address: '',
    postal_code: '',
    city: '',
    country_id: '',
    telephone: '',
    mobile_phone: '',
    email: '',
    piece_number: '',
    identifiant: '',
    password: '',
    password_confirmation: '',
    photo: null,
});

const props = defineProps<{
    countries: Country[];
}>();

const errors = ref<any>({});
// const errors = ref<Array<string>>([]);

const submit = () => {
    form.post(route('register'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            errors.value = {};
        },
        onError: (errors) => {
            console.log("Erreurs de validation :", errors);
            // errors.value = errors;
        },
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

onMounted(() => {
    console.log("Liste des pays :", props.countries);
})
</script>

<template>
    <AuthBase title="Inscription en ligne" description="Entrez vos informations pour créer un compte.">

        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-5">

                <!-- Identity -->
                <div class="grid gap-2">
                    <Label for="lastname">Identité</Label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Input placeholder="Nom" id="lastname" type="text" required autofocus :tabindex="1"
                                autocomplete="lastname" v-model="form.lastname" />
                            <InputError :message="form.errors.lastname" />
                        </div>
                        <div class="grid gap-2">
                            <Input placeholder="Prénom" id="name" type="text" required autofocus :tabindex="2"
                                autocomplete="firstname" v-model="form.firstname" />
                            <InputError :message="form.errors.firstname" />
                        </div>
                    </div>
                </div>
                <!-- End - Identity -->

                <!-- Address and Postal Code -->
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Label for="address">Adresse</Label>
                            <Input placeholder="Ex: Rue de..." id="address" type="text" required autofocus :tabindex="3"
                                v-model="form.address" />
                            <InputError :message="form.errors.address" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="postal_code">Code postal</Label>
                            <Input placeholder="Code postal" id="postal_code" type="text" required autofocus
                                :tabindex="4" autocomplete="postal_code" v-model="form.postal_code" />
                            <InputError :message="form.errors.postal_code" />
                        </div>
                    </div>
                </div>
                <!-- End - Address and Postal Code -->

                <!-- City and Country -->
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Label for="city">Ville</Label>
                            <Input placeholder="Ex: Strasbourg" id="city" type="text" required autofocus :tabindex="5"
                                v-model="form.city" />
                            <InputError :message="form.errors.city" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="country">Pays</Label>

                            <Select id="country" v-model="form.country_id" required :tabindex="6">
                                <SelectTrigger>
                                    <SelectValue placeholder="Sélectionner un pays" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Liste des pays</SelectLabel>
                                        <SelectItem v-for="country in countries" :key="country.code"
                                            :value="country.id">
                                            {{ country.flag }} {{ country.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </div>
                <!-- End - City and Country -->

                <!-- Phone and mobile phone -->
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Label for="telephone">Téléphone</Label>
                            <Input placeholder="Ex: 01 23 45 67" id="telephone" type="text" required autofocus
                                :tabindex="7" v-model="form.telephone" />
                            <InputError :message="form.errors.telephone" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="mobile_phone">Mobile</Label>
                            <Input placeholder="Ex: 06 12 34 56" id="mobile_phone" type="text" required autofocus
                                :tabindex="8" v-model="form.mobile_phone" />
                            <InputError :message="form.errors.mobile_phone" />
                        </div>
                    </div>
                </div>
                <!-- End - Phone and mobile phone -->

                <div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input placeholder="Ex: toto@email.com" id="email" type="text" required autofocus
                                :tabindex="9" v-model="form.email" />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="piece_number">Numéro de la pièce</Label>
                            <Input placeholder="Numéro de la pièce" id="piece_number" type="text" required autofocus
                                :tabindex="10" autocomplete="piece_number" v-model="form.piece_number" />
                            <InputError :message="form.errors.piece_number" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="identifiant">Identifiant</Label>
                            <Input placeholder="Identifiant" id="identifiant" type="text" required autofocus
                                :tabindex="11" autocomplete="identifiant" v-model="form.identifiant" />
                            <InputError :message="form.errors.identifiant" />
                        </div>
                    </div>
                </div>

                <!-- Password and Confirm Password -->
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-baseline">
                        <div class="grid gap-2">
                            <Label for="password">Mot de passe</Label>
                            <Input placeholder="Votre mot de passe" id="password" type="text" required autofocus
                                :tabindex="12" v-model="form.password" />
                            <InputError :message="form.errors.password" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="password_confirmation">Confirmation de mot de passe</Label>
                            <Input placeholder="Confirmation de votre mot de passe" id="password_confirmation"
                                type="text" required autofocus :tabindex="13" v-model="form.password_confirmation" />
                            <InputError :message="form.errors.password_confirmation" />
                        </div>
                    </div>
                </div>
                <!-- End - Password and Confirm Password -->

                <div>
                    <Label for="photo">Photo</Label>
                    <Input id="photo" type="file" :tabindex="14" accept="image/*"
                        @input="form.photo = $event.target.files[0]" />
                    <InputError :message="form.errors.photo" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    S'inscrire
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Vous avez déjà un compte?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Se connecter
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
