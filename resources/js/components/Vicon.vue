<script setup lang="ts">

</script>

<template>
    <span v-html="svgContent" v-if="svgContent"></span>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

// Пропс
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
})

const svgContent = ref('')

const loadSvg = async () => {
    try {
        const response = await axios.get(`/icons/${props.name}`)
        svgContent.value = response.data
    } catch (error) {
        console.error(`SVG icon "${props.name}" not found`, error)
    }
}

onMounted(loadSvg)
watch(() => props.name, loadSvg)
</script>
