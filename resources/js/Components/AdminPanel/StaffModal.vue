<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ mode === 'create' ? 'Add New Staff' : mode === 'edit' ? 'Edit Staff' : 'Staff Details' }}
                </h3>
                <button
                    @click="closeModal"
                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form @submit.prevent="handleSubmit">
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="formData.name"
                            type="text"
                            required
                            :readonly="mode === 'view'"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                            :class="mode === 'view' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                            placeholder="Enter full name"
                        >
                        <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="formData.email"
                            type="email"
                            required
                            :readonly="mode === 'view'"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                            :class="mode === 'view' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                            placeholder="Enter email address"
                        >
                        <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4" v-if="mode !== 'view'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input
                            v-model="formData.password"
                            type="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                            placeholder="Enter password"
                        >
                        <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4" v-if="mode !== 'view'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input
                            v-model="formData.password_confirmation"
                            type="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                            placeholder="Confirm password"
                        >
                        <p v-if="errors.password_confirmation" class="text-red-500 text-xs mt-1">{{ errors.password_confirmation[0] }}</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 sticky bottom-0 bg-white">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>

                        <button
                            v-if="mode !== 'view'"
                            type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium"
                        >
                            {{ mode === 'create' ? 'Add Staff' : 'Update Staff' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    staff: Object,
    mode: {
        type: String,
        default: 'create',
        validator: (value) => ['create', 'edit', 'view'].includes(value)
    }
})

const emit = defineEmits(['close', 'saved'])

const formData = ref({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: ''
})

const errors = ref({})

const resetForm = () => {
    formData.value = {
        name: '',
        email: '',
        role: '',
        password: '',
        password_confirmation: ''
    }
    errors.value = {}
}

watch(() => props.staff, (newStaff) => {
    if (newStaff) {
        formData.value = {
            name: newStaff.name || '',
            email: newStaff.email || '',
            role: newStaff.role || '',
            password: '',
            password_confirmation: ''
        }
    } else {
        resetForm()
    }
}, { immediate: true })

const closeModal = () => {
    emit('close')
    resetForm()
}

const handleSubmit = () => {
    errors.value = {}
    const payload = { ...formData.value }

    let request
    if (props.mode === 'create') {
        request = axios.post('/admin/add/staff', payload)
    } else if (props.mode === 'edit') {
        request = axios.post(`/admin/staff/${props.staff.id}`, payload)
    }

    request
        .then(response => {
            // emit('saved', response.data.staff)
            alert(response.data.message || (props.mode === 'create' ? 'Staff member added successfully!' : 'Staff member updated successfully!'))
            closeModal()
            router.visit(window.location.href, { preserveScroll: true })
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors
            } else {
                alert('Error saving staff member. Please try again.')
            }
        })
}

</script>

<style scoped>
button, input, textarea, select {
    transition: all 0.2s ease-in-out;
}
</style>
