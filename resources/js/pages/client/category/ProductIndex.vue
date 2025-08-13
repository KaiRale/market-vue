<script setup lang="ts">
import ProductItem from '@/components/client/product/ProductItem.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
// import { RouterLink } from 'vue-router';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from '@/components/ui/breadcrumb';

defineProps<{
    products: Array;
    categoryBreadcrumb: Array;
    category: object;
}>();
</script>

<template>
    <MainLayout>
        <aside class="min-h-screen w-1/4 bg-[#200841] text-purple-50">
            <nav></nav>
        </aside>
        <article class="w-3/4 bg-purple-50 p-4 text-[#060B42]">
            <Breadcrumb>
                <BreadcrumbList>
                    <template v-for="breadcrumb in categoryBreadcrumb">
                        <BreadcrumbItem>
                            <BreadcrumbLink as-child>
                                <Link :href="route('client.categories.products.index', breadcrumb.id)">
                                    {{ breadcrumb.title }}
                                </Link>
                            </BreadcrumbLink>
                        </BreadcrumbItem>

                        <BreadcrumbSeparator />
                    </template>
                    <BreadcrumbItem>
                        <BreadcrumbPage>{{ category.title }}</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>

            <div class="mb-4">
                <Link v-for="breadcrumb in categoryBreadcrumb" :href="route('client.categories.products.index', breadcrumb.id)">
                    {{ breadcrumb.title }}
                </Link>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <ProductItem v-for="product in products" :product="product" />
            </div>
        </article>
    </MainLayout>
</template>

<style scoped></style>
