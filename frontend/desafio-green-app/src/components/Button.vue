<template>
    <button :id="id">{{ text }}</button>
</template>

<style scoped>
button {
    min-width: 171px;
    height: 55px;
    padding: 12px 24px 12px 24px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
}

#dark {
    background-color: #000000;
    color: #FFFFFF;
}

#light {
    background-color: #f7f7f7;
    color: #000000;
}
</style>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    text: {
        type: String,
        required: true
    },

    id: {
        type: String,
        required: true
    }
})
</script>