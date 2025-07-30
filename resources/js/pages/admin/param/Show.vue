<script setup lang="ts">
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    param: object;
}>();

</script>

<template>
    <AdminLayout>
        <div class="main-container">
            <div class="main-actions">
                <Link :href="route('admin.params.index')" class="submit-button">
                    Back
                </Link>
            </div>

            <div>
                <Table class="table-wrapper">
                    <TableBody>
                        <TableRow class="body-row">
                            <TableCell>ID</TableCell>
                            <TableCell>
                                {{ param.id }}
                            </TableCell>
                        </TableRow>
                        <TableRow class="body-row">
                            <TableCell>Title</TableCell>
                            <TableCell>
                                {{ param.title }}
                            </TableCell>
                        </TableRow>
                        <TableRow class="body-row">
                            <TableCell>Filter type</TableCell>
                            <TableCell>
                                {{ param.filter_type }}
                            </TableCell>
                        </TableRow>
                        <TableRow class="body-row">
                            <TableCell>Filter type title</TableCell>
                            <TableCell>
                                {{ param.filter_type_title }}
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
</style>
