<template>
    <GuestLayout>
        <div class="flex pt-12 mx-3 px-3 md:px-12 md:mx-12 flex-col md:flex-row gap-6">
            <!-- Posts Section -->
            <div class="flex-1 space-y-6">
                <Link
                    v-for="post in paginatedPosts"
                    :key="post.id"
                    :href="`/category/${post.category}/${post.slug}`"
                    class="flex flex-col md:flex-row items-start md:items-center gap-4 border p-4 rounded-lg"
                >
                    <img
                        :src="post.image"
                        alt="Post Image"
                        class="w-full md:w-1/3 h-48 object-cover rounded-md"
                    />

                    <div class="flex-1 space-y-3">
                        <p class="text-gray-500 text-sm">
                            {{ post.date_post }} • {{ post.category }} • By {{ post.author }} •
                            {{ post.total_comments }}
                        </p>
                        <h2 class="text-xl font-semibold">{{ post.title }}</h2>


                        <p class="text-gray-600">{{ post.description.slice(0, 100) }}...</p>

                        <button
                            class="mt-2 px-5 py-2 bg-primary text-white rounded-full hover:bg-secondary hover:text-primary transition"
                        >
                            Read More
                        </button>
                    </div>
                </Link>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2">
                    <button
                        @click="currentPage--"
                        :disabled="currentPage === 1"
                        class="px-3 py-1 border rounded disabled:opacity-50"
                    >
                        Prev
                    </button>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <button
                        @click="currentPage++"
                        :disabled="currentPage === totalPages"
                        class="px-3 py-1 border rounded disabled:opacity-50"
                    >
                        Next
                    </button>
                </div>
            </div>

            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Sidebar (Archives) -->
                    <div class="md:w-full border p-4 rounded-lg h-fit">
                        <h3 class="font-bold mb-3">Archives</h3>
                        <ul class="space-y-2">
                            <li
                                v-for="month in months"
                                :key="month"
                                @click="selectMonth(month)"
                                class="cursor-pointer text-blue-600 hover:underline"
                            >
                                {{ month }}
                            </li>
                        </ul>
                    </div>
                    <!-- Categories Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-xl text-gray-800 mb-4 pb-3 border-b border-gray-100">Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            <Link
                                v-for="category in categories"
                                :key="category"
                                :href="`/category/${category}`"
                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer"
                            >
                                {{ category }}
                            </Link>
                        </div>
                    </div>
                    <!-- Newsletter Card -->
                    <SubscriberForNewLetter/>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import {ref, computed} from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import {Link} from '@inertiajs/vue3'
import SubscriberForNewLetter from "@/Components/DynamicPage/SubscriberForNewLetter.vue";

const allPosts = ref([
    {
        id: 1,
        title: 'First Post',
        slug: 'first-post',
        description: 'This is a short description of the first post showing how the text trims.',
        image: 'https://i.pinimg.com/1200x/34/af/47/34af474371aa007bc5c07e68a64ae9a6.jpg',
        created_at: '2025-10-05',
        date_post: 'October 10, 2025',
        category: 'reflection',
        author: 'Israel',
        total_comments: '0 comments',
    },
    {
        id: 2,
        title: 'Graceful Reflection',
        slug: 'graceful-reflection',
        description: 'A reflection on peace and mindfulness for spiritual growth.',
        image: 'https://i.pinimg.com/736x/1a/b1/61/1ab1611bded891badcdca38f11111488.jpg',
        created_at: '2025-10-05',
        date_post: 'October 10, 2025',
        category: 'reflection',
        author: 'Israel',
        total_comments: '0 comments',
    },
    {
        id: 3,
        title: 'Sunday Sermon',
        slug: 'sunday-sermon',
        description: 'A sermon on love, compassion, and understanding others.',
        image: 'https://i.pinimg.com/736x/1a/b1/61/1ab1611bded891badcdca38f11111488.jpg',
        created_at: '2025-10-05',
        date_post: 'October 10, 2025',
        category: 'sermon',
        author: 'Israel',
        total_comments: '0 comments',
    },
    {
        id: 4,
        title: 'Saint Peter of Verona',
        slug: 'saint-peter-of-verona',
        description: 'Story of Saint Peter and his unwavering faith in difficult times.',
        image: 'https://i.pinimg.com/1200x/34/af/47/34af474371aa007bc5c07e68a64ae9a6.jpg',
        created_at: '2025-10-05',
        date_post: 'October 10, 2025',
        category: 'saint_of_the_day',
        author: 'Israel',
        total_comments: '0 comments',
    },
    {
        id: 5,
        title: 'Second Post',
        slug: 'second-post',
        description: 'Another post example with a different date and image for testing the layout.',
        image: 'https://i.pinimg.com/736x/1a/b1/61/1ab1611bded891badcdca38f11111488.jpg',
        created_at: '2025-11-10',
        date_post: 'November 10, 2025',
        category: 'sermon',
        author: 'Israel',
        total_comments: '0 comments',
    },
])

const perPage = 10
const currentPage = ref(1)
const selectedMonth = ref('')

const months = computed(() => {
    const list = allPosts.value.map(p => {
        const d = new Date(p.created_at)
        return `${d.toLocaleString('default', {month: 'long'})}, ${d.getFullYear()}`
    })
    return [...new Set(list)]
})

const categories = computed(() => {
    const cats = allPosts.value.map(p => p.category)
    return [...new Set(cats)]
})


const filteredPosts = computed(() => {
    if (!selectedMonth.value) return allPosts.value
    return allPosts.value.filter(p => {
        const d = new Date(p.created_at)
        const label = `${d.toLocaleString('default', {month: 'long'})}, ${d.getFullYear()}`
        return label === selectedMonth.value
    })
})

const paginatedPosts = computed(() => {
    const start = (currentPage.value - 1) * perPage
    return filteredPosts.value.slice(start, start + perPage)
})

const totalPages = computed(() => Math.ceil(filteredPosts.value.length / perPage))

const selectMonth = month => {
    selectedMonth.value = month
    currentPage.value = 1
}
</script>
