<script setup lang="ts">

import AdminLayout from "@/layouts/AdminLayout.vue";
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
</script>

<template>
    <AdminLayout>
        <div class="text-center">
            <div class="text-2xl mb-4">Welcome to the test shop!</div>
            <div class="mb-4">Enjoy and let's test it together.</div>
            <div>
                <Button>
                    <Link :href="route('admin.categories.index')">Start</Link>
                </Button>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
