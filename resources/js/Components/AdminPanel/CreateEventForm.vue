<template>
    <transition name="fade">
        <div
            v-if="show"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 overflow-y-auto p-6"
        >
            <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl relative overflow-hidden">
                <div
                    class="sticky top-0 bg-white z-10 border-b flex justify-between items-center px-6 py-3"
                >
                    <h2 class="text-lg font-semibold">
                        {{ isEditing ? 'Edit Event' : 'Create Event' }}
                    </h2>
                    <button
                        @click="closeModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none"
                    >
                        ×
                    </button>
                </div>

                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <form @submit.prevent="handleSubmit" class="space-y-5">
                        <div v-if="error" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm">
                            {{ error }}
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Description</label>
                            <textarea
                                v-model="form.description"
                                class="w-full border rounded-lg p-2 h-28 focus:ring focus:ring-primary/30"
                            ></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-1">Location</label>
                                <input
                                    v-model="form.location"
                                    type="text"
                                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                />
                            </div>

                            <div>
                                <label class="block text-gray-700 mb-1">Happening Date</label>
                                <input
                                    v-model="form.happening_date"
                                    type="datetime-local"
                                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                    required
                                />
                            </div>
                        </div>



                        <div class="flex items-center justify-around">
                            <div class="mx-2 w-1/2">
                                <label class="block text-gray-700 mb-1">Page</label>
                                <select
                                    v-model="form.post_id"
                                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                >

                                    <option selected value="">Select page</option>
                                    <option v-for="post in $page.props.posts" :value="post.id">{{ post.title }}</option>
                                </select>
                            </div>
                            <div class="mx-2 w-1/2">
                                <label class="block text-gray-700 mb-1">Status</label>
                                <select
                                    v-model="form.status"
                                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                >
                                    <option value="upcoming">Upcoming</option>
                                    <option value="past">Past</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Image</label>
                            <input
                                type="file"
                                @change="handleImageUpload"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary/30"
                                accept="image/*"
                            />
                            <div v-if="preview" class="mt-3">
                                <img
                                    :src="preview"
                                    class="rounded-lg w-full h-40 object-cover border"
                                />
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <button
                                type="button"
                                @click="closeModal"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300"
                                :disabled="loading"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark flex items-center justify-center"
                                :disabled="loading"
                            >
                                <span v-if="loading" class="loader mr-2"></span>
                                {{
                                    isEditing ? (loading ? 'Updating...' : 'Update') : (loading ? 'Creating...' : 'Create')
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import {ref, watch, computed} from 'vue'
import axios from 'axios'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    event: Object,
})

const emits = defineEmits(['close', 'saved'])
const isEditing = computed(() => !!props.event)

const form = ref({
    title: '',
    post_id: '',
    description: '',
    image: null,
    location: '',
    happening_date: '',
    status: 'upcoming',
})

const preview = ref(null)
const error = ref('')
const loading = ref(false)

watch(
    () => props.event,
    (event) => {
        if (event) {
            form.value = {
                title: event.title || '',
                post_id: event.post_id || '',
                description: event.description || '',
                image: event.image,
                location: event.location || '',
                happening_date: event.happening_date || '',
                status: event.status || 'upcoming',
            }
            preview.value = `/storage/${event.image}` || null
        } else resetForm()
    },
    {immediate: true}
)

function resetForm() {
    form.value = {
        title: '',
        post_id: '',
        description: '',
        image: null,
        location: '',
        happening_date: '',
        status: 'upcoming',
    }
    preview.value = null
    error.value = ''
}

function handleImageUpload(e) {
    const file = e.target.files[0]
    if (file) {
        form.value.image = file
        preview.value = URL.createObjectURL(file)
    }
}

async function handleSubmit() {
    loading.value = true
    error.value = ''

    try {
        const formData = new FormData()
        for (const key in form.value) {
            formData.append(key, form.value[key])
        }

        const isEdit = isEditing.value
        if (isEdit) formData.append('_method', 'PUT')

        const url = isEdit
            ? `/admin/events/${props.event.id}`
            : '/admin/events'

        const res = await axios.post(url, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })

        // Check explicitly for success
        if (res.data?.success) {
            // emits('saved')
            closeModal()
            router.visit(window.location.href,
                {preserveScroll: true}
            )
        } else {
            error.value = res.data?.message || 'Failed to save event.'
        }

    } catch (err) {
        console.log('Caught error:', err)
        error.value =
            err.response?.data?.message ||
            'An error occurred while saving the event.'
    } finally {
        loading.value = false
    }
}




function closeModal() {
    emits('close')
    resetForm()
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.loader {
    border: 2px solid #ffffff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
