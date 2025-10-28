<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Left side -->
                        <div class="flex items-center space-x-4">
                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ isEditing ? 'Edit Article' : 'New Article' }}
                            </h1>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 rounded-full"
                                     :class="autoSaveStatus === 'saved' ? 'bg-green-400' : autoSaveStatus === 'saving' ? 'bg-yellow-400' : 'bg-gray-300'"></div>
                                <span class="text-sm text-gray-500">
                                    {{ autoSaveText }}
                                </span>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-3">
                            <button
                                @click="saveDraft"
                                :disabled="saving"
                                class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                            >
                                {{ saving ? 'Saving...' : 'Save Draft' }}
                            </button>
                            <button
                                @click="publish"
                                :disabled="saving || !article.title || !content"
                                class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ article.status === 'published' ? 'Update' : 'Publish' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Editor Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Article Title -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <textarea
                                v-model="article.title"
                                placeholder="Article title..."
                                class="w-full text-4xl font-bold text-gray-900 placeholder-gray-400 border-none resize-none overflow-hidden bg-transparent focus:outline-none focus:ring-0"
                                rows="1"
                                ref="titleInput"
                                @input="autoResize"
                            ></textarea>
                        </div>

                        <!-- Article Meta -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ formatDate(article.updated_at || new Date()) }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 rounded-full"
                                         :class="article.status === 'published' ? 'bg-green-500' : 'bg-yellow-500'"></div>
                                    <span class="capitalize">{{ article.status || 'draft' }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ article.author || 'Unknown Author' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rich Text Editor -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <RichTextEditor
                                v-model="article.content"
                                upload-url="/api/upload-image"
                                class="min-h-[600px]"
                            />
                        </div>

                        <!-- Excerpt -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Article Excerpt
                                <span class="text-xs text-gray-500 font-normal">(Brief summary for previews)</span>
                            </label>
                            <textarea
                                v-model="article.excerpt"
                                placeholder="Write a brief excerpt that will appear in article previews..."
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                maxlength="300"
                            ></textarea>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Recommended: 150-300 characters</span>
                                <span>{{ article.excerpt?.length || 0 }}/300</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar - Article Metadata -->
                    <div class="space-y-6">
                        <!-- Publishing Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Publishing Settings</h3>

                            <!-- Status -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select
                                    v-model="article.status"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                >
                                    <option value="draft">Draft</option>
                                    <option value="published">Publish</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                            </div>

                            <!-- Published Date -->
                            <div v-if="article.status === 'scheduled'" class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                                <input
                                    v-model="article.published_at"
                                    type="datetime-local"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                />
                            </div>

                            <!-- Author -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                                <input
                                    v-model="article.author"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Article author"
                                />
                            </div>

                            <!-- Reading Time -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reading Time
                                    (minutes)</label>
                                <input
                                    v-model.number="article.reading_time"
                                    type="number"
                                    min="1"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="5"
                                />
                            </div>
                        </div>

                        <!-- Categories & Tags -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Categories & Tags</h3>

                            <!-- Category -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select
                                    v-model="article.category_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                >
                                    <option value="">Select Category</option>
                                    <option
                                        v-for="cat in $page.props.categories"
                                        :key="cat.id"
                                        :value="cat.id"
                                    >
                                        {{ cat.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                <input
                                    v-model="article.tags_input"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="tag1, tag2, tag3"
                                    @keydown.enter.prevent="addTag"
                                />
                                <p class="text-xs text-gray-500 mt-1">Press Enter to add multiple tags</p>

                                <!-- Tags Display -->
                                <div v-if="article.tags && article.tags.length" class="flex flex-wrap gap-2 mt-2">
                                    <span
                                        v-for="(tag, index) in article.tags"
                                        :key="index"
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                    >
                                        {{ tag }}
                                        <button
                                            type="button"
                                            @click="removeTag(index)"
                                            class="ml-1.5 text-blue-600 hover:text-blue-800"
                                        >
                                            ×
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>

                            <!-- Slug -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                                <input
                                    v-model="article.slug"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="url-slug"
                                />
                                <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from title</p>
                            </div>

                            <!-- Meta Title -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input
                                    v-model="article.meta_title"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="SEO meta title"
                                    maxlength="60"
                                />
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Recommended: 50-60 characters</span>
                                    <span>{{ article.meta_title?.length || 0 }}/60</span>
                                </div>
                            </div>

                            <!-- Meta Description -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea
                                    v-model="article.meta_description"
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm resize-none"
                                    placeholder="SEO meta description"
                                    maxlength="160"
                                ></textarea>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Recommended: 150-160 characters</span>
                                    <span>{{ article.meta_description?.length || 0 }}/160</span>
                                </div>
                            </div>

                            <!-- Focus Keyword -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Focus Keyword</label>
                                <input
                                    v-model="article.focus_keyword"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Primary SEO keyword"
                                />
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <input
                                    type="file"
                                    accept="image/*"
                                    @change="handleFeaturedImageUpload"
                                    class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                />
                                <p class="text-xs text-gray-500 mt-2">Recommended: 1200x630px, max 2MB</p>
                            </div>

                            <!-- Image Preview -->
                            <div v-if="article.featured_image_preview || article.featured_image" class="mt-4">
                                <img
                                    v-if="article.featured_image_preview"
                                    :src="article.featured_image_preview"
                                    class="w-full h-48 object-cover rounded-md border"
                                    alt="Featured image preview"
                                />
                                <img
                                    v-else-if="!article.featured_image_preview && article.featured_image"
                                    :src="`/storage/${article.featured_image}`"
                                    class="w-full h-48 object-cover rounded-md border"
                                    alt="Featured image preview"
                                />
                                <button
                                    type="button"
                                    @click="removeFeaturedImage"
                                    class="mt-2 text-sm text-red-600 hover:text-red-700"
                                >
                                    Remove Image
                                </button>
                            </div>
                        </div>

                        <!-- Article Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Article Settings</h3>

                            <!-- Visibility -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Visibility</label>
                                <select
                                    v-model="article.visibility"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                >
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                    <option value="password">Password Protected</option>
                                </select>
                            </div>

                            <!-- Password (if visibility is password protected) -->
                            <div v-if="article.visibility === 'password'" class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Access Password</label>
                                <input
                                    v-model="article.password"
                                    type="password"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Enter password"
                                />
                            </div>

                            <!-- Allow Comments -->
                            <div class="flex items-center mb-4">
                                <input
                                    v-model="article.allow_comments"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label class="ml-2 block text-sm text-gray-700">Allow comments</label>
                            </div>

                            <!-- Featured Post -->
                            <div class="flex items-center">
                                <input
                                    v-model="article.is_featured"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label class="ml-2 block text-sm text-gray-700">Feature this post</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref, computed, watch, onMounted, nextTick} from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import RichTextEditor from "@/Components/DynamicPage/RichTextEditor.vue"
import {router} from "@inertiajs/vue3";

// Props
const props = defineProps({
    article: Object
})

// Determine editing mode
const isEditing = ref(!!props.article)

// Initialize article with comprehensive metadata
const article = ref({
    // Basic Information
    id: props.article?.id || null,
    title: props.article?.title || '',
    content: props.article?.content || '',
    excerpt: props.article?.excerpt || '',

    // Publishing
    status: props.article?.status || 'draft',
    published_at: props.article?.published_at || null,
    author: props.article?.author || '',
    reading_time: props.article?.reading_time || null,

    // Categories & Tags
    category_id: props.article?.category_id || null,
    tags: props.article?.tags ? (Array.isArray(props.article.tags) ? props.article.tags : props.article.tags.split(',').map(t => t.trim())) : [],
    tags_input: '',

    // SEO
    slug: props.article?.slug || '',
    meta_title: props.article?.meta_title || '',
    meta_description: props.article?.meta_description || '',
    focus_keyword: props.article?.focus_keyword || '',

    // Featured Image
    featured_image: props.article?.featured_image || null,
    featured_image_preview: props.article?.featured_image_url || '',

    // Settings
    visibility: props.article?.visibility || 'public',
    password: props.article?.password || '',
    allow_comments: props.article?.allow_comments !== undefined ? props.article.allow_comments : true,
    is_featured: props.article?.is_featured || false,

    // Timestamps
    created_at: props.article?.created_at || null,
    updated_at: props.article?.updated_at || null
})

// Initialize content ref for editor
const content = ref(article.value.content || '')

// Auto-resize title
const titleInput = ref(null)
const autoResize = () => {
    nextTick(() => {
        if (titleInput.value) {
            titleInput.value.style.height = 'auto'
            titleInput.value.style.height = titleInput.value.scrollHeight + 'px'
        }
    })
}
watch(() => article.value.title, autoResize)

// Auto-save status
const autoSaveStatus = ref('saved')
const autoSaveText = computed(() => {
    switch (autoSaveStatus.value) {
        case 'saving':
            return 'Saving...'
        case 'saved':
            return 'All changes saved'
        case 'error':
            return 'Error saving'
        default:
            return 'Not saved'
    }
})

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    })
}

