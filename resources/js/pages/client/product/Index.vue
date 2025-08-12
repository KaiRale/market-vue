<script setup lang="ts">

import { Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';

defineProps<{
    products: Array;
}>();

</script>

<template>
    <MainLayout>
    <aside class="w-1/4 bg-[#200841] text-purple-50 min-h-screen">
        <nav>

        </nav>
    </aside>
    <article class="w-3/4 bg-purple-50 text-[#060B42] p-4">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="product in products" class="p-4 border border-gray-200 bg-white">
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
        </div>
    </article>
    </MainLayout>
</template>

<style scoped>

</style>
