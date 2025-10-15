<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-4xl w-full mx-auto max-h-[90vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ mode === 'create' ? 'Create Email Template' : 'Edit Email Template' }}
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
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column - Basic Info -->
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Template Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="formData.name"
                                    type="text"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter template name"
                                >
                            </div>

                            <!-- Description Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea
                                    v-model="formData.description"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="Enter template description"
                                ></textarea>
                            </div>

                            <!-- Type Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Template Type <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="formData.type"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                >
                                    <option value="">Select Type</option>
                                    <option value="newsletter">Newsletter</option>
                                    <option value="transactional">Transactional</option>
                                    <option value="promotional">Promotional</option>
                                    <option value="system">System</option>
                                </select>
                            </div>

                            <!-- Status Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="formData.status"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                >
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column - Content -->
                        <div class="space-y-6">
                            <!-- Subject Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Subject <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="formData.subject"
                                    type="text"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter email subject"
                                >
                            </div>

                            <!-- Content Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Content <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    v-model="formData.content"
                                    required
                                    rows="12"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none font-mono text-sm"
                                    placeholder="Enter email content (HTML supported)"
                                ></textarea>
                                <p class="text-xs text-gray-500 mt-1">
                                    You can use HTML tags and variables like {name}, {email}, etc.
                                </p>
                            </div>

                            <!-- Variables Helper -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Available Variables</h4>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <span class="bg-white border border-gray-300 rounded px-2 py-1">{name}</span>
                                    <span class="bg-white border border-gray-300 rounded px-2 py-1">{email}</span>
                                    <span class="bg-white border border-gray-300 rounded px-2 py-1">{date}</span>
                                    <span class="bg-white border border-gray-300 rounded px-2 py-1">{site_name}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 justify-end pt-6 border-t border-gray-200 mt-6">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
                        >
                            {{ mode === 'create' ? 'Create Template' : 'Update Template' }}
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

const props = defineProps({
    show: Boolean,
    template: Object,
    mode: {
        type: String,
        default: 'create'
    }
})

const emit = defineEmits(['close', 'saved'])

// Form data
const formData = ref({
    name: '',
    description: '',
    type: '',
    status: 'active',
    subject: '',
    content: ''
})

const resetForm = () => {
    formData.value = {
        name: '',
        description: '',
        type: '',
        status: 'active',
        subject: '',
        content: ''
    }
}

// Watch for template prop changes
watch(() => props.template, (newTemplate) => {
    if (newTemplate) {
        formData.value = { ...newTemplate }
    } else {
        resetForm()
    }
}, { immediate: true })

const closeModal = () => {
    emit('close')
    resetForm()
}

const handleSubmit = async () => {
    try {
        const templateData = {
            name: formData.value.name,
            description: formData.value.description,
            type: formData.value.type,
            status: formData.value.status,
            subject: formData.value.subject,
            content: formData.value.content
        }

        let response

        if (props.mode === 'create') {
            response = await axios.post('/email-templates/create', templateData)
        } else {
            response = await axios.post(`/email-templates/edit/${props.template.id}`, templateData)
        }

        // Emit saved event with the template data
        emit('saved', templateData)

        // Show success message
        alert(props.mode === 'create' ? 'Email template created successfully!' : 'Email template updated successfully!')

    } catch (error) {
        console.error('Error saving email template:', error)
        alert('Error saving email template. Please try again.')
    }
}
</script>

<style scoped>
/* Smooth transitions */
button, input, textarea, select {
    transition: all 0.2s ease-in-out;
}
</style>
