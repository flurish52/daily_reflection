<template>
    <AuthenticatedLayout>
        <div class="p-6 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Events</h1>
                <button
                    @click="openCreateModal"
                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark"
                >
                    Add Event
                </button>
            </div>

            <div v-if="events?.length" class="space-y-4">
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col md:flex-row md:items-center"
                >
                    <img
                        :src="event?.image ? '/storage/' + event.image : '/images/placeholder.jpg'"
                        alt="Event image"
                        class="w-full md:w-48 h-48 object-cover rounded-t-xl md:rounded-l-xl md:rounded-t-none"
                    />

                    <div class="flex-1 p-4 md:p-6 space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ event?.title }} {{'/storage/' + event.image }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ event?.description }}</p>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-6 text-sm text-gray-500">
                            <p>
                                <span class="font-semibold">Date:</span>
                                {{ formatDate(event?.happening_date) }}
                            </p>
                            <p>
                                <span class="font-semibold">Location:</span>
                                {{ event?.location }}
                            </p>
                        </div>

                        <p
                            class="inline-block px-3 py-1 text-xs font-medium rounded-full mt-2"
                            :class="{
                    'bg-green-100 text-green-700': event?.status === 'upcoming',
                    'bg-gray-100 text-gray-700': event?.status === 'past',
                    'bg-red-100 text-red-700': event?.status === 'cancelled'
                }"
                        >
                            {{ event?.status }}
                        </p>

                        <div class="pt-4 flex justify-end gap-4 border-t border-gray-100 mt-4">
                            <button
                                @click="openEditModal(event)"
                                class="text-blue-600 hover:text-blue-800 text-sm font-semibold"
                            >
                                Edit
                            </button>
                            <button
                                @click="deleteEvent(event?.id)"
                                class="text-red-600 hover:text-red-800 text-sm font-semibold"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center text-gray-600 py-12">
                No events yet.
            </div>

            <CreateEventForm
                :show="showModal"
                :event="selectedEvent"
                @close="closeModal"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CreateEventForm from '@/Components/AdminPanel/CreateEventForm.vue'

// Receive events as a prop from the server (Inertia)
const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
})

const events = ref(props.events)
const showModal = ref(false)
const selectedEvent = ref(null)

function openCreateModal() {
    selectedEvent.value = null
    showModal.value = true
}

function openEditModal(event) {
    selectedEvent.value = event
    showModal.value = true
}

function closeModal() {
    showModal.value = false
}

async function deleteEvent(id) {
    if (!confirm('Are you sure you want to delete this event?')) return
    try {
        await axios.delete(`/admin/events/${id}`)
        events.value = events.value.filter(e => e.id !== id)
    } catch (err) {
        console.error('Error deleting event:', err)
    }
}

function formatDate(date) {
    const d = new Date(date)
    return d.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}
</script>
