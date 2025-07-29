<script setup lang="ts">
import {  defineProps, defineEmits } from 'vue';

interface Props {
    entityTree: Array;
    level?: number;
    nameSelect: string;
}

const props = withDefaults(defineProps<Props>(), {
    level: 0,
});

const emits = defineEmits(['update:selectedEntity']);

function selectItem(item) {
    emits('update:selectedEntity', item);
}
</script>

<template>
    <div class="select-options"
         :class="['ml-' + props.level]"
         v-for="entity in props.entityTree">
        <label :for="`${props.nameSelect}-${entity.id}`">
            <input
                type="radio"
                :id="`${props.nameSelect}-${entity.id}`"
                :value="entity.id"
                :name="props.nameSelect"
                @change="selectItem(entity)" />
            {{ entity.title }}</label
        >
        <EntityOptions
            v-if="entity.children && entity.children.length"
            :entityTree="entity.children"
            :level="props.level + 2"
            :nameSelect="props.nameSelect"
            @update:selected-entity="selectItem"
        />
    </div>
</template>

<style scoped>
.select-options {
    display: none;
    position: relative;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #fff;
    border: 1px solid #ccc;
    z-index: 1;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 5px 0;
}
.select-options.show {
    display: block;
}

.select-options {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: white;
    border: 1px solid #1c1c1a;
    z-index: 1;
}
</style>