// Tags management
const addTag = () => {
    if (article.value.tags_input.trim()) {
        const newTag = article.value.tags_input.trim()
        if (!article.value.tags.includes(newTag)) {
            article.value.tags.push(newTag)
        }
        article.value.tags_input = ''
    }
}

const removeTag = (index) => {
    article.value.tags.splice(index, 1)
}

// Featured image handling
const handleFeaturedImageUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB')
            return
        }

        article.value.featured_image = file
        article.value.featured_image_preview = URL.createObjectURL(file)
    }
}

const removeFeaturedImage = () => {
    article.value.featured_image = null
    article.value.featured_image_preview = ''
}

// Save functions
const saving = ref(false)

const saveDraft = async () => {
    await saveArticle('draft')
}

const publish = async () => {
    if (!article.value.title || !content.value) {
        alert('Title and content are required')
        return
    }
    await saveArticle('published')
}

const saveArticle = async (status = null) => {
    saving.value = true
    autoSaveStatus.value = 'saving'

    try {
        const formData = new FormData()

        // Basic Information
        formData.append('title', article.value.title || '')
        formData.append('content', article.value.content || '')
        formData.append('excerpt', article.value.excerpt || '')

        // Publishing
        formData.append('status', status || article.value.status || 'draft')
        if (article.value.published_at) {
            formData.append('published_at', article.value.published_at)
        }
        formData.append('author', article.value.author || '')
        if (article.value.reading_time) {
            formData.append('reading_time', article.value.reading_time)
        }

        // Categories & Tags
        if (article.value.category_id) {
            formData.append('category_id', article.value.category_id)
        }
        formData.append('tags', JSON.stringify(article.value.tags))

        // SEO
        formData.append('slug', article.value.slug || '')
        formData.append('meta_title', article.value.meta_title || '')
        formData.append('meta_description', article.value.meta_description || '')
        formData.append('focus_keyword', article.value.focus_keyword || '')

        // Featured Image
        if (article.value.featured_image instanceof File) {
            formData.append('featured_image', article.value.featured_image)
        }

        // Settings
        formData.append('visibility', article.value.visibility || 'public')
        if (article.value.visibility === 'password') {
            formData.append('password', article.value.password || '')
        }
        formData.append('allow_comments', article.value.allow_comments ? '1' : '0')
        formData.append('is_featured', article.value.is_featured ? '1' : '0')

        // Method for update
        if (isEditing.value) {
            formData.append('_method', 'PUT')
        }

        const url = isEditing.value
            ? `/admin/article/${article.value.id}`
            : '/admin/article'

        const response = await axios.post(url, formData, {
            headers: {'Content-Type': 'multipart/form-data'}
        })

        if (!response?.data) throw new Error('No response data received')

        // Update local state with response data
        if (response.data.data) {
            Object.assign(article.value, response.data.data)
        }
        if(response.data.update_url){
            window.location.href = response.data.update_url
        }

        isEditing.value = true
        autoSaveStatus.value = 'saved'
        if (!isEditing.value) {

            if (status === 'published') {
                alert('Article published successfully!')
            } else {
                alert('Article saved successfully!')
            }
        }

    } catch (error) {
        console.error('Save failed:', error)
        autoSaveStatus.value = 'error'
        alert('Failed to save: ' + (error.response?.data?.message || error.message))
    } finally {
        saving.value = false
    }
}

