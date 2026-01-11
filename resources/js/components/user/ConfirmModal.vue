<template>
    <Modal :enable-click-outside="false" :show="props.show" @close="onClose">
            <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
                <h2 class="text-xl font-semibold mb-4">Confirm Action</h2>
                <p class="mb-6">Are you sure you want to proceed with this action?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="onClose" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button @click="onConfirm" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirm</button>
                </div>
            </div>
    </Modal>
</template>

<script setup>
import { inject,ref } from 'vue';
import Modal from '../../Resources/Modal.vue';
const emit = defineEmits(["open", "close", "confirm"]);

const props = defineProps({
    show: Boolean,
});

const onClose = () => {
    emit("close");
};

const onConfirm = () => {
    emit("confirm");
};

</script>
