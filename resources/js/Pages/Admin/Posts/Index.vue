<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Posts Management</h1>
                        <p class="text-gray-600 mt-2">Create, edit, and manage your blog posts</p>
                    </div>
                    <Link
                       href="/article/create"
                        class="mt-4 sm:mt-0 px-6 py-3 bg-primary hover:bg-secondary hover:text-primary text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Post
                    </Link>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Posts</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ posts.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9m0 0v12m0-12a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Published</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ publishedPosts }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Drafts</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ draftPosts }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">This Month</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ thisMonthPosts }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                            <div class="relative flex-1 sm:flex-none">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search posts..."
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64 transition-all"
                                >
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <select
                                v-model="statusFilter"
                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                                <option value="all">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                                <option value="scheduled">Scheduled</option>
                            </select>

                            <select
                                v-model="categoryFilter"
                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                                <option value="all">All Categories</option>
                                <option v-for="category in $page.props.categories" :key="category.id" :value="category.name">
                                    {{ category.name }}
                                </option>
                            </select>
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

                <!-- Posts Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">All Posts</h3>
                            <span class="text-sm text-gray-600">{{ filteredPosts.length }} posts found</span>
                        </div>
                    </div>

                    <!-- Posts List -->
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="post in filteredPosts"
                            :key="post?.id"
                            class="p-6 hover:bg-gray-50 transition-colors duration-200"
                        >
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                <!-- Post Image -->
                                <img
                                    :src="`/storage/${post?.featured_image}`"
                                    :alt="post?.title"
                                    class="w-20 h-20 lg:w-16 lg:h-16 rounded-lg object-cover flex-shrink-0"
                                >

                                <!-- Post Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ post?.title }}</h3>
                                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ post?.description }}</p>

                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    {{ post?.author }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                   {{ new Date(post?.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' }) }}

                                                </span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full capitalize"
                                                      :class="getStatusClass(post.status)"
                                                >
                                                    {{ post?.status }}
                                                </span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                    {{ post?.category?.name }}
                                                </span>

                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                    {{ post?.visibility }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center gap-2 ml-4">

                                            <!-- Publish Toggle -->
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    class="sr-only peer"
                                                    :checked="post?.status === 'published'"
                                                    @change="togglePublish(post)"
                                                />
                                                <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-green-500 relative transition-colors">
                                                    <div
                                                        class="absolute left-1 top-0.5 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-5"
                                                    ></div>
                                                </div>
                                            </label>

                                            <!-- Edit Button -->
                                            <Link
                                                :href="`/article/create/${post.id}`"
                                                class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                                title="Edit Post"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </Link>

                                            <!-- Delete Button -->
                                            <button
                                                @click="confirmDelete(post)"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                title="Delete Post"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredPosts.length === 0" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No posts found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search or filters</p>
                        <button
                            @click="clearFilters"
                            class="px-4 py-2 text-blue-600 hover:text-blue-700 font-medium"
                        >
                            Clear all filters
                        </button>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <p class="text-sm text-gray-600">
                        Showing {{ filteredPosts.length }} of {{ posts.length }} posts
                    </p>

                    <div class="flex items-center gap-2">
                        <button
                            @click="currentPage--"
                            :disabled="currentPage === 1"
                            class="px-3 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                        >
                            Previous
                        </button>

                        <div class="flex items-center gap-1">
                            <span
                                v-for="page in totalPages"
                                :key="page"
                                @click="currentPage = page"
                                class="w-10 h-10 flex items-center justify-center rounded-lg cursor-pointer transition-all duration-200 font-medium"
                                :class="page === currentPage
                                    ? 'bg-blue-600 text-white shadow-md'
                                    : 'text-gray-700 hover:bg-gray-100'"
                            >
                                {{ page }}
                            </span>
                        </div>

                        <button
                            @click="currentPage++"
                            :disabled="currentPage === totalPages"
                            class="px-3 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Post</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ postToDelete?.title }}"? This action cannot be undone.
                    </p>

                    <div class="flex gap-3 justify-center">
                        <button
                            @click="showDeleteModal = false"
                            class="px-6 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                        >
                            Cancel
                        </button>
                        <button
                            @click="deletePost"
                            class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all"
                        >
                            Delete Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'

// Receive posts from backend
const props = defineProps({
    posts: {
        type: Array,
        required: true
    }
})

// Replace local posts data with backend data
const posts = ref(props.posts)

// Filters
const searchQuery = ref('')
const statusFilter = ref('all')
const categoryFilter = ref('all')
const currentPage = ref(1)
const postsPerPage = 10

// Modal
const showDeleteModal = ref(false)
const postToDelete = ref(null)

// Computed properties
const categories = computed(() => {
    const cats = posts.value.map(post => post.category)
    return [...new Set(cats)]
})

const publishedPosts = computed(() => {
    return posts.value.filter(post => post.status === 'published').length
})

const draftPosts = computed(() => {
    return posts.value.filter(post => post.status === 'draft').length
})

const thisMonthPosts = computed(() => {
    const currentMonth = new Date().getMonth()
    const currentYear = new Date().getFullYear()
    return posts.value.filter(post => {
        const postDate = new Date(post.created_at)
        return postDate.getMonth() === currentMonth && postDate.getFullYear() === currentYear
    }).length
})

const filteredPosts = computed(() => {
    let filtered = posts.value

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(post =>
            post.title.toLowerCase().includes(query) ||
            post.description.toLowerCase().includes(query) ||
            post.author.toLowerCase().includes(query)
        )
    }

    if (statusFilter.value !== 'all') {
        filtered = filtered.filter(post => post.status === statusFilter.value)
    }

    if (categoryFilter.value !== 'all') {
        filtered = filtered.filter(post => post.category === categoryFilter.value)
    }

    return filtered
})

const totalPages = computed(() => {
    return Math.ceil(filteredPosts.value.length / postsPerPage)
})

// Helpers
const getStatusClass = (status) => {
    const classes = {
        published: 'bg-green-100 text-green-800',
        draft: 'bg-yellow-100 text-yellow-800',
        scheduled: 'bg-blue-100 text-blue-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const confirmDelete = (post) => {
    postToDelete.value = post
    showDeleteModal.value = true
}

const deletePost = () => {
    if (postToDelete.value) {
        posts.value = posts.value.filter(post => post.id !== postToDelete.value.id)
        showDeleteModal.value = false
        postToDelete.value = null
    }
}

const clearFilters = () => {
    searchQuery.value = ''
    statusFilter.value = 'all'
    categoryFilter.value = 'all'
    currentPage.value = 1
}

const togglePublish = async (post) => {
    const newStatus = post.status === 'published' ? 'draft' : 'published'

    try {
        const response = await axios.put(`/admin/article/${post.id}/toggle-status`, { status: newStatus })
        post.status = newStatus
        alert(response.data.message || 'Status updated successfully')
    } catch (error) {
        console.error('Failed to update post status', error)
        alert('Failed to update post status')
    }
}


</script>


<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions for all interactive elements */
button, select, input {
    transition: all 0.2s ease-in-out;
}
</style>