// Auto-save setup
let autoSaveTimeout
const setupAutoSave = () => {
    watch([() => article.value.title, () => article.value.content], () => {
        if (autoSaveTimeout) clearTimeout(autoSaveTimeout)
        autoSaveStatus.value = 'unsaved'

        autoSaveTimeout = setTimeout(() => {
            if (article.value.title && article.value.content) {
                saveDraft()
            }
        }, 3000)
    })
}

// Auto-generate slug from title
watch(() => article.value.title, (newTitle) => {
    if (!isEditing.value && !article.value.slug) {
        article.value.slug = newTitle
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '')
    }
})

// Auto-generate meta title from title
watch(() => article.value.title, (newTitle) => {
    if (!article.value.meta_title) {
        article.value.meta_title = newTitle
    }
})

// Auto-generate excerpt from content
watch(() => article.value.content, (newContent) => {
    if (!article.value.excerpt && newContent) {
        // Create excerpt from first 150 characters of content (without HTML tags)
        const textContent = newContent.replace(/<[^>]*>/g, '')
        article.value.excerpt = textContent.substring(0, 150) + (textContent.length > 150 ? '...' : '')
    }
})

// Initialize on mounted
onMounted(() => {
    autoResize()
    setupAutoSave()
})
</script>

<style scoped>
/* Custom prose styles for preview */
.prose-content :deep(h1),
.prose-content :deep(h2),
.prose-content :deep(h3),
.prose-content :deep(h4),
.prose-content :deep(h5),
.prose-content :deep(h6) {
    @apply font-semibold text-gray-900 mt-8 mb-4;
}

.prose-content :deep(h1) {
    @apply text-3xl;
}

.prose-content :deep(h2) {
    @apply text-2xl;
}

.prose-content :deep(h3) {
    @apply text-xl;
}

.prose-content :deep(h4) {
    @apply text-lg;
}

.prose-content :deep(p) {
    @apply mb-4 text-gray-700 leading-relaxed;
}

.prose-content :deep(img) {
    @apply rounded-lg shadow-sm my-6;
}

.prose-content :deep(ul),
.prose-content :deep(ol) {
    @apply mb-4 ml-6;
}

.prose-content :deep(li) {
    @apply mb-2;
}

.prose-content :deep(blockquote) {
    @apply border-l-4 border-gray-300 pl-4 italic text-gray-600 my-4;
}

.prose-content :deep(a) {
    @apply text-blue-600 hover:text-blue-800 underline;
}

.prose-content :deep(hr) {
    @apply border-gray-300 my-8;
}
</style>
