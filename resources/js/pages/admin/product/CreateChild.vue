<script setup lang="ts">
import EntityTreeSelect from '@/components/entity-tree-select/EntityTreeSelect.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { defineProps, ref, watch } from 'vue';
import { X } from 'lucide-vue-next';

const props = defineProps<{
    categories: array;
    categoryTree: array;
    productGroups: array;
    params: array;
    product: object;
}>();

const form = useForm({
    product: {
        title: props.product.title,
        article: props.product.article,
        description: props.product.description,
        content: props.product.content,
        price: Number(props.product.price),
        old_price: Number(props.product.old_price),
        qty: props.product.qty,
        category_id: props.product.category_id,
        product_group_id: props.product.product_group_id,
        parent_id: props.product.id
    },
    images: [],
    new_images: null,
    params: props.product.params,
});

const page = usePage();
const isSuccess = ref(false);
const selectedCategory = ref(props.categories[props.product.category_id]);
const paramOption = ref({ paramObj: {} });
const imageInput = ref<HTMLElement | null>(null)

const handleSubmit = () => {
    form.post(route('admin.products.store'), {
        onSuccess: () => {
            imageInput.value.value = null
            isSuccess.value = true;
        },
    });
};

const handleSelection = (data) => {
    form.product.category_id = data?.id ?? null;
    selectedCategory.value = data ?? null;
};

const handleImageChange = (images) => {
    form.images = images.target.files;
};

const addParameter = () => {
    form.params.push({
        id: paramOption.value.paramObj.id,
        title: paramOption.value.paramObj.title,
        value: paramOption.value.value
    })
};

const removeParam = (index) => {
    form.params.splice(index, 1)
}

watch(
    () => form.product.category_id,
    (newValue) => {
        selectedCategory.value = newValue !== null ? props.categories[newValue] : null;
    },
);

watch(
    () => form.data(),
    () => {
        isSuccess.value = false;
    },
    { deep: true },
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
                <Label for="product-title">Title</Label>
                <Input id="product-title" type="text" v-model="form.product.title" class="form-input" placeholder="Title..." />

                <div class="error-message" v-if="form.errors['product.title']">
                    {{ form.errors['product.title'] }}
                </div>
            </div>

            <div class="form-group">
                <Label for="product-article">Article</Label>
                <Input id="product-article" type="text" class="form-input" v-model="form.product.article" placeholder="Article..." />

                <div class="error-message" v-if="form.errors['product.article']">
                    {{ form.errors['product.article'] }}
                </div>
            </div>

            <div class="form-group">
                <Label for="product-description">Description</Label>
                <Textarea id="product-description" v-model="form.product.description" class="form-input" placeholder="Enter product description..." />

                <div class="error-message" v-if="form.errors['product.description']">
                    {{ form.errors['product.description'] }}
                </div>
            </div>

            <div class="form-group">
                <Label for="product-content">Content</Label>
                <Textarea id="product-content" v-model="form.product.content" class="form-input" placeholder="Enter product content..." />

                <div class="error-message" v-if="form.errors['product.content']">
                    {{ form.errors['product.content'] }}
                </div>
            </div>

            <div class="form-group">
                <NumberField
                    id="product-price"
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
                    <Label for="product-price">Price</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <NumberField
                    id="product-old-price"
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
                    <Label for="product-old-price">Old price</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <NumberField v-model="form.product.qty" id="qty" :default-value="0" :min="0">
                    <Label for="product-qyt">Quantity</Label>
                    <NumberFieldContent class="bg-white">
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>

            <div class="form-group">
                <Label for="product-group">Group</Label>
                <Select v-model="form.product.product_group_id" id="product-group">
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
                <Label for="product-category">Category</Label>
                <EntityTreeSelect
                    id="product-category"
                    required
                    :selectedEntity="selectedCategory"
                    :entityTree="categoryTree"
                    nameSelect="category"
                    @update:selected-entity="handleSelection"
                />
                <div class="error-message" v-if="form.errors['product.category_id']">
                    {{ form.errors['product.category_id'] }}
                </div>
            </div>

            <div class="form-group" ref="fileInputWrapper">
                <Label for="images">Images</Label>
                <input
                    id="images"
                    multiple
                    type="file"
                    ref="imageInput"
                    class="form-input bg-white"
                    @change="handleImageChange"
                />

                <div v-for="(image, index) in form.images" :key="index">
                    <span v-if="form.errors[`images.${index}`]" class="text-red-500">
                        {{ form.errors[`images.${index}`] }}
                    </span>
                </div>
            </div>

            <div class="form-group parameters-group">
                <div class="parameter-select">
                    <Label for="product-parameters">Parameters</Label>
                    <Select v-model="paramOption.paramObj" id="product-parameters">
                        <SelectTrigger class="compact-trigger bg-white">
                            <SelectValue placeholder="Select parameter..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem :value="{}">Select parameter...</SelectItem>
                                <SelectItem v-for="param in params" :value="param">
                                    {{ param.title }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <div class="error-message" v-if="form.errors['product.params']">
                        {{ form.errors['product.params'] }}
                    </div>
                </div>

                <div class="parameter-value">
                    <Input v-model="paramOption.value" type="text" class="form-input compact-input" placeholder="Value..." />
                </div>

                <div class="parameter-add">
                    <Button type="button" variant="outline" size="sm" @click="addParameter" class="add-button">
                        <Plus class="h-4 w-4" />
                    </Button>
                </div>
            </div>

            <div class="form-group param-list">
                <div
                    v-for="(param, index) in form.params"
                    :key="index"
                    class="param-item"
                >
                    <div class="param-content">
                        <span class="param-title">{{ param.title }}:</span>
                        <span class="param-value">{{ param.value }}</span>
                    </div>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        @click="removeParam(index)"
                        class="remove-btn"
                        title="Remove parameter"
                    >
                        <X class="h-4 w-4" />
                    </Button>
                </div>
            </div>

            <div class="form-actions">
                <Button type="submit" :disabled="form.processing" class="submit-button"> Create</Button>
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

.form-group label {
    margin-bottom: 0.5rem;
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

.parameters-group {
    display: flex;
    align-items: flex-end; /* Выравниваем по нижнему краю */
    gap: 0.5rem; /* Уменьшили расстояние между элементами */
    margin-bottom: 1.5rem;
}

.parameter-select {
    flex: 2;
    min-width: 180px;
    max-width: 180px; /* Фиксируем ширину */
}

.parameter-value {
    flex: 1;
    min-width: 120px;
}

.add-button {
    padding: 0.35rem 0.5rem;
    height: 36px; /* Фиксированная высота как у инпутов */
    border-radius: 6px;
    transition: all 0.2s;
}

.add-button:hover {
    cursor: pointer;
}

/* Компактные стили для элементов формы */
.compact-trigger {
    width: 100%;
    min-width: 100%;
    max-width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.compact-input {
    height: 36px;
    padding: 0.35rem 0.75rem;
}

.no-arrows .number-field-input {
    text-align: left;
    padding-left: 0.75rem;
}

.param-list {
    margin-top: 0.5rem;
}

.param-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    background-color: white;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.param-content {
    flex: 1;
    display: flex;
    gap: 0.5rem;
    overflow: hidden;
}

.param-title {
    font-weight: 500;
}

.param-value {
    color: #64748b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.remove-btn {
    color: #94a3b8;
    width: 24px;
    height: 24px;
}

.remove-btn:hover {
    color: #ef4444;
    cursor: pointer;
    background-color: rgba(239, 68, 68, 0.1);
}
</style>
