<script setup lang="ts">
interface Props {
    title: string;
    withDescription?: boolean;
    description?: string;
}

withDefaults(defineProps<Props>(), {
    withDescription: true,
})

</script>

<template>
    <header>
        <h3 class="mb-0.5 text-base font-medium">{{ title }}</h3>
        <p v-if="description && withDescription" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </header>
</template>
