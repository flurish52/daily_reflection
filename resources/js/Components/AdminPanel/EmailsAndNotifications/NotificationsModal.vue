<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-2xl w-full mx-auto max-h-[90vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ mode === 'create' ? 'Create Notification' : 'Edit Notification' }}
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
                    <div class="space-y-6">
                        <!-- Title Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Notification Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="formData.title"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                placeholder="Enter notification title"
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                                placeholder="Enter notification description"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="formData.type"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                >
                                    <option value="">Select Type</option>
                                    <option value="system">System</option>
                                    <option value="user">User</option>
                                    <option value="alert">Alert</option>
                                    <option value="update">Update</option>
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
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                >
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Trigger Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Trigger Event <span class="text-red-500">*</span>
                            </label>
                            <select
                                v-model="formData.trigger"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                            >
                                <option value="">Select Trigger</option>
                                <option value="comment_created">Comment Created</option>
                                <option value="new_follower">New Follower</option>
                                <option value="post_published">Post Published</option>
                                <option value="maintenance_scheduled">Maintenance Scheduled</option>
                                <option value="security_update">Security Update</option>
                                <option value="user_registered">User Registered</option>
                            </select>
                        </div>

                        <!-- Content Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Notification Content <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                v-model="formData.content"
                                required
                                rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                                placeholder="Enter notification message"
                            ></textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                You can use variables like {user_name}, {post_title}, etc.
                            </p>
                        </div>

                        <!-- Variables Helper -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Available Variables</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{user_name}</span>
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{post_title}</span>
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{comment_content}</span>
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{follower_name}</span>
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{date}</span>
                                <span class="bg-white border border-gray-300 rounded px-2 py-1">{time}</span>
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
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium"
                        >
                            {{ mode === 'create' ? 'Create Notification' : 'Update Notification' }}
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
    notification: Object,
    mode: {
        type: String,
        default: 'create'
    }
})

const emit = defineEmits(['close', 'saved'])

// Form data
const formData = ref({
    title: '',
    description: '',
    type: '',
    status: 'active',
    trigger: '',
    content: ''
})

// Watch for notification prop changes
watch(() => props.notification, (newNotification) => {
    if (newNotification) {
        formData.value = { ...newNotification }
    } else {
        resetForm()
    }
}, { immediate: true })

// Methods
const resetForm = () => {
    formData.value = {
        title: '',
        description: '',
        type: '',
        status: 'active',
        trigger: '',
        content: ''
    }
}

const closeModal = () => {
    emit('close')
    resetForm()
}

const handleSubmit = async () => {
    try {
        const notificationData = {
            title: formData.value.title,
            description: formData.value.description,
            type: formData.value.type,
            status: formData.value.status,
            trigger: formData.value.trigger,
            content: formData.value.content
        }

        let response

        if (props.mode === 'create') {
            response = await axios.post('/notifications/create', notificationData)
        } else {
            response = await axios.post(`/notifications/edit/${props.notification.id}`, notificationData)
        }

        // Emit saved event with the notification data
        emit('saved', notificationData)

        // Show success message
        alert(props.mode === 'create' ? 'Notification created successfully!' : 'Notification updated successfully!')

    } catch (error) {
        console.error('Error saving notification:', error)
        alert('Error saving notification. Please try again.')
    }
}
</script>

<style scoped>
/* Smooth transitions */
button, input, textarea, select {
    transition: all 0.2s ease-in-out;
}
</style>
