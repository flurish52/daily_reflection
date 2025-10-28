<template>
    <GuestLayout>
        <div class="flex pt-12 mx-3 px-3 md:px-12 md:mx-12 flex-col md:flex-row gap-6">
            <!-- Posts Section -->
            <div class="flex-1 space-y-6">
                <Link
                    v-if="allPosts.length > 0"
                    v-for="post in allPosts"
                    :key="post.id"
                    :href="`/category/${post.category.slug}/${post.slug}`"
                    class="flex flex-col md:flex-row items-start md:items-center gap-4 border p-4 rounded-lg"
                >
                    <img
                        :src="`/storage/${post.featured_image}`"
                        alt="Post Image"
                        class="w-full md:w-1/3 h-48 object-cover rounded-md"
                    />

                    <div class="flex-1 space-y-3">
                        <p class="text-gray-500 text-sm">
                            {{ post?.date_post }} •
                            {{ post?.category?.name }} •
                            By {{ post?.author?.name || 'Admin' }} •
                            {{ post?.total_comments }}
                        </p>

                        <h2 class="text-xl font-semibold">{{ post.title }}</h2>

                        <p class="text-gray-600">
                            {{ post.description ? post.description.slice(0, 100) : '' }}...
                        </p>

                        <button
                            class="mt-2 px-5 py-2 bg-primary text-white rounded-full hover:bg-secondary hover:text-primary transition"
                        >
                            Read More
                        </button>
                    </div>
                </Link>
                <div v-else class="text-center py-16 bg-white rounded-lg border border-tertiary-dark/10">
                    <h3 class="text-lg font-semibold text-secondary-dark mb-2">No posts found</h3>
                    <p class="text-secondary-light">Try adjusting your search or filters to find what you’re looking
                        for.</p>
                </div>


                <!-- Pagination -->
                <div v-if="posts.data && posts.data.length > 0"
                     class="flex items-center justify-between px-6 py-4 border-t border-tertiary-dark/10 bg-white">
                    <!-- Previous -->
                    <Link
                        v-if="posts.prev_page_url"
                        :href="posts.prev_page_url"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors"
                    >
                        Previous
                    </Link>
                    <span v-else
                          class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Previous</span>

                    <!-- Page info -->
                    <span class="text-sm text-secondary-light">
        Page {{ posts.current_page }} of {{ posts.last_page }}
    </span>

                    <!-- Next -->
                    <Link
                        v-if="posts.next_page_url"
                        :href="posts.next_page_url"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors"
                    >
                        Next
                    </Link>
                    <span v-else class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next</span>
                </div>

            </div>

            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Sidebar (Archives) -->
                    <div class="md:w-full border p-4 rounded-lg h-fit">
                        <h3 class="font-bold mb-3">Archives</h3>
                        <ul class="space-y-2">
                            <li
                                v-for="archive in $page.props.archives"
                                :key="archive.id"
                                class="cursor-pointer text-blue-600 hover:underline"
                            >
                                <Link
                                    :href="`/archive/${archive.slug}`">
                                    {{ archive.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <!-- Categories Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-xl text-gray-800 mb-4 pb-3 border-b border-gray-100">Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            <Link
                                v-for="category in $page.props.categories"
                                :key="category.id"
                                :href="`/category/${category.slug}`"
                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer"
                            >
                                {{ category.name }}
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
import {ref, computed, onMounted} from 'vue'
import {router, Link} from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import SubscriberForNewLetter from '@/Components/DynamicPage/SubscriberForNewLetter.vue'

// Props from backend
const props = defineProps({
    posts: {
        type: Object,
        required: true,
        default: () => ({data: []})
    },
})

// Posts list
const allPosts = computed(() => props.posts.data || [])

</script>

