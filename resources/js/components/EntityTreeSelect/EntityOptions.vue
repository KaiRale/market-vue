<script setup lang="ts">
import { defineEmits, defineProps } from 'vue';

interface Props {
    entityTree: Array;
    level?: number;
    nameSelect: string;
    selectedId?: number | null;
}

const props = withDefaults(defineProps<Props>(), {
    level: 0,
    selectedId: null
});

const emits = defineEmits(['update:selectedEntity']);

function selectItem(item) {
    emits('update:selectedEntity', item);
}
</script>

<template>
    <template v-for="entity in props.entityTree" :key="entity.id">
        <div class="select-options" :style="{ 'padding-left': `${props.level * 12}px` }">
            <label
                   class="option-label"
                   @click="selectItem(entity)"
            >
                 <span class="option-check" v-if="selectedId === entity.id">
                    <svg class="check-icon" viewBox="0 0 12 10">
                        <path d="M1 5L4 8L11 1" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                </span>
                <span
                    class="option-text"
                    :class="{ 'selected': selectedId === entity.id }">
                    {{ entity.title }}
                </span>
            </label>

            <EntityOptions
                v-if="entity.children && entity.children.length"
                :entityTree="entity.children"
                :level="props.level + 1"
                :nameSelect="props.nameSelect"
                :selectedId="selectedId"
                @update:selected-entity="selectItem"
            />
        </div>
    </template>
</template>

<style scoped>
.select-option {
    position: relative;
}

.select-option:before {
    content: "";
    position: absolute;
    left: calc(6px + var(--level, 0) * 12px);
    top: 0;
    bottom: 0;
    width: 1px;
    background-color: #e2e8f0;
    transform: translateX(-50%);
}

.select-option:first-child:before {
    top: 18px;
}

.select-option:last-child:before {
    bottom: calc(100% - 18px);
}

.select-option:only-child:before {
    display: none;
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
</style>
