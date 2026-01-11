<template>
    <div class="mt-[20px] w-full flex flex-col items-center" >
        <form
            class="bg-white rounded-[16px] p-[20px] w-4/12 mt-[20px] border border-[#EAECF0] shadow-sm flex flex-col gap-y-[15px]"
            @submit.prevent="submitForm"
        >
            <div class="flex flex-col gap-y-[5px]">
                <p>
                    Name
                </p>
                <input type="text" name="" id="" class="w-full border border-gray-300 rounded-md p-2 mt-2 mb-4"
                    :class="formErrors.name ? 'border-red-500' : ''"
                    v-model="formElements.name"
                >
                <p v-if="formErrors.name" class="text-red-500 text-sm ">
                    {{ formErrors.name }}
                </p>
            </div>

            <div class="flex flex-col gap-y-[5px]">
                <p>
                    Email
                </p>
                <input type="email" name="" id="" class="w-full border border-gray-300 rounded-md p-2 mt-2 mb-4"
                    :class="formErrors.email ? 'border-red-500' : ''"
                    v-model="formElements.email"
                >
                <p v-if="formErrors.email" class="text-red-500 text-sm">
                    {{ formErrors.email }}
                </p>
            </div>

            <div class="flex flex-col gap-y-[5px]">
                <p>
                    New Password
                </p>
                <input type="password" name="" id="" class="w-full border border-gray-300 rounded-md p-2 mt-2 mb-4"
                    :class="formErrors.new_password ? 'border-red-500' : ''"
                    v-model="formElements.new_password"
                >
                <p v-if="formErrors.new_password" class="text-red-500 text-sm">
                    {{ formErrors.new_password }}
                </p>
            </div>

            <div class="flex flex-col gap-y-[5px]">
                <p>
                    Confirm Password
                </p>
                <input type="password" name="" id="" class="w-full border border-gray-300 rounded-md p-2 mt-2 mb-4"
                    :class="formErrors.confirm_password ? 'border-red-500' : ''"
                    v-model="formElements.confirm_password"
                >
                <p v-if="formErrors.confirm_password" class="text-red-500 text-sm">
                    {{ formErrors.confirm_password }}
                </p>
            </div>

            <div class="flex justify-end mt-4">
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors"
                >
                    Create User
                </button>
            </div>
        </form>
    </div>

</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    sanctum_token: {
        type: String,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    }
})

const formElements = ref({
    name: props.user.name,
    email: props.user.email,
    new_password: '',
    confirm_password: '',
});

const formErrors = ref({});


const validateForm = () => {
    const errors = {};
    // Basic validation logic can be added here

    if (!formElements.value.name) errors.name = 'The name field is required.';
    if (!formElements.value.email) errors.email = 'The email field is required.';
    if (formElements.value.new_password) {
        if (formElements.value.new_password.length < 6) {
            errors.new_password = 'The new password must be at least 6 characters.';
        }
        if (formElements.value.new_password !== formElements.value.confirm_password) {
            errors.confirm_password = 'The confirm password does not match.';
        }
    }

    formErrors.value = errors;
    return (
        Object.keys(errors).length === 0
    );
};

const submitForm = async () => {
    console.log(props.user);

    if (!validateForm()) {
        return;
    }
    try {
        const response = await fetch(`/api/user/updateUser/${props.user.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': props.sanctum_token,
            },
            body: JSON.stringify({
                name: formElements.value.name,
                email: formElements.value.email,
                new_password: formElements.value.new_password,
            }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            formErrors.value = errorData.errors || {};
            toast.error('Failed to update user. Please check the form for errors.');
            return;
        }

        toast.success('User updated successfully!');
    } catch (error) {
        console.error('Error submitting form:', error);
        toast.error('An unexpected error occurred. Please try again later.');
    }
};

</script>
