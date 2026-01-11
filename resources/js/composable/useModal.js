import { ref } from "vue";

export function useModal() {
    const isOpen = ref(false);

    const openModal = () => {
        isOpen.value = true;
        return true;
    };

    const closeModal = () => {
        isOpen.value = false;
        return false;
    };

    return { show: isOpen, openModal, closeModal };
}
