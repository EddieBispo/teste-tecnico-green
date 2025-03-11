<template>
  <section id="input-container">
    <label :for="id">{{ label }}</label>
    <input :type="type" :id="id" :placeholder="placeholder" />
  </section>
</template>

<style scoped>
:root {
  --label-color: #000000;
  --input-border-color: #e5e5e5;
}

#input-container {
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 9px;
}

label {
  font-size: 16px;
  font-weight: 400;
  line-height: 28.8px;
  color: #000000;
}

input {
  width: 100%;
  height: 55px;
  border: 1px solid #e5e5e5;
  padding-left: 20px;
  font-size: 16px;
  font-weight: 400;

}
</style>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'text',
  },
  id: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: '',
  },
})
</script>