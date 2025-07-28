<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <section class="w-full bg-[#4A2877] p-4 border-b border-gray-100 text-white">
        <div>
            Market Admin
        </div>
    </section>

    <section class="flex">
        <aside class="w-1/4 bg-[#200841] text-purple-50 min-h-screen">
            <nav>
                <Link :href="route('dashboard')" class="block p-4 border-b border-[#7C5CA8]">Dashboard</Link>
                <Link :href="route('admin.product-parents.index')" class="block p-4 border-b border-[#7C5CA8]">Product Group</Link>
                <Link :href="route('admin.products.index')" class="block p-4 border-b border-[#7C5CA8]">Products</Link>
                <Link :href="route('admin.categories.index')" class="block p-4 border-b border-[#7C5CA8]">Category</Link>
                <Link :href="route('admin.params.index')" class="block p-4 border-b border-[#7C5CA8]">Specifications</Link>
            </nav>
        </aside>
        <article class="w-3/4 bg-purple-50 text-[#060B42] p-4">
            <slot/>
        </article>
    </section>

    <section>
        <footer>

        </footer>
    </section>
</template>

<style scoped>

</style>
