<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Subscribers Management</h1>
                        <p class="text-gray-600 mt-2">Manage your newsletter subscribers and send bulk communications</p>
                    </div>
                    <div class="flex gap-3 mt-4 sm:mt-0">
                        <button
                            @click="openBulkMessageModal"
                            :disabled="selectedSubscribers.length === 0"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Message
                        </button>
                        <button
                            @click="exportSubscribers"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export CSV
                        </button>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Subscribers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ subscribers.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Subscribers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ activeSubscribers }}</p>
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
                                <p class="text-sm font-medium text-gray-600">This Month</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ thisMonthSubscribers }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Selected</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ selectedSubscribers.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions Bar -->
                <div v-if="selectedSubscribers.length > 0" class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-blue-800 font-medium">
                                {{ selectedSubscribers.length }} subscriber{{ selectedSubscribers.length > 1 ? 's' : '' }} selected
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                @click="selectAllSubscribers"
                                class="text-blue-700 hover:text-blue-800 font-medium text-sm"
                            >
                                Select all {{ subscribers.length }}
                            </button>
                            <button
                                @click="clearSelection"
                                class="text-blue-700 hover:text-blue-800 font-medium text-sm"
                            >
                                Clear selection
                            </button>
                            <button
                                @click="openBulkMessageModal"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm"
                            >
                                Send Message
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                            <div class="relative flex-1 sm:flex-none">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search subscribers..."
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64 transition-all"
                                >
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
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

                <!-- Subscribers Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <input
                                    type="checkbox"
                                    :checked="allSelected"
                                    @change="toggleSelectAll"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                >
                                <h3 class="text-lg font-semibold text-gray-900">Subscribers List</h3>
                            </div>
                            <span class="text-sm text-gray-600">{{ filteredSubscribers.length }} subscribers found</span>
                        </div>
                    </div>

                    <!-- Subscribers List -->
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="subscriber in filteredSubscribers"
                            :key="subscriber.id"
                            class="p-6 hover:bg-gray-50 transition-colors duration-200"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <input
                                        type="checkbox"
                                        :checked="isSelected(subscriber.id)"
                                        @change="toggleSubscriber(subscriber.id)"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                    >

                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ getInitials(subscriber.name) }}
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ subscriber.name }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">{{ subscriber.email }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                Subscribed {{ formatDate(subscriber.created_at) }}
                                            </span>
                                            <span class="px-2 py-1 font-medium rounded-full capitalize"
                                                  :class="getStatusClass(subscriber.status)"
                                            >
                                                {{ subscriber.status }}
                                            </span>
                                            <span class="px-2 py-1 font-medium rounded-full bg-gray-100 text-gray-700 capitalize">
                                                {{ subscriber.source }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2">

                                    <!-- Delete Button -->
                                    <button
                                        @click="deleteSubscriber(subscriber)"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                        title="Delete Subscriber"
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
                    <div v-if="filteredSubscribers.length === 0" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No subscribers found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search or filters</p>
                        <button
                            @click="clearFilters"
                            class="px-4 py-2 text-blue-600 hover:text-blue-700 font-medium"
                        >
                            Clear all filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Message Modal -->
        <BulkMessageModal
            :show="showBulkMessageModal"
            :selected-count="selectedSubscribers.length"
            @close="closeBulkMessageModal"
            @send="sendBulkMessage"
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

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Subscriber</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ subscriberToDelete?.name }}"? This action cannot be undone.
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
                            Delete Subscriber
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BulkMessageModal from '@/Components/AdminPanel/BulkMessageModal.vue'

const props = defineProps({
    subscribers: {
        type: Array,
        required: true
    }
})

// Local reactive copy of prop for filtering and selection
const localSubscribers = ref([...props.subscribers])

// Watch prop to update local state if prop changes
watch(() => props.subscribers, (newSubscribers) => {
    localSubscribers.value = [...newSubscribers]
})

// Modal and UI states
const showViewModal = ref(false)
const showBulkMessageModal = ref(false)
const showDeleteModal = ref(false)
const selectedSubscriber = ref(null)
const subscriberToDelete = ref(null)
const selectedSubscribers = ref([])
const searchQuery = ref('')
const statusFilter = ref('all')
const sourceFilter = ref('all')

// Computed properties
const filteredSubscribers = computed(() => {
    let filtered = localSubscribers.value

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(subscriber =>
            subscriber.name.toLowerCase().includes(query) ||
            subscriber.email.toLowerCase().includes(query) ||
            subscriber.location?.toLowerCase().includes(query)
        )
    }

    if (statusFilter.value !== 'all') {
        filtered = filtered.filter(subscriber => subscriber.status === statusFilter.value)
    }

    if (sourceFilter.value !== 'all') {
        filtered = filtered.filter(subscriber => subscriber.source === sourceFilter.value)
    }

    return filtered
})

