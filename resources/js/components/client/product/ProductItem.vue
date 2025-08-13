<script setup lang="ts">

import { Link } from '@inertiajs/vue3';

defineProps<{
    product: object;
}>();

</script>

<template>
    <div class="p-4 border border-gray-200 bg-white">
        <h3>{{product.title}}</h3>
        <img :src="product.preview_image_url" :alt="product.title">
        <div class="flex items-center justify-between">
            <p>{{product.price}}</p>
            <p>{{product.old_price}}</p>
        </div>
        <div>
            <Link
                href="#"
                class="block p-4 bg-indigo-600 text-white text-center">
                Buy
            </Link>
        </div>
    </div>
</template>

<style scoped>

</style>
