<script setup>
import { useToast } from 'vue-toastification';
import { onMounted } from "vue"
const props = defineProps({
    type: String,
    message: String
})

onMounted(() => {
    if (props.message && props.type) {
        setTimeout(() => {
            const toast = useToast();
            toast[props.type](props.message);
        }, 100)
    }
})
</script>
<template>
    <div>

        {{ " " }}
    </div>
</template>
