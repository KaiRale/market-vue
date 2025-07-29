<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { watch, ref } from "vue";

import EntityTreeSelect from '@/components/EntityTreeSelect/EntityTreeSelect.vue';

const props = defineProps<{
    categoryTree: array;
    categories: object;
}>();

const form = useForm({
    title: '',
    parent_id: null,
});

const handleSubmit = () =>{
    form.post(route('admin.categories.store'), {
        onSuccess: () => form.reset()
    })
}
const handleSelection = (data) => {
    form.parent_id = data.id;
}
const page = usePage();

const selectedCategory = ref({});

watch(
    () => form.parent_id,
    (newValue) => {
        selectedCategory.value = props.categories[newValue]
    }
);


</script>

<template>
    <AdminLayout>

        <EntityTreeSelect
            :selectedEntity="selectedCategory"
            :entityTree="categoryTree"
            nameSelect="category"
            @update:selected-entity="handleSelection"
        ></EntityTreeSelect>

        <form action="#" @submit.prevent="handleSubmit">
            <div class="mb-4">
                <Link :href="route('admin.categories.index')" class="inline-block border border-[#54589B] bg-[#6F74BA] px-3 py-2 text-purple-50"
                    >Cancel
                </Link>
            </div>

            <Alert v-if="page.props.flash.success" class="w-1/2 mb-4 bg-lime-200 border-lime-400 text-cyan-950">
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>
                    {{ page.props.flash.success }}
                </AlertDescription>
            </Alert>

            <div class="mb-4 w-1/4">
                <Input type="text" v-model="form.title" class=" border border-[#B1B5F2] p-2" placeholder="Title..." />

                <div class="text-sm text-red-600" v-if="form.errors.title">{{ form.errors.title }}</div>
            </div>
            <div class="mb-4">
                <Select v-model="form.parent_id">
                    <SelectTrigger class="w-1/4">
                        <SelectValue placeholder="Select category" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="null" selected>Not selected</SelectItem>
                            <SelectItem v-for="category in categoryTree" :value="category.id">
                                <p v-if="category.parent_id">
                                    {{categoryTree[category.parent_id].title}} /
                                </p>
                                <p>{{category.title}}</p>
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <div class="text-sm text-red-600" v-if="form.errors.parent_id">{{ form.errors.parent_id }}</div>

            </div>
            <div class="mb-4">
                <Button type="submit" :disabled="form.processing" class="inline-block border border-[#1B206A] bg-[#252B7D] px-3 py-2 text-purple-50"> Create </Button>
            </div>


        </form>
    </AdminLayout>
</template>

<style scoped>

</style>
