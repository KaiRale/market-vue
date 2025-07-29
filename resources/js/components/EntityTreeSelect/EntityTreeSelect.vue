<script setup lang="ts">

import {  defineProps, defineEmits } from 'vue';
import EntityOptions from '@/components/EntityTreeSelect/EntityOptions.vue';

interface Props {
    selectedEntity?: object;
    entityTree: Array;
    level?: number;
    nameSelect: string;
}

const props = withDefaults(defineProps<Props>(), {
    level: 0,
    selectedEntity: null
});

const emits = defineEmits(['update:selectedEntity']);

function selectItem(item) {
    emits('update:selectedEntity', item);
}

document.addEventListener('DOMContentLoaded', function() {
    const customSelect = document.querySelector('.custom-select');
    const selectHeader = customSelect.querySelector('.select-header');
    const selectOptions = customSelect.querySelectorAll('.select-options');
    // const checkboxes = selectOptions.querySelectorAll('input[type="checkbox"]');

    console.log('selectOptions', selectOptions)

    selectHeader.addEventListener('click', function() {
        selectOptions.forEach( (selectOption) => {
            selectOption.classList.toggle('show');
        })
    });

    document.addEventListener('click', function(event) {
        if (!customSelect.contains(event.target)) {
            selectOptions.classList.remove('show');
        }
    });

    // checkboxes.forEach(checkbox => {
    //     checkbox.addEventListener('change', function() {
    //         const selectedValues = Array.from(checkboxes)
    //             .filter(i => i.checked)
    //             .map(i => i.nextSibling.textContent.trim());
    //         selectHeader.querySelector('span:first-child').textContent = selectedValues.length > 0 ? selectedValues.join(', ') : 'Выберите опции';
    //     });
    // });
});
</script>

<template>
    <div class="mb-10 custom-select">
        <div class="select-header">
            <span v-if="selectedEntity.title">{{selectedEntity.title}}</span>
            <span v-else>Select {{nameSelect}}...</span>
            <span class="arrow">&#9660;</span>
        </div>
        <EntityOptions
            :entityTree="entityTree"
            :nameSelect="nameSelect"
            @update:selected-entity="selectItem"
        ></EntityOptions>
    </div>

</template>

<style scoped>
.custom-select {
    position: relative;
    width: 200px;
    border: 1px solid #1c1c1a;
    cursor: pointer;
}

.select-header {
    padding: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}


.select-options label {
    display: block;
    padding: 8px;
    cursor: pointer;
}

.select-options label:hover {
    background-color: #a0aec0;
}

.select-options input[type="checkbox"] {
    margin-right: 8px;
}

</style>
