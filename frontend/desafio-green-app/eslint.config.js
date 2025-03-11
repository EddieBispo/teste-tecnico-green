import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'

export default {
  root: true,
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-essential'
  ],
  env: {
    browser: true,
    es2021: true
  },
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module'
  },
  rules: {
    'vue/multi-word-component-names': 'off'
  },
  ignorePatterns: ['dist/', 'dist-ssr/', 'coverage/']
};
