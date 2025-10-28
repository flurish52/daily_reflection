<template>
    <GuestLayout>
        <div class="px-6 md:px-24 py-6 md:flex">
            <div class="pt-12  px- md:px- max-w-7xl mx-auto  md:pr-12 space-y-6 ">
                <img
                    :src="`/storage/${article?.featured_image}`"
                    alt="Article Image"
                    class="w-full h-64 object-cover rounded-lg"
                />

                <div class="max-w-7xl ">
                    <p class="text-sm text-gray-500">
                        {{ formattedDate }} • {{ article?.author?.name || 'Admin' }} •  {{ article?.category.name }}
                    </p>
                    <h1 class="text-2xl font-bold mt-2">{{ article?.title }}</h1>

                    <div
                        v-html="formattedContent"
                        class="mt-4 text-gray-700 leading-relaxed text-justify space-y-4"
                    ></div>
                    <h3 class="text-base font-semibold text-gray-800">Title</h3>

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
                                v-for="category in categories"
                                :key="category.id"
                                :href="`/category/${category?.slug}`"
                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer"
                            >
                                {{ category?.name }} <br />
                            </Link>
                        </div>
                    </div>
                  <SubscriberForNewLetter />
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link } from "@inertiajs/vue3"
import GuestLayout from '@/Layouts/GuestLayout.vue'
import SubscriberForNewLetter from "@/Components/DynamicPage/SubscriberForNewLetter.vue"

const props = defineProps({
    article: { type: Object, required: true },
    categories: { type: Object, required: true },
})

const article = ref(props.article)

// Format article content to embed YouTube videos and linkify URLs
const formattedContent = computed(() => {
    if (!article.value.content) return ''

    let content = article.value.content

    // Replace YouTube links with iframe players
    content = content.replace(
        /https?:\/\/(?:www\.)?(?:youtube\.com\/(?:watch\?v=|live\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})[^"'<\s]*/g,
        (match, videoId) => `
        <div class="my-6 aspect-video">
            <iframe
                class="w-full h-full rounded-lg"
                src="https://www.youtube.com/embed/${videoId}"
                frameborder="0"
                allowfullscreen
            ></iframe>
        </div>`
    )

    return content
})


// Date formatting
const formattedDate = computed(() => {
    const date = new Date(article.value.created_at)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
})

</script>

<style scoped>
:deep(h1), :deep(h2), :deep(h3), :deep(h4), :deep(h5), :deep(h6) {
    font-weight: 600;
    color: #1f2937;
}

:deep(h1) { font-size: 24px; }
:deep(h2) { font-size: 20px; }
:deep(h3) { font-size: 16px; }
:deep(h4) { font-size: 15px; }
:deep(h5) { font-size: 14px; }
:deep(h6) { font-size: 13px; }

@media (max-width: 640px) {
    :deep(h1) { font-size: 20px; }
    :deep(h2) { font-size: 18px; }
    :deep(h3) { font-size: 15px; }
}
</style>



