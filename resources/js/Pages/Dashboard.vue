<template lang="">
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <ContentLayout>
            <template #content>
                Dashboard
            </template>
        </ContentLayout>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import ContentLayout from '@/Layouts/ContentLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>
<style lang="">
    
</style>