<template>
    <section class="px-6 md:px-24 bg-gray-50 py-16">
        <div class="w-full  ">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Upcoming Events</h2>
                <Link href="/events"
                      class="text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    View all events
                </Link>
            </div>

            <div v-if="events?.length > 0" class="space-y-4">
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="flex flex-col lg:flex-row items-start lg:items-center justify-between bg-white border border-gray-200 rounded-xl p-2 hover:shadow-lg transition-all duration-300"
                >
                    <div class="flex flex-col md:flex-row items-start gap-6 w-full lg:w-auto">
                        <!-- Event Image -->
                        <img
                            :src="`/storage/${event.image}`"
                            alt="Event image"
                            class=" md:w-full md:h-full lg:w-32 lg:h-32 object-cover rounded-lg flex-shrink-0"
                        />

                        <!-- Event Details -->
                        <div class="flex-1 min-w-0  items-start">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-1">
                                {{ event.title }}
                            </h3>
                            <p class="text-gray-600 mb-3 line-clamp-2">
                                {{ event.description }}
                            </p>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between  gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ formatDate(event.happening_date) }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="line-clamp-1">{{ event.location }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center gap-6 mt-6 lg:mt-0 lg:pl-6">
                                    <!-- Countdown Timer -->
                                    <div class="flex gap-6 text-center text-gray-700">
                                        <div class="min-w-12">
                                            <p class="text-2xl font-bold text-gray-900">{{ event.countdown.days }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Days</p>
                                        </div>
                                        <div class="min-w-12">
                                            <p class="text-2xl font-bold text-gray-900">{{ event.countdown.hours }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Hours</p>
                                        </div>
                                        <div class="min-w-12">
                                            <p class="text-2xl font-bold text-gray-900">{{
                                                    event.countdown.minutes
                                                }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Min</p>
                                        </div>
                                        <div class="min-w-12">
                                            <p class="text-2xl font-bold text-gray-900">{{
                                                    event.countdown.seconds
                                                }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Sec</p>
                                        </div>
                                    </div>

                                    <!-- View Button -->
                                    <Link
                                        :href="`/category/${event?.post.category.slug}/${event?.post.slug}`"
                                        class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors font-medium whitespace-nowrap"
                                    >
                                        View Details
                                    </Link>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12 bg-white rounded-xl border border-gray-200">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming events</h3>
                <p class="text-gray-600">Check back later for new events</p>
            </div>
        </div>
    </section>

</template>

<script setup>
import {ref, onMounted, onBeforeUnmount} from 'vue'
import axios from 'axios'
import {Link} from '@inertiajs/vue3'

const events = ref([])
const loading = ref(true)
const error = ref(null)

async function fetchEvents() {
    try {
        const response = await axios.get('/events')
        events.value = response.data.data.map(event => ({
            ...event,
            countdown: {},
        }))
        updateCountdown()
    } catch (err) {
        error.value = 'Failed to load events. Please try again.'
    } finally {
        loading.value = false
    }
}

function updateCountdown() {
    const now = new Date().getTime()
    events.value.forEach(event => {
        const eventTime = new Date(event.happening_date).getTime()
        const diff = eventTime - now

        if (diff <= 0) {
            event.countdown = {days: 0, hours: 0, minutes: 0, seconds: 0}
            return
        }

        event.countdown = {
            days: Math.floor(diff / (1000 * 60 * 60 * 24)),
            hours: Math.floor((diff / (1000 * 60 * 60)) % 24),
            minutes: Math.floor((diff / (1000 * 60)) % 60),
            seconds: Math.floor((diff / 1000) % 60),
        }
    })
}

function formatDate(dateString) {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}

let timer
onMounted(() => {
    fetchEvents()
    timer = setInterval(updateCountdown, 1000)
})

onBeforeUnmount(() => clearInterval(timer))
</script>


<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>


<!--<script setup>-->
<!--import { Link } from '@inertiajs/vue3'-->

<!--defineProps({-->
<!--    events: {-->
<!--        type: Array,-->
<!--        default: () => []-->
<!--    }-->
<!--})-->

<!--const formatDate = (dateString) => {-->
<!--    const date = new Date(dateString)-->
<!--    return date.toLocaleDateString('en-US', {-->
<!--        weekday: 'long',-->
<!--        year: 'numeric',-->
<!--        month: 'long',-->
<!--        day: 'numeric',-->
<!--        hour: '2-digit',-->
<!--        minute: '2-digit'-->
<!--    })-->
<!--}-->
<!--</script>-->

<!--<style scoped>-->
<!--.line-clamp-1 {-->
<!--    display: -webkit-box;-->
<!--    -webkit-line-clamp: 1;-->
<!--    -webkit-box-orient: vertical;-->
<!--    overflow: hidden;-->
<!--}-->

<!--.line-clamp-2 {-->
<!--    display: -webkit-box;-->
<!--    -webkit-line-clamp: 2;-->
<!--    -webkit-box-orient: vertical;-->
<!--    overflow: hidden;-->
<!--}-->
<!--</style>-->
