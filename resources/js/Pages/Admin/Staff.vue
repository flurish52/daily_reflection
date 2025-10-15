<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Staff Management</h1>
                        <p class="text-gray-600 mt-2">Manage your team members</p>
                    </div>
                    <button
                        @click="openCreateModal"
                        class="mt-4 sm:mt-0 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Staff
                    </button>
                </div>

                <!-- Staff List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="member in staff"
                            :key="member.id"
                            class="p-6 hover:bg-gray-50 transition-colors duration-200 flex items-center justify-between"
                        >
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-semibold text-lg">
                                    {{ getInitials(member.name) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ member.name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ member.email }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <button
                                    @click="viewStaff(member)"
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                    title="View Staff"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <button
                                    @click="editStaff(member)"
                                    class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                    title="Edit Staff"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <button
                                    @click="deleteStaff(member)"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                    title="Delete Staff"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="staff.length === 0" class="text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No staff members found</h3>
                        <p class="text-gray-600 mb-4">Add new team members to get started</p>
                        <button
                            @click="openCreateModal"
                            class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition-colors"
                        >
                            Add New Staff
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Modal -->
        <StaffModal
            :show="showModal"
            :staff="selectedStaff"
            :mode="modalMode"
            @close="closeModal"
            @saved="handleStaffSaved"
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

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Staff Member</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ staffToDelete?.name }}"? This action cannot be undone.
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
                            Delete Staff
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import StaffModal from '@/Components/AdminPanel/StaffModal.vue';
import {router} from "@inertiajs/vue3";

defineProps({
    staff: {
        type: Array,
        required: true
    }
})

const showModal = ref(false)
const showDeleteModal = ref(false)
const selectedStaff = ref(null)
const modalMode = ref('create')
const staffToDelete = ref(null)

const openCreateModal = () => {
    selectedStaff.value = null
    modalMode.value = 'create'
    showModal.value = true
}

const viewStaff = (member) => {
    selectedStaff.value = { ...member }
    modalMode.value = 'view'
    showModal.value = true
}

const editStaff = (member) => {
    selectedStaff.value = { ...member }
    modalMode.value = 'edit'
    showModal.value = true
}

const deleteStaff = (member) => {
    staffToDelete.value = member
    showDeleteModal.value = true
}

const confirmDelete = async () => {
    if (!staffToDelete.value) return
    try {
        await axios.delete(`/admin/staff/${staffToDelete.value.id}`)
        showDeleteModal.value = false
        staffToDelete.value = null
        alert('Staff member deleted successfully!')
        router.visit(window.location.href, {preserveScroll: true})
    } catch (error) {
        console.error('Error deleting staff:', error)
        alert('Error deleting staff member. Please try again.')
    }
}


const closeModal = () => {
    showModal.value = false
    selectedStaff.value = null
}

const handleStaffSaved = (staffData) => {
    if (modalMode.value === 'create') {
        const newStaff = {
            ...staffData,
            id: Math.max(0, ...staff.map(s => s.id)) + 1
        }
        staff.push(newStaff)
    } else if (modalMode.value === 'edit' && selectedStaff.value) {
        const index = staff.findIndex(s => s.id === selectedStaff.value.id)
        if (index !== -1) staff[index] = { ...staff[index], ...staffData }
    }
    closeModal()
}

const getInitials = (name) => {
    if (!name) return ''
    return name.split(' ').map(n => n[0]).join('').toUpperCase()
}
</script>

<style scoped>
button, select, input {
    transition: all 0.2s ease-in-out;
}
</style>
