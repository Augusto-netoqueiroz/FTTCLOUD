<script setup>
import { ref } from 'vue'
const count = ref(0)
</script>

<template>
  <div class="p-3 border rounded">
    <h2 class="font-bold mb-2">Vue + Laravel 🎉</h2>
    <button class="px-3 py-2 border rounded" @click="count++">
      Clicar: {{ count }}
    </button>
  </div>
</template>