const activeSubscribers = computed(() => {
    return localSubscribers.value.filter(subscriber => subscriber.status === 'active').length
})

const thisMonthSubscribers = computed(() => {
    const currentMonth = new Date().getMonth()
    const currentYear = new Date().getFullYear()
    return localSubscribers.value.filter(subscriber => {
        const subDate = new Date(subscriber.subscribed_at)
        return subDate.getMonth() === currentMonth && subDate.getFullYear() === currentYear
    }).length
})

const allSelected = computed(() => {
    return filteredSubscribers.value.length > 0 &&
        filteredSubscribers.value.every(sub => selectedSubscribers.value.includes(sub.id))
})

// Methods
const getStatusClass = (status) => {
    const classes = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getInitials = (name) => {
    return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2)
}

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('en-US', options)
}

const viewSubscriber = (subscriber) => {
    selectedSubscriber.value = { ...subscriber }
    showViewModal.value = true
}

const closeViewModal = () => {
    showViewModal.value = false
    selectedSubscriber.value = null
}

const openBulkMessageModal = () => {
    if (selectedSubscribers.value.length > 0) {
        showBulkMessageModal.value = true
    }
}

const closeBulkMessageModal = () => {
    showBulkMessageModal.value = false
}

const deleteSubscriber = (subscriber) => {
    subscriberToDelete.value = subscriber
    showDeleteModal.value = true
}

const confirmDelete = async () => {
    if (subscriberToDelete.value) {
        try {
            await axios.delete(`/subscribers/delete/${subscriberToDelete.value.id}`)

            localSubscribers.value = localSubscribers.value.filter(sub => sub.id !== subscriberToDelete.value.id)
            selectedSubscribers.value = selectedSubscribers.value.filter(id => id !== subscriberToDelete.value.id)

            showDeleteModal.value = false
            subscriberToDelete.value = null

            alert('Subscriber deleted successfully!')
        } catch (error) {
            console.error('Error deleting subscriber:', error)
            alert('Error deleting subscriber. Please try again.')
        }
    }
}

// Selection methods
const isSelected = (id) => selectedSubscribers.value.includes(id)

const toggleSubscriber = (id) => {
    const index = selectedSubscribers.value.indexOf(id)
    if (index > -1) selectedSubscribers.value.splice(index, 1)
    else selectedSubscribers.value.push(id)
}

const toggleSelectAll = () => {
    if (allSelected.value) {
        filteredSubscribers.value.forEach(sub => {
            const index = selectedSubscribers.value.indexOf(sub.id)
            if (index > -1) selectedSubscribers.value.splice(index, 1)
        })
    } else {
        filteredSubscribers.value.forEach(sub => {
            if (!selectedSubscribers.value.includes(sub.id)) selectedSubscribers.value.push(sub.id)
        })
    }
}

const selectAllSubscribers = () => {
    selectedSubscribers.value = localSubscribers.value.map(sub => sub.id)
}

const clearSelection = () => {
    selectedSubscribers.value = []
}

const sendBulkMessage = async (messageData) => {
    try {
        const payload = {
            subscriber_ids: selectedSubscribers.value,
            subject: messageData.subject,
            message: messageData.message,
            type: messageData.type
        }
        await axios.post('/subscribers/bulk-message', payload)

        alert(`Message sent successfully to ${selectedSubscribers.value.length} subscribers!`)
        clearSelection()
        closeBulkMessageModal()
    } catch (error) {
        console.error('Error sending bulk message:', error)
        alert('Error sending message. Please try again.')
    }
}

const exportSubscribers = () => {
    const csvContent = "data:text/csv;charset=utf-8," +
        "Name,Email,Status,Source,Subscribed At,Location\n" +
        localSubscribers.value.map(sub =>
            `"${sub.name}","${sub.email}","${sub.status}","${sub.source}","${sub.subscribed_at}","${sub.location || ''}"`
        ).join("\n")

    const encodedUri = encodeURI(csvContent)
    const link = document.createElement("a")
    link.setAttribute("href", encodedUri)
    link.setAttribute("download", "subscribers.csv")
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

    alert('Subscribers exported successfully!')
}

const clearFilters = () => {
    searchQuery.value = ''
    statusFilter.value = 'all'
    sourceFilter.value = 'all'
}

// Lifecycle
onMounted(() => {
    console.log('Subscribers management component mounted')
})
</script>


<style scoped>
/* Smooth transitions for all interactive elements */
button, select, input {
    transition: all 0.2s ease-in-out;
}
</style>
