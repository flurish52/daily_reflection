






<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click="closeModal">
        <div class="bg-white rounded-2xl max-w-md w-full mx-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ mode === 'create' ? 'Create New Category' : mode === 'edit' ? 'Edit Category' : 'View Category' }}
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
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="formData.name"
                            type="text"
                            required
                            :readonly="mode === 'view'"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            :class="mode === 'view' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                            placeholder="Enter category name"
                        >
                    </div>

                    <!-- Slug Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="formData.slug"
                            type="text"
                            required
                            :readonly="true"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            :class="mode === 'view' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                            placeholder="category-slug"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            This will be used in the URL: yourblog.com/category/<strong>{{ formData.slug || 'category-slug' }}</strong>
                        </p>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea
                            v-model="formData.description"
                            :readonly="mode === 'view'"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"
                            :class="mode === 'view' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                            placeholder="Enter category description (optional)"
                        ></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
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
                            class="px-4 py-2 text-secondary bg-primary rounded-lg hover:bg-green-700 transition-colors font-medium"
                        >
                            {{ mode === 'create' ? 'Create Category' : 'Update Category' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import axios from 'axios'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    category: Object,
    mode: {
        type: String,
        default: 'create',
        validator: (value) => ['create', 'edit', 'view'].includes(value)
    }
})

const emit = defineEmits(['close', 'saved'])

// Form data
const formData = ref({
    name: '',
    slug: '',
    description: ''
})


// Methods
const resetForm = () => {
    formData.value = {
        name: '',
        slug: '',
        description: ''
    }
}


// Watch for category prop changes
watch(() => props.category, (newCategory) => {
    if (newCategory) {
        formData.value = { ...newCategory }
    } else {
        resetForm()
    }
}, { immediate: true })

// Computed property for auto-generating slug from name
const autoSlug = computed(() => {
    return formData.value.name
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)+/g, '')
})
const closeModal = () => {
    emit('close')
    resetForm()
}

const handleSubmit = () => {
    const categoryData = {
        name: formData.value.name,
        slug: formData.value.slug || autoSlug.value,
        description: formData.value.description
    }

    let request

    if (props.mode === 'create') {
        request = axios.post('/category/create', categoryData)
    } else if (props.mode === 'edit') {
        request = axios.post(`/category/update/${props.category.id}`, categoryData)
    }

    request
        .then(response => {
            if (response.data?.success) {
                alert(response.data.message)
                router.visit(window.location.href, { preserveScroll: true })
            } else {
                alert('Error saving category. Please try again.')
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                const messages = Object.values(error.response.data.errors)
                    .flat()
                    .join('\n')
                alert(messages)
            } else {
                console.error('Error saving category:', error)
                alert('Error saving category. Please try again.')
            }
        })
}



// Auto-generate slug when name changes (only in create mode)
watch(() => formData.value.name, (newName) => {
    if (props.mode === 'create' && newName) {
        formData.value.slug = autoSlug.value
    }
})
</script>

<style scoped>
/* Smooth transitions */
button, input, textarea {
    transition: all 0.2s ease-in-out;
}
</style>
