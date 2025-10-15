<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-4xl w-full mx-auto max-h-[90vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ type === 'email' ? 'Email Template Preview' : 'Notification Preview' }}
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
                <div v-if="type === 'email'" class="border border-gray-300 rounded-lg overflow-hidden">
                    <!-- Email Header -->
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900">Email Preview</h4>
                                <p class="text-sm text-gray-600">This is how your email will appear to recipients</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ new Date().toLocaleDateString() }}
                            </div>
                        </div>
                    </div>

                    <!-- Email Content -->
                    <div class="p-6 bg-white">
                        <div v-html="content" class="prose max-w-none"></div>
                    </div>
                </div>

                <div v-else class="border border-gray-300 rounded-lg overflow-hidden">
                    <!-- Notification Header -->
                    <div class="bg-purple-100 px-6 py-4 border-b border-purple-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-purple-900">Notification Preview</h4>
                                <p class="text-sm text-purple-700">This is how your notification will appear to users</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Now
                            </div>
                        </div>
                    </div>

                    <!-- Notification Content -->
                    <div class="p-6 bg-white">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 justify-end p-6 border-t border-gray-200">
                <button
                    type="button"
                    @click="closeModal"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Close Preview
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    show: Boolean,
    content: String,
    type: {
        type: String,
        default: 'email'
    }
})

const emit = defineEmits(['close'])

const closeModal = () => {
    emit('close')
}
</script>

<style scoped>
/* Smooth transitions */
button {
    transition: all 0.2s ease-in-out;
}
</style>
