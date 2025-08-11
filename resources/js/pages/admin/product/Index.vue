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
import { Plus } from 'lucide-vue-next';
import { ChevronDown } from 'lucide-vue-next';
import { Pencil } from 'lucide-vue-next';
import { Trash } from 'lucide-vue-next';

defineProps<{
    products: array;
}>();

const page = usePage();

const onDelete = (id: number) => {
    router.delete(route('admin.products.destroy', { product: id }));
};
</script>

<template>
    <AdminLayout>
        <div class="main-container">
            <div class="main-actions">
                <Link :href="route('admin.products.create')" class="submit-button">
                    Add Product
                </Link>
            </div>
            <Alert v-if="page.props.flash.success" class="success-alert">
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>
                    {{ page.props.flash.success }}
                </AlertDescription>
            </Alert>
            <div>
                <Table class="table-wrapper">
                    <TableHeader>
                        <TableRow class="header-row">
                            <TableHead>ID</TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Price</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead class="text-center">Actions</TableHead>
                            <TableHead class="text-center">Products</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in products" :key="product.id" class="body-row">
                            <TableCell>{{ product.id }}</TableCell>
                            <TableCell>
                                <Link :href="route('admin.products.show', { product: product.id })">
                                    {{ product.title }}
                                </Link>
                            </TableCell>
                            <TableCell>{{ product.price }}</TableCell>
                            <TableCell>{{ product.qty }}</TableCell>
                            <TableCell class="actions-cell">
                                <Link :href="route('admin.products.children-create', { product: product.id })">
                                    <Button class="add-children-button"><Plus/></Button>
                                </Link>

                                <Link :href="route('admin.products.edit', { product: product.id })">
                                    <Button class="edit-button"><Pencil/></Button>
                                </Link>

                                <AlertDialog>
                                    <AlertDialogTrigger as-child>
                                        <Button class="delete-button"><Trash /></Button>
                                    </AlertDialogTrigger>
                                    <AlertDialogContent>
                                        <AlertDialogHeader>
                                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                            <AlertDialogDescription>
                                                This action cannot be undone. This will permanently delete product.
                                            </AlertDialogDescription>
                                        </AlertDialogHeader>
                                        <AlertDialogFooter>
                                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                                            <Button class="delete-button" @click="onDelete(product.id)">Delete</Button>
                                        </AlertDialogFooter>
                                    </AlertDialogContent>
                                </AlertDialog>
                            </TableCell>
                            <TableCell class="text-center">
                                <Button class="show-children-button"> <ChevronDown /></Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.main-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
    font-family: system-ui, -apple-system, sans-serif;
}

.main-actions {
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

.add-children-button {
    background-color: #5ed38e;
    border-color: #239150;
    color: white;
}

.add-children-button:hover {
    cursor: pointer;
    background-color: #4faf75;
    border-color: #239150;
}

.edit-button {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.edit-button:hover {
    cursor: pointer;
    background-color: #2563eb;
    border-color: #2563eb;
}

.delete-button {
    background-color: #ef4444;
    border-color: #ef4444;
    color: white;
}

.delete-button:hover {
    cursor: pointer;
    background-color: #dc2626;
    border-color: #dc2626;
}

.show-children-button {
    background-color: #807f7f;
    border-color: #4e4e4e;
    color: white;
}

.show-children-button:hover {
    cursor: pointer;
    background-color: #5e5e5e;
    border-color: #4e4e4e;
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
