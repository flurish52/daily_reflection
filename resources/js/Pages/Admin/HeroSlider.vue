<template>
    <AuthenticatedLayout>
        <div class="w-full bg-white p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Hero Sliders</h2>

            <!-- Success & Error Messages -->
            <div v-if="successMessage" class="mb-4 text-green-600 font-medium">
                {{ successMessage }}
            </div>
            <div v-if="errorMessage" class="mb-4 text-red-600 font-medium">
                {{ errorMessage }}
            </div>

            <!-- Create New Hero Slider -->
            <form @submit.prevent="createSlide" class="mb-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Main Text</label>
                        <input
                            v-model="form.main_text"
                            type="text"
                            placeholder="Enter main text"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <input
                            v-model="form.subtitle"
                            type="text"
                            placeholder="Enter subtitle"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Text</label>
                    <textarea
                        v-model="form.text"
                        rows="3"
                        placeholder="Enter description"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 resize-none"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                    <input
                        v-model="form.order"
                        type="number"
                        placeholder="e.g 5"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    >
                </div>


                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                    <div class="flex items-center gap-4">
                        <div v-if="form.preview" class="w-32 h-20 rounded-lg overflow-hidden border border-gray-300">
                            <img :src="form.preview" class="w-full h-full object-cover" alt="Preview">
                        </div>
                        <input
                            type="file"
                            accept="image/*"
                            @change="updateImage"
                            class="block text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2"
                        >
                    </div>
                </div>



                <button
                    type="submit"
                    :disabled="loading"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-60"
                >
                    {{ loading ? 'Saving...' : 'Add Slider' }}
                </button>
            </form>

            <!-- Display Existing Sliders -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Existing Sliders</h3>
                <div v-if="slides.length === 0" class="text-gray-500 text-sm">No sliders yet.</div>

                <div
                    v-for="(slide, index) in slides"
                    :key="slide.id"
                    class="border border-gray-200 rounded-xl p-4 mb-4 flex items-center gap-4"
                >
                    <div class="text-gray-600 font-bold w-6 text-center">{{ index + 1 }}</div>

                    <div class="w-40 h-24 rounded-lg overflow-hidden border border-gray-300 flex-shrink-0">
                        <img :src="slide.background_image" class="w-full h-full object-cover" alt="Background">
                    </div>

                    <div class="flex-1">
                        <h4 class="text-base font-bold text-gray-800">Main: {{ slide.main_text }}</h4>
                        <p class="text-sm text-gray-600">Subtitle: {{ slide.subtitle }}</p>
                        <p class="text-xs text-gray-500 mt-1">Text: {{ slide.text }}</p>
                    </div>

                    <button @click="deleteSlide(slide.id)" class="text-red-600 hover:underline text-sm">
                        Delete
                    </button>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {router} from "@inertiajs/vue3";
const props = defineProps({
    slides: Array
})
const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const form = ref({
    main_text: '',
    subtitle: '',
    order: '',
    text: '',
    background_image: null,
    preview: null
})

function updateImage(e) {
    const f = e.target.files[0]
    if (!f) return
    const img = new Image()
    img.onload = () => {
        const c = document.createElement('canvas')
        const s = 1920 / Math.max(img.width, img.height)
        c.width = img.width * s
        c.height = img.height * s
        c.getContext('2d').drawImage(img, 0, 0, c.width, c.height)
        c.toBlob(b => {
            if (b.size > 2 * 1024 * 1024) return alert('Too large')
            form.value.background_image = new File([b], f.name, { type: 'image/jpeg' })
            form.value.preview = URL.createObjectURL(b)
        }, 'image/jpeg', 0.8)
    }
    img.src = URL.createObjectURL(f)
}


async function createSlide() {
    loading.value = true
    successMessage.value = ''
    errorMessage.value = ''

    const formData = new FormData()
    formData.append('main_text', form.value.main_text)
    formData.append('subtitle', form.value.subtitle)
    formData.append('text', form.value.text)
    if (form.value.background_image) {
        formData.append('background_image', form.value.background_image)
    }

    try {
        await axios.post('/admin/hero_slider', formData)
        successMessage.value = 'Slide added successfully.'
        setTimeout(()=>{
        router.visit(window.location.href, {preserveScroll: scroll})
        }, 3000)
        form.value = {
            main_text: '',
            subtitle: '',
            order: '',
            text: '',
            background_image: null,
            preview: null
        }
    } catch (error) {
        errorMessage.value = 'Failed to save slide. Check your inputs.'
    } finally {
        loading.value = false
    }
}

async function deleteSlide(id) {
    const confirmed = confirm('Are you sure you want to delete this slide?')
    if (!confirmed) return
    try {
        await axios.delete(`/admin/hero_slider/${id}`)
        router.visit(window.location.href, { preserveScroll: true })
        successMessage.value = 'Slide deleted successfully.'
    } catch (error) {
        errorMessage.value = 'Failed to delete slide.'
    }
}

</script>
