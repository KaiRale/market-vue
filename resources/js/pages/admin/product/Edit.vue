<script setup lang="ts">
import EntityTreeSelect from '@/components/EntityTreeSelect/EntityTreeSelect.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps<{
    categories: array;
    categoryTree: array;
    productGroups: array;
    product: object;
    // images: null;
    // params: null
}>();

const form = useForm({
    product: {
        title: props.product.title,
        description: props.product.description,
        content: props.product.content,
        price: Number(props.product.price),
        old_price: Number(props.product.old_price),
        qty: props.product.qty,
        category_id: props.product.category_id,
        product_group_id: props.product.product_group_id,
    },
    images: null,
    params: []
});

const page = usePage();
const isSuccess = ref(false);
const selectedCategory = props.categories[props.product.category_id];
const images = ref(null);

const handleSubmit = () => {
    form.put(route('admin.products.update', {product: props.product.id}), {
        onSuccess: () => {
            isSuccess.value = true;
        },
    });
};

const handleSelection = (data) => {
    form.product.category_id = data?.id ?? null;
    selectedCategory.value = data ?? null;
};

watch(
    () => form.product.category_id,
    (newValue) => {
        selectedCategory.value = newValue !== null ? props.categories[newValue] : null;
    },
);
</script>

<template>
    <AdminLayout>
        <form action="#" @submit.prevent="handleSubmit" class="form-container">
            <div class="form-actions">
                <Link :href="route('admin.products.index')" class="cancel-button"> Cancel</Link>
            </div>

            <Alert v-if="page.props.flash.success && isSuccess" class="success-alert">
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>
                    {{ page.props.flash.success }}
                </AlertDescription>
            </Alert>

            <div class="form-group">
                <Input type="text" v-model="form.product.title" class="form-input" placeholder="Title..." />

                <div class="error-message" v-if="form.errors['product.title']">
                    {{ form.errors['product.title']}}
                </div>
            </div>

            <div class="form-group">
                <Textarea v-model="form.product.description" class="form-input" placeholder="Enter product description..." />

                <div class="error-message" v-if="form.errors['product.description']">
                    {{ form.errors['product.description'] }}
                </div>
            </div>

            <div class="form-group">
                <Textarea v-model="form.product.content" class="form-input" placeholder="Enter product content..." />

                <div class="error-message" v-if="form.errors['product.content']">
                    {{ form.errors['product.content'] }}
                </div>
            </div>

            <div class="form-group">
                <NumberField
                    id="price"
                    v-model="form.product.price"
                    :default-value="0"
                    :min="0"
                    :format-options="{
                        style: 'currency',
                        currency: 'RUB',
                        currencyDisplay: 'code',
                        currencySign: 'accounting',
                    }"
                >
                    <Label for="price">Price</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <NumberField
                    id="oldPrice"
                    v-model="form.product.old_price"
                    :default-value="0"
                    :min="0"
                    :format-options="{
                        style: 'currency',
                        currency: 'RUB',
                        currencyDisplay: 'code',
                        currencySign: 'accounting',
                    }"
                >
                    <Label for="oldPrice">Old price</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <NumberField v-model="form.product.qty" id="qty" :default-value="0" :min="0">
                    <Label for="qyt">Quantity</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <Select v-model="form.product.product_group_id">
                    <SelectTrigger class="bg-white">
                        <SelectValue placeholder="Select filter type..." />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="null"> Select product group...</SelectItem>
                            <SelectItem v-for="productGroup in productGroups" :value="productGroup.id">
                                {{ productGroup.title }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <div class="error-message" v-if="form.errors['product.product_group_id']">
                    {{ form.errors['product.product_group_id'] }}
                </div>
            </div>

            <div class="form-group">
                <EntityTreeSelect
                    :selectedEntity="selectedCategory"
                    :entityTree="categoryTree"
                    nameSelect="category"
                    @update:selected-entity="handleSelection"
                />
                <div class="error-message" v-if="form.errors['product.category_id']">
                    {{ form.errors['product.category_id'] }}
                </div>
            </div>

            <!--            <div class="form-group">-->
            <!--                <Label for="images">Images</Label>-->
            <!--                <Input id="images"-->
            <!--                       type="file"-->
            <!--                       class="bg-white"-->
            <!--                       v-bind="form.images"-->
            <!--                />-->
            <!--            </div>-->

            <!--            <div class="form-group">-->
            <!--                <Select v-model="form.params">-->
            <!--                    <SelectTrigger class="bg-white">-->
            <!--                        <SelectValue placeholder="Select filter type..." />-->
            <!--                    </SelectTrigger>-->
            <!--                    <SelectContent>-->
            <!--                        <SelectGroup>-->
            <!--                            <SelectItem :value="null"> Select product group...</SelectItem>-->
            <!--                            <SelectItem v-for="param in params" :value="param.id">-->
            <!--                                {{ param.title }}-->
            <!--                            </SelectItem>-->
            <!--                        </SelectGroup>-->
            <!--                    </SelectContent>-->
            <!--                </Select>-->

            <!--                <div class="error-message" v-if="form.errors['product.params']">-->
            <!--                    {{ form.errors['product.params'] }}-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="form-actions">
                <Button type="submit" :disabled="form.processing" class="submit-button"> Update</Button>
            </div>
        </form>
    </AdminLayout>
</template>

<style scoped>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 1rem;
    font-family:
        system-ui,
        -apple-system,
        sans-serif;
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
