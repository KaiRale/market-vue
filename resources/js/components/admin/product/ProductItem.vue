<script setup lang="ts">
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
import { TableCell, TableRow } from '@/components/ui/table';
import { ChevronDown,ChevronUp, Pencil, Plus, Trash } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import axios from 'axios';
import { defineEmits, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{
    product: object;
}>();

const isClosed = ref(true);
const isDialogOpen = ref(false);
const emits = defineEmits(['productDeleted']);
const page = usePage();

const onDelete = (product) => {
    axios.delete(route('admin.products.destroy', product.id)).then( res => {
        isDialogOpen.value = false;
        emits('productDeleted', product)
        page.props.flash.success = res.data.success;
    });
};

const getProductChildren = () => {
    if(!isClosed.value){
        isClosed.value = true;
        props.product.children = null;

        return;
    }
    axios.get(route('admin.products.children.index', props.product.id)).then((res) => {
        props.product.children = res.data;
        isClosed.value = false;
    });
};
</script>

<template>
    <TableRow class="body-row">
        <TableCell>{{ product.id }}</TableCell>
        <TableCell>
            <Link :href="route('admin.products.show', { product: product.id })">
                {{ product.title }}
            </Link>
        </TableCell>
        <TableCell>{{ product.article }}</TableCell>
        <TableCell>{{ product.price }}</TableCell>
        <TableCell>{{ product.qty }}</TableCell>
        <TableCell>
            <Link :href="route('admin.categories.show', { category: product.category.id })">
                {{ product.category.title }}
            </Link>
        </TableCell>
        <TableCell class="actions-cell">
            <Link :href="route('admin.products.children-create', { product: product.id })">
                <Button class="add-children-button">
                    <Plus />
                </Button>
            </Link>

            <Link :href="route('admin.products.edit', { product: product.id })">
                <Button class="edit-button">
                    <Pencil />
                </Button>
            </Link>

            <AlertDialog v-model:open="isDialogOpen">
                <AlertDialogTrigger as-child>
                    <Button class="delete-button">
                        <Trash />
                    </Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription> This action cannot be undone. This will permanently delete product. </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <Button class="delete-button" @click="onDelete(product)">Delete</Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </TableCell>
        <TableCell class="text-center">
            <Button v-if="!product.parent_id" class="show-children-button" @click="getProductChildren">
                <ChevronDown v-if="isClosed"/>
                <ChevronUp v-else/>
            </Button>
        </TableCell>
    </TableRow>
</template>

<style scoped>

.body-row:hover {
    background-color: #f8fafc;
}

.actions-cell {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
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
</style>
