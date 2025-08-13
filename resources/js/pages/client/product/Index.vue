<script setup lang="ts">

import MainLayout from '@/layouts/MainLayout.vue';
import ProductItem from '@/components/client/product/ProductItem.vue';

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
            <ProductItem
                v-for="product in products"
                :product="product"
            />
        </div>
    </article>
    </MainLayout>
</template>

<style scoped>

</style>
