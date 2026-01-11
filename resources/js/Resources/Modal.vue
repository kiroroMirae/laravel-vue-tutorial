<template>
    <Teleport to="body">
        <Transition enter-from-class="transition duration-400 opacity-0"
            enter-to-class="transition duration-400 opacity-100" leave-to-class="transition duration-300 opacity-0"
            leave-from-class="transition duration-300 opacity-100">
            <div class="z-[100] bg-slate-900 bg-opacity-60 fixed inset-0 grid place-items-center h-full" v-if="props.show"
                :style="{ zIndex: z_index }"
                ref="sectionRef" @click="handleClickOutside">
                <slot></slot>
            </div>
        </Transition>
    </Teleport>
</template>
<script setup>
import {onMounted, ref, watch} from 'vue'
    const props = defineProps({
        show: {
            type: Boolean,
            default: false,
        },
        enableClickOutside: {
            type: Boolean,
            default: true,
        },
        enableBackgroundScrolling: {
            type: Boolean,
            default: true
        },
        z_index: {
            type: Number,
            default: 100
        }
    })

    const bodyEl = ref(null)
    const sectionRef = ref(null)

    const emit = defineEmits(['close'])

    const handleClickOutside = (event) => {
        if (event.target === sectionRef.value && props.enableClickOutside) {
            emit('close')
        }
    }
    onMounted(()=>{
        const body = document.querySelector('body');
        if (!body) return;
        bodyEl.value = body;
    })
    watch(()=> props.show, function(open){
        // prevent background scrolling :)
        // can be turned off through props
        if (!props.enableBackgroundScrolling) return open ? bodyEl.value.classList.add('overflow-hidden')  : bodyEl.value.classList.remove('overflow-hidden');
    })
</script>
