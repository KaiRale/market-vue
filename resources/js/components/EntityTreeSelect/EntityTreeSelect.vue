<script setup lang="ts">
import EntityOptions from '@/components/EntityTreeSelect/EntityOptions.vue';
import { defineEmits, defineProps, ref, onMounted, onUnmounted } from 'vue';

interface Props {
    selectedEntity?: object | null;
    entityTree: Array;
    level?: number;
    nameSelect: string;
}

const props = withDefaults(defineProps<Props>(), {
    level: 0,
    selectedEntity: null,
});

const emits = defineEmits(['update:selectedEntity']);
const isOpen = ref(false);

function selectItem(item) {
    emits('update:selectedEntity', item);
    isOpen.value = false;
}

function toggleDropdown() {
    isOpen.value = !isOpen.value;
}

function handleClickOutside(event) {
    if (!event.target.closest('.custom-select')) {
        isOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

</script>

<template>
    <div class="custom-select relative w-full" :class="{ 'is-open': isOpen }">
        <div class="select-header" @click.stop="toggleDropdown">
            <span class="select-header-text" v-if="selectedEntity?.title">
                {{ selectedEntity.title }}
            </span>
            <span class="select-header-text" v-else-if="selectedEntity === null">
                No parent
            </span>
            <span class="select-header-placeholder" v-else>
                Select {{ nameSelect }}...
            </span>
            <span class="select-arrow">▼</span>
        </div>
        <div class="select-content" v-show="isOpen">
            <div class="select-option no-parent-option">
                <label class="option-label" @click="selectItem(null)">
                    <span class="option-check" v-if="selectedEntity === null">
                        <svg class="check-icon" viewBox="0 0 12 10">
                            <path d="M1 5L4 8L11 1" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </span>
                    <span class="option-text" :class="{ 'selected': selectedEntity === null }">No parent</span>
                </label>
            </div>
            <EntityOptions :entityTree="entityTree"
                           :nameSelect="nameSelect"
                           :level="level"
                           :selectedId="selectedEntity?.id"
                           @update:selected-entity="selectItem">
            </EntityOptions>
        </div>
    </div>
</template>

<style scoped>
.custom-select {
    position: relative;
    width: 100%;
    max-width: 320px;
    font-family: system-ui, -apple-system, sans-serif;
    margin-bottom: 1rem;
}

.select-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background-color: #fff;
    cursor: pointer;
    transition: all 0.2s;
    min-height: 40px;
}

.select-header:hover {
    border-color: #94a3b8;
}

.custom-select.is-open .select-header {
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px #3b82f6;
}

.select-header-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex-grow: 1;
    text-align: left;
}

.select-header-text.selected {
    font-weight: 600;
}

.select-header-placeholder {
    color: #94a3b8;
    flex-grow: 1;
    text-align: left;
}

.select-arrow {
    margin-left: 0.5rem;
    transition: transform 0.2s;
    font-size: 0.8em;
}

.custom-select.is-open .select-arrow {
    transform: rotate(180deg);
}

.select-content {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    max-height: 300px;
    overflow-y: auto;
    margin-top: 0.25rem;
    padding: 0.5rem;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 10;
    animation: fadeIn 0.15s ease-out;
}

.select-option {
    position: relative;
    margin: 2px 0;
}

.no-parent-option {
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1f5f9;
}

.option-label {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
}

.option-label:hover {
    background-color: #f8fafc;
}

.option-check {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    margin-right: 0.75rem;
    color: #3b82f6;
}

.check-icon {
    width: 14px;
    height: 14px;
}

.option-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.option-text.selected {
    font-weight: 600;
    color: #1e40af;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
