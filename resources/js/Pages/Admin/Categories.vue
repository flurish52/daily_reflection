<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Categories Management</h1>
                        <p class="text-gray-600 mt-2">Manage your blog categories and their slugs</p>
                    </div>
                    <button
                        @click="openCreateModal"
                        class="mt-4 sm:mt-0 px-6 py-3 bg-secondary text-primary font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Category
                    </button>
                </div>

                <!-- Stats Overview -->

                <!-- Search and Filters -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                        <div class="relative w-full lg:w-96">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search categories..."
                                class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-full transition-all"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <div class="flex items-center gap-3 w-full lg:w-auto">
                            <button
                                @click="clearFilters"
                                class="px-4 py-2.5 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                            >
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Categories Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">All Categories</h3>
                            <span class="text-sm text-gray-600">{{ filteredCategories.length }} categories found</span>
                        </div>
                    </div>

                    <!-- Categories List -->
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="category in filteredCategories"
                            :key="category.id"
                            class="p-6 hover:bg-gray-50 transition-colors duration-200"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">Slug: {{ category.slug }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                {{ category.post_count }} posts
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Created {{ formatDate(category.created_at) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2">
                                    <!-- View Button -->
                                    <button
                                        @click="viewCategory(category)"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                        title="View Category"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>

                                    <!-- Edit Button -->
                                    <button
                                        @click="editCategory(category)"
                                        class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                        title="Edit Category"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button
                                        @click="deleteCategory(category)"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                        title="Delete Category"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredCategories.length === 0" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search or create a new category</p>
                        <button
                            @click="openCreateModal"
                            class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors"
                        >
                            Create New Category
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Modal -->
        <CategoryModal
            :show="showModal"
            :category="selectedCategory"
            :mode="modalMode"
            @close="closeModal"
            @saved="handleCategorySaved"
        />

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Category</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ categoryToDelete?.name }}"? This action cannot be undone.
                    </p>

                    <div class="flex gap-3 justify-center">
                        <button
                            @click="showDeleteModal = false"
                            class="px-6 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmDelete"
                            class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all"
                        >
                            Delete Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, toRefs } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CategoryModal from "@/Components/AdminPanel/CategoryModal.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
})

const { categories } = toRefs(props) // make reactive

// Modal and UI states
const showModal = ref(false)
const showDeleteModal = ref(false)
const selectedCategory = ref(null)
const modalMode = ref('create') // 'create', 'edit', 'view'
const categoryToDelete = ref(null)
const searchQuery = ref('')

// Computed properties
const filteredCategories = computed(() => {
    if (!searchQuery.value) return categories.value

    const query = searchQuery.value.toLowerCase()
    return categories.value.filter(category =>
        category.name.toLowerCase().includes(query) ||
        category.slug.toLowerCase().includes(query)
    )
})

const activeCategories = computed(() => {
    return categories.value.filter(category => category.post_count > 0).length
})

const averagePostsPerCategory = computed(() => {
    if (categories.value.length === 0) return 0
    const totalPosts = categories.value.reduce((sum, category) => sum + category.post_count, 0)
    return Math.round(totalPosts / categories.value.length)
})

// Methods
const openCreateModal = () => {
    selectedCategory.value = null
    modalMode.value = 'create'
    showModal.value = true
}

const viewCategory = (category) => {
    selectedCategory.value = { ...category }
    modalMode.value = 'view'
    showModal.value = true
}

const editCategory = (category) => {
    selectedCategory.value = { ...category }
    modalMode.value = 'edit'
    showModal.value = true
}

const deleteCategory = (category) => {
    categoryToDelete.value = category
    showDeleteModal.value = true
}

const confirmDelete = async () => {
    if (!categoryToDelete.value) return

    try {
        await axios.delete(`/category/delete/${categoryToDelete.value.id}`)

        // Remove from reactive categories
        categories.value = categories.value.filter(cat => cat.id !== categoryToDelete.value.id)

        showDeleteModal.value = false
        categoryToDelete.value = null

        alert('Category deleted successfully!')
        router.visit(window.location.href,  {preserveScroll: true})
    } catch (error) {
        console.error('Error deleting category:', error)
        alert('Error deleting category. Please try again.')
    }
}

const closeModal = () => {
    showModal.value = false
    selectedCategory.value = null
}

const handleCategorySaved = (categoryData) => {
    if (modalMode.value === 'create') {
        categories.value.push(categoryData)
    } else if (modalMode.value === 'edit' && selectedCategory.value) {
        const index = categories.value.findIndex(cat => cat.id === selectedCategory.value.id)
        if (index !== -1) {
            categories.value[index] = {
                ...categories.value[index],
                ...categoryData
            }
        }
    }

    closeModal()
}

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('en-US', options)
}

const clearFilters = () => {
    searchQuery.value = ''
}

onMounted(() => {
    console.log('Categories management component mounted')
})
</script>


<style scoped>
/* Smooth transitions for all interactive elements */
button, select, input {
    transition: all 0.2s ease-in-out;
}
</style>
