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
        <div class="form-container">
            <div class="form-actions">
                <Link :href="route('admin.categories.create')" class="submit-button">
                    Add Category
                </Link>
            </div>
            <Alert v-if="page.props.flash.success" class="success-alert">
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>
                    {{ page.props.flash.success }}
                </AlertDescription>
            </Alert>
            <div>
                <Table cclass="table-wrapper">
                    <TableHeader>
                        <TableRow class="header-row">
                            <TableHead>ID</TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Parent Category</TableHead>
                            <TableHead class="text-center">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in categories" :key="category.id" class="body-row">
                            <TableCell>{{ category.id }}</TableCell>
                            <TableCell class="font-medium">
                                {{ category.title }}
                            </TableCell>
                            <TableCell>{{ category.parent_id }}</TableCell>
                            <TableCell class="actions-cell">
                                <Link :href="route('admin.categories.edit', { id: category.id })">
                                    <Button class="edit-button">Edit</Button>
                                </Link>

                                <AlertDialog>
                                    <AlertDialogTrigger as-child>
                                        <Button class="delete-button">Delete</Button>
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
                                            <Button class="delete-button" @click="onDelete(category.id)">Delete</Button>
                                        </AlertDialogFooter>
                                    </AlertDialogContent>
                                </AlertDialog>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.form-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
    font-family: system-ui, -apple-system, sans-serif;
}

.form-actions {
    margin-bottom: 1.5rem;
}

.table-wrapper {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-row {
    background-color: #f8fafc;
}

.header-row :deep(th) {
    padding: 0.75rem 1rem;
    font-weight: 600;
    color: #334155;
}

.body-row :deep(td) {
    padding: 0.75rem 1rem;
}

.body-row:hover {
    background-color: #f8fafc;
}

.actions-cell {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.submit-button {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid #1e40af;
    background-color: #1e40af;
    color: white;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.submit-button:hover {
    background-color: #1e3a8a;
    border-color: #1e3a8a;
}

.edit-button {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.edit-button:hover {
    background-color: #2563eb;
    border-color: #2563eb;
}

.delete-button {
    background-color: #ef4444;
    border-color: #ef4444;
    color: white;
}

.delete-button:hover {
    background-color: #dc2626;
    border-color: #dc2626;
}

.success-alert {
    width: 100%;
    max-width: 500px;
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #86efac;
    background-color: #dcfce7;
    color: #166534;
}

.error-message {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #ef4444;
}
</style>
