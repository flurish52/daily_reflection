<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-2xl w-full mx-auto max-h-[90vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-900">Send Bulk Message</h3>
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
                    <!-- Recipients Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-800 font-medium">Sending to {{ selectedCount }} subscribers</p>
                                <p class="text-blue-700 text-sm">This message will be delivered to all selected subscribers</p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Message Type</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex cursor-pointer">
                                <input
                                    type="radio"
                                    v-model="formData.type"
                                    value="email"
                                    class="sr-only"
                                    checked
                                >
                                <div class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg w-full transition-all"
                                     :class="formData.type === 'email' ? 'border-blue-500 bg-blue-50' : 'hover:border-gray-400'">
                                    <svg class="w-6 h-6" :class="formData.type === 'email' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium" :class="formData.type === 'email' ? 'text-blue-900' : 'text-gray-900'">Email</p>
                                        <p class="text-sm" :class="formData.type === 'email' ? 'text-blue-700' : 'text-gray-500'">Send via email</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input
                                    type="radio"
                                    v-model="formData.type"
                                    value="notification"
                                    class="sr-only"
                                >
                                <div class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg w-full transition-all"
                                     :class="formData.type === 'notification' ? 'border-blue-500 bg-blue-50' : 'hover:border-gray-400'">
                                    <svg class="w-6 h-6" :class="formData.type === 'notification' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium" :class="formData.type === 'notification' ? 'text-blue-900' : 'text-gray-900'">Notification</p>
                                        <p class="text-sm" :class="formData.type === 'notification' ? 'text-blue-700' : 'text-gray-500'">In-app notification</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Subject Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="formData.subject"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Enter message subject"
                        >
                    </div>

                    <!-- Message Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="formData.message"
                            required
                            rows="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                            placeholder="Enter your message here..."
                        ></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            You can use HTML tags for formatting in email messages
                        </p>
                    </div>

                    <!-- Preview Count -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Message preview length:</span>
                            <span :class="formData.message.length > 500 ? 'text-red-600' : 'text-gray-900'">
                                {{ formData.message.length }} characters
                            </span>
                        </div>
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
                            type="submit"
                            :disabled="!formData.subject || !formData.message"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    show: Boolean,
    selectedCount: Number
})

const emit = defineEmits(['close', 'send'])

// Form data
const formData = ref({
    type: 'email',
    subject: '',
    message: ''
})

// Watch for modal open to reset form
watch(() => props.show, (newVal) => {
    if (newVal) {
        resetForm()
    }
})

// Methods
const resetForm = () => {
    formData.value = {
        type: 'email',
        subject: '',
        message: ''
    }
}

const closeModal = () => {
    emit('close')
    resetForm()
}

const handleSubmit = () => {
    emit('send', formData.value)
}
</script>

<style scoped>
/* Smooth transitions */
button, input, textarea {
    transition: all 0.2s ease-in-out;
}
</style>
