<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';

defineProps<{
    categories: array;
}>();

const page = usePage();

const onDelete = (id: number) => {
    router.delete(route('admin.categories.destroy', { category: id }));
};
</script>

<template>
    <AdminLayout>
        <div class="mb-4">
            <Link :href="route('admin.categories.create')" class="inline-block border border-[#1B206A] bg-[#252B7D] px-3 py-2 text-purple-50">
                Add
            </Link>
        </div>
        <Alert v-if="page.props.flash.success" class="mb-4 w-1/2 border-lime-400 bg-lime-200 text-cyan-950">
            <AlertTitle>Success</AlertTitle>
            <AlertDescription>
                {{ page.props.flash.success }}
            </AlertDescription>
        </Alert>
        <div>
            <Table class="bg-white">
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead class="w-[100px]"> Title</TableHead>
                        <TableHead>Parent Category</TableHead>
                        <TableHead class="text-center">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="category in categories" :key="category.id">
                        <TableCell>{{ category.id }}</TableCell>
                        <TableCell class="font-medium">
                            {{ category.title }}
                        </TableCell>
                        <TableCell>{{ category.parent_id }}</TableCell>
                        <TableCell class="space-x-2 text-center">
                            <Link :href="route('admin.categories.edit', { id: category.id })">
                                <Button class="bg-cyan-400">Edit</Button>
                            </Link>

                            <AlertDialog>
                                <AlertDialogTrigger as-child>
                                    <Button variant="destructive"> Delete</Button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                        <AlertDialogDescription>
                                            This action cannot be undone. This will permanently delete category.
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                                        <Button variant="destructive" @click="onDelete(category.id)">Delete</Button>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AdminLayout>
</template>

<style scoped></style>
