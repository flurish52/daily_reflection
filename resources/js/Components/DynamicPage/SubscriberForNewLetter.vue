<template>
    <div class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl shadow-lg p-6 text-white">
        <h3 class="font-bold text-xl mb-2">Stay Updated</h3>
        <p class="text-primary-100 mb-4">Get the latest posts delivered to your inbox</p>

        <div class="space-y-3">
            <input
                v-model="form.name"
                type="text"
                placeholder="Your name"
                class="w-full px-4 py-3 rounded-lg bg-white/20 placeholder-primary-200 text-white border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50"
            >
            <input
                v-model="form.email"
                type="email"
                placeholder="Your email address"
                class="w-full px-4 py-3 rounded-lg bg-white/20 placeholder-primary-200 text-white border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50"
            >
            <button
                @click="subscribe"
                class="w-full bg-white text-primary font-medium py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                Subscribe
            </button>

            <p v-if="message" :class="success ? 'text-green-200' : 'text-red-300'" class="text-sm">
                {{ message }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
    name: '',
    email: ''
})

const message = ref('')
const success = ref(false)

async function subscribe() {
    message.value = ''
    try {
        await axios.post('/save/subscriber', form.value)
        message.value = 'Subscription successful.'
        success.value = true
        form.value = { name: '', email: '' }
    } catch (error) {
        message.value = error.response?.data?.message || 'Subscription failed.'
        success.value = false
    }
}
</script>
