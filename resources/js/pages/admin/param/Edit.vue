<script setup lang="ts">
import { Input } from '@/components/ui/input';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { defineProps, ref, watch } from 'vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Param {
    id: number,
    title: string,
    filter_type: number
}

const props = defineProps<{
    filterTypes: object;
    param: Param;
}>();

const form = useForm({
    title: props.param.title,
    filter_type: props.param.filter_type,
});

const page = usePage();
const isSuccess = ref(false);

const handleSubmit = () =>{
    console.log(form)
    form.put(route('admin.params.update', {param: props.param}), {
        onSuccess: () => {
            isSuccess.value = true
        }
    })
}

watch(() => form.data(), () => {
    isSuccess.value = false
}, { deep: true });
</script>

<template>
    <AdminLayout>
        <form action="#" @submit.prevent="handleSubmit"  class="form-container">
            <div class="form-actions">
                <Link :href="route('admin.params.index')" class="cancel-button">
                    Cancel
                </Link>
            </div>

            <Alert v-if="page.props.flash.success && isSuccess" class="success-alert">
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>
                    {{ page.props.flash.success }}
                </AlertDescription>
            </Alert>

            <div class="form-group">
                <Input
                    type="text"
                    v-model="form.title"
                    class="form-input"
                    placeholder="Title..." />

                <div class="error-message" v-if="form.errors.title">
                    {{ form.errors.title }}
                </div>
            </div>

            <div class="form-group">
                <Select v-model="form.filter_type">
                    <SelectTrigger class="bg-white">
                        <SelectValue placeholder="Select filter type..." />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="null" >
                                Select filter type...
                            </SelectItem>
                            <SelectItem v-for="filterType in filterTypes" :value="filterType.value">
                                {{filterType.title}}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="form-actions">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="submit-button"
                >
                    Update
                </Button>
            </div>
        </form>
    </AdminLayout>
</template>

<style scoped>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 1rem;
    font-family: system-ui, -apple-system, sans-serif;
}

.form-actions {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
    width: 100%;
    max-width: 320px;
}

.form-input {
    width: 100%;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background-color: #fff;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px #3b82f6;
}

.cancel-button {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid #6b7280;
    background-color: #6b7280;
    color: white;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.cancel-button:hover {
    background-color: #4b5563;
    border-color: #4b5563;
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
}

.submit-button:hover:not(:disabled) {
    background-color: #1e3a8a;
    border-color: #1e3a8a;
}

.submit-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
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
