<template>
    <nav class="flex space-x-2 mt-4">
        <button
            v-for="(link, index) in pagination.links"
            :key="index"
            @click="goToPage(link.url)"
            v-html="link.label"
            :class="[
                'px-3 py-2 border rounded',
                link.active ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700',
                link.url ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'
            ]"
            :disabled="!link.url"
        ></button>
    </nav>
</template>

<script setup>
import { defineProps } from "vue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
    pagination: Object
});

const goToPage = (url) => {
    if (url) {
        router.get(url);
    }
};
</script>