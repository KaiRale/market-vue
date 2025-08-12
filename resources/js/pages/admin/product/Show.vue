<script setup lang="ts">
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    product: object;
}>();
</script>

<template>
    <AdminLayout>
        <div class="main-container">
            <div class="main-actions">
                <Link :href="route('admin.products.index')" class="submit-button"> Back</Link>
            </div>

            <div class="product-details content-section">
                <div class="product-info">
                    <h3 class="section-title">Main info</h3>
                    <Table class="table-wrapper">
                        <TableBody>
                            <TableRow class="body-row">
                                <TableCell>ID</TableCell>
                                <TableCell>
                                    {{ product.id }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Title</TableCell>
                                <TableCell>
                                    {{ product.title }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Article</TableCell>
                                <TableCell>
                                    {{ product.article }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Description</TableCell>
                                <TableCell>
                                    {{ product.description }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Content</TableCell>
                                <TableCell>
                                    {{ product.content }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Price</TableCell>
                                <TableCell>
                                    {{ product.price }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Old price</TableCell>
                                <TableCell>
                                    {{ product.old_price }}
                                </TableCell>
                            </TableRow>
                            <TableRow class="body-row">
                                <TableCell>Quantity</TableCell>
                                <TableCell>
                                    {{ product.qty }}
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div class="parameters-section content-section" v-if="product.params && product.params.length">
                    <h3 class="section-title">Parameters</h3>
                    <div class="param-list">
                        <div
                            v-for="(param, index) in product.params"
                            :key="index"
                            class="param-item"
                        >
                            <div class="param-content">
                                <span class="param-title">{{ param.title }}:</span>
                                <span class="param-value">{{ param.value }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-images content-section">
                <h3 class="section-title">Product Images</h3>
                <div v-if="product.images.length" class="images-grid">
                    <div v-for="image in product.images" :key="image.id" class="image-container">
                        <img
                            :src="image.url"
                            :alt="product.title"
                            class="product-image"
                        />
<!--                        <div class="image-meta">Image #{{ image.order + 1 }}</div>-->
                    </div>
                </div>
                <div v-else class="no-images">
                    No images available for this product
                </div>
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

.product-details {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 1024px) {
    .product-details {
        grid-template-columns: 2fr 1fr;
    }
}

.table-wrapper {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 2rem;
}

.body-row :deep(td) {
    padding: 0.75rem 1rem;
}

.body-row {
    padding: 0.75rem 1rem;
    background-color: #f8fafc;
}

.body-row > td:first-child {
    font-weight: 600;
    color: #334155;
    background-color: #f8fafc;
    width: 30%;
}

.content-cell {
    max-width: 400px;
    overflow-wrap: break-word;
}

.submit-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
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

.content-section {
    margin-top: 2rem;
}

/* Parameters Section */
.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.param-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.param-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    background-color: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.param-content {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.param-title {
    font-weight: 500;
    color: #334155;
}

.param-value {
    color: #475569;
}

/* Images Section */
.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.image-container {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s;
}

.image-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.product-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}

.image-meta {
    padding: 0.5rem;
    font-size: 0.75rem;
    color: #64748b;
    text-align: center;
    background-color: #f8fafc;
}

.no-images {
    padding: 1rem;
    background-color: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 8px;
    color: #64748b;
    text-align: center;
}
</style>
