<script setup lang="ts">
import { onMounted, ref } from 'vue';
import type { Nullable } from '@/types';

defineProps<{
    modelValue: string;
}>();

defineEmits(['update:modelValue']);

const input = ref<Nullable<HTMLInputElement>>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        ref="input"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
        :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement)?.value)"
    >
</template>
