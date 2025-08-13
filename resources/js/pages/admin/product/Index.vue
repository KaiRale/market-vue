<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import ProductItem from '@/components/admin/product/ProductItem.vue';
import { ref } from 'vue';

const props = defineProps<{
    products: array;
}>();

const page = usePage();
const productsData = ref(props.products);

const onProductDeleted = (product) => {
    if (!product.parent_id){
        productsData.value = productsData.value.filter(productData => productData.id !== product.id);
    }
    productsData.value.forEach((parentProduct) => {
        if (parentProduct.id === product.parent_id) {
            parentProduct.children = parentProduct.children.filter(child => child.id !== product.id);
        }
    });
};
</script>

<template>
    <AdminLayout>
        <div class="main-container">
            <div class="main-actions">
                <Link :href="route('admin.products.create')" class="submit-button"> Add Product</Link>
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
                            <TableHead>Article</TableHead>
                            <TableHead>Price</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Category</TableHead>
                            <TableHead class="text-center">Actions</TableHead>
                            <TableHead class="text-center">Products</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-for="product in productsData" :key="product.id">
                            <ProductItem @productDeleted="onProductDeleted" :product="product" />
                            <template v-if="product.children?.length > 0" v-for="productChild in product.children">
                                <ProductItem @productDeleted="onProductDeleted" :product="productChild" />
                            </template>
                        </template>
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
    font-family:
        system-ui,
        -apple-system,
        sans-serif;
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
