<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Landing Page Sections</h1>
                        <p class="text-gray-600 mt-2">Manage and customize your landing page sections</p>
                    </div>
                    <button
                        @click="newSection"
                        class="mt-4 sm:mt-0 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Section
                    </button>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Sections</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ sections.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Sections</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ activeSections }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">With Images</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ sectionsWithImages }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">With Buttons</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ sectionsWithButtons }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sections List -->
                <div v-if="!showForm" class="space-y-6">
                    <div
                        v-for="section in sections"
                        :key="section.id"
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4 flex-1">
                                    <!-- Section Preview -->
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center flex-shrink-0">
                                        <div
                                            v-if="section.image"
                                            class="w-full h-full bg-cover bg-center"
                                            :style="{ backgroundImage: `url(${section.image})` }"
                                        ></div>
                                        <svg v-else class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                        </svg>
                                    </div>

                                    <!-- Section Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ section.title }}</h3>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full capitalize"
                                                :class="section.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                            >
                                                {{ section.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>

                                        <!-- Display formatted content -->
                                        <div class="text-gray-600 text-sm mb-3 line-clamp-2" v-html="section.content"></div>

                                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                {{ section.layout_type }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                </svg>
                                                {{ section.background_type }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                Order: {{ section.order }}
                                            </span>
                                            <span v-if="section.button_text" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                Button: {{ section.button_text }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2 ml-4">
                                    <!-- Edit Button -->
                                    <button
                                        @click="editSection(section)"
                                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200"
                                        title="Edit Section"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Toggle Active Button -->
                                    <button
                                        @click="toggleActive(section)"
                                        class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                        :title="section.is_active ? 'Deactivate Section' : 'Activate Section'"
                                    >
                                        <svg v-if="section.is_active" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button
                                        @click="deleteSection(section.id)"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                        title="Delete Section"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="sections.length === 0" class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No sections created yet</h3>
                        <p class="text-gray-600 mb-4">Start by creating your first landing page section</p>
                        <button
                            @click="newSection"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors"
                        >
                            Create First Section
                        </button>
                    </div>
                </div>

                <!-- Section Form -->
                <div v-else class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Form Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ editingSection.id ? 'Edit Section' : 'Create New Section' }}
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">Configure your landing page section settings</p>
                    </div>

                    <!-- Form Body -->
                    <div class="p-6">
                        <form @submit.prevent="saveSection">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Left Column - Basic Information -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>

                                    <!-- Title Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Section Title <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="editingSection.title"
                                            type="text"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="Enter section title"
                                        >
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Subtitle
                                        </label>
                                        <input
                                            v-model="editingSection.subtitle"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="Enter section subtitle (optional)"
                                        >
                                    </div>

                                    <!-- Rich Text Editor for Content -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Content <span class="text-red-500">*</span>
                                        </label>
                                        <div class="border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                                            <!-- Toolbar -->
                                            <div class="border-b border-gray-200 bg-gray-50 p-2 flex flex-wrap gap-1">
                                                <button
                                                    type="button"
                                                    @click="formatText('bold')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Bold"
                                                >
                                                    B
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="formatText('italic')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Italic"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 5h10M7 19h10m-5-14L9 19"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="formatText('underline')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Underline"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21h14M5 3v7a7 7 0 0014 0V3"></path>
                                                    </svg>
                                                </button>
                                                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                                <button
                                                    type="button"
                                                    @click="formatText('insertUnorderedList')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Bullet List"
                                                >
                                                   o
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="formatText('insertOrderedList')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Numbered List"
                                                >
                                                   123
                                                </button>
                                                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                                <button
                                                    type="button"
                                                    @click="formatText('justifyLeft')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Align Left"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h16M3 12h16m-7 6h7"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="formatText('justifyCenter')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Align Center"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="formatText('justifyRight')"
                                                    class="p-2 rounded hover:bg-gray-200 transition-colors"
                                                    title="Align Right"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h16M3 12h16m-7 6h7"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Content Editable Area -->
                                            <div
                                                ref="contentEditor"
                                                contenteditable="true"
                                                style="direction: ltr; unicode-bidi: plaintext; text-align: left;"
                                                @input="updateContent"
                                                @paste="handlePaste"
                                                class="min-h-[120px] p-3 focus:outline-none prose max-w-none"
                                            ></div>

                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Supports rich text formatting, bold, italic, lists, and more</p>
                                    </div>

                                    <!-- Order Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Display Order <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model.number="editingSection.order"
                                            type="number"
                                            required
                                            min="1"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="Enter display order"
                                        >
                                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first on the page</p>
                                    </div>
                                </div>

                                <!-- Right Column - Design & Actions -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Design & Actions</h3>

                                    <!-- Layout Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Layout Type <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="editingSection.layout_type"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                        >
                                            <option value="text_left_image_right">Text Left, Image Right</option>
                                            <option value="image_left_text_right">Image Left, Text Right</option>
                                            <option value="image_top">Image on Top</option>
                                            <option value="image_bottom">Image at Bottom</option>
                                            <option value="centered">Centered Content</option>
                                            <option value="full_width">Full Width Banner</option>
                                        </select>
                                    </div>

                                    <!-- Background Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Background Type <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="editingSection.background_type"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                        >
                                            <option value="none">None (Transparent)</option>
                                            <option value="color">Solid Color</option>
                                            <option value="image">Background Image</option>
                                            <option value="gradient">Gradient</option>
                                        </select>
                                    </div>

                                    <!-- Background Value (Color) -->
                                    <div v-if="editingSection.background_type === 'color'">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Background Color
                                        </label>
                                        <div class="flex items-center gap-3">
                                            <input
                                                v-model="editingSection.background_value"
                                                type="color"
                                                class="w-12 h-12 border border-gray-300 rounded-lg cursor-pointer"
                                            >
                                            <input
                                                v-model="editingSection.background_value"
                                                type="text"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                placeholder="#ffffff"
                                            >
                                        </div>
                                    </div>

                                    <!-- Text Color -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Text Color
                                        </label>
                                        <div class="flex items-center gap-3">
                                            <input
                                                v-model="editingSection.text_color"
                                                type="color"
                                                class="w-12 h-12 border border-gray-300 rounded-lg cursor-pointer"
                                            >
                                            <input
                                                v-model="editingSection.text_color"
                                                type="text"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                placeholder="#000000"
                                            >
                                        </div>
                                    </div>

                                    <!-- Background Image Upload -->
                                    <div v-if="editingSection.background_type === 'image'">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Background Image
                                        </label>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            @change="handleBackgroundImageUpload"
                                            class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                        >

                                        <!-- Background Image Preview -->
                                        <div v-if="editingSection.backgroundPreview" class="mt-3 relative w-full h-32">
                                            <img
                                                :src="editingSection.backgroundPreview"
                                                class="w-full h-full object-cover rounded-lg border"
                                            >
                                            <button
                                                type="button"
                                                @click="editingSection.background_value = ''; editingSection.backgroundPreview = ''"
                                                class="absolute top-1 right-1 bg-white text-gray-600 rounded-full p-1 shadow hover:text-red-600"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Upload background image</p>
                                    </div>

                                    <!-- Gradient CSS -->
                                    <div v-if="editingSection.background_type === 'gradient'">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gradient CSS
                                        </label>
                                        <input
                                            v-model="editingSection.background_value"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="linear-gradient(135deg, #667eea 0%, #764ba2 100%)"
                                        >
                                    </div>

                                    <!-- Section Image Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Section Image
                                        </label>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            @change="handleImageUpload"
                                            class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                        >

                                        <!-- Image Preview -->
                                        <div v-if="editingSection.imagePreview" class="mt-3 relative w-40 h-40">
                                            <img
                                                :src="editingSection.imagePreview"
                                                class="w-full h-full object-cover rounded-lg border"
                                            >
                                            <button
                                                type="button"
                                                @click="editingSection.image = ''; editingSection.imagePreview = ''"
                                                class="absolute top-1 right-1 bg-white text-gray-600 rounded-full p-1 shadow hover:text-red-600"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Upload or replace the section image</p>
                                    </div>

                                    <!-- Button Configuration -->
                                    <div class="space-y-4">
                                        <h4 class="text-md font-medium text-gray-900">Call to Action Button</h4>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Button Text
                                            </label>
                                            <input
                                                v-model="editingSection.button_text"
                                                type="text"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                placeholder="Get Started"
                                            >
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Button Link
                                            </label>
                                            <input
                                                v-model="editingSection.button_link"
                                                type="text"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                placeholder="/signup"
                                            >
                                        </div>
                                    </div>

                                    <!-- Status Toggle -->
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Section Status</p>
                                            <p class="text-xs text-gray-500">Show or hide this section on the landing page</p>
                                        </div>
                                        <button
                                            type="button"
                                            @click="editingSection.is_active = !editingSection.is_active"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            :class="editingSection.is_active ? 'bg-indigo-600' : 'bg-gray-200'"
                                        >
                                            <span
                                                aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="editingSection.is_active ? 'translate-x-5' : 'translate-x-0'"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Footer -->
                            <div class="flex gap-3 justify-end pt-6 border-t border-gray-200 mt-6">
                                <button
                                    type="button"
                                    @click="showForm = false"
                                    class="px-6 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    :disabled="isLoading"
                                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                >
                                    <svg v-if="isLoading" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    {{ isLoading ? 'Saving...' : (editingSection.id ? 'Update Section' : 'Create Section') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Section</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ sectionToDelete?.title }}"? This action cannot be undone.
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
                            Delete Section
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"

// Reactive state
const sections = ref([])
const editingSection = ref(createEmptySection())
const showForm = ref(false)
const showDeleteModal = ref(false)
const isLoading = ref(false)
const sectionToDelete = ref(null)
const contentEditor = ref(null)

// Computed properties for dashboard stats
const activeSections = computed(() => {
    return sections.value.filter(section => section.is_active).length
})

const sectionsWithImages = computed(() => {
    return sections.value.filter(section => section.image).length
})

const sectionsWithButtons = computed(() => {
    return sections.value.filter(section => section.button_text && section.button_text.trim() !== '').length
})

// Helper function to create empty section
function createEmptySection() {
    return {
        id: null,
        title: '',
        subtitle: '',
        content: '',
        image: null,
        background_type: 'none',
        text_color: '#000000',
        background_value: '',
        backgroundPreview: '',
        imagePreview: '',
        layout_type: 'text_left_image_right',
        button_text: '',
        button_link: '',
        order: 0,
        is_active: true
    }
}

// Rich Text Editor Methods
const formatText = (command, value = null) => {
    if (contentEditor.value) {
        // Exec command (bold/italic/etc)
        document.execCommand(command, false, value)
        contentEditor.value.focus()
        // Update our reactive content and try to preserve caret
        updateContent()
        fixEditorTyping()
    }
}

/**
 * updateContent
 * - Clone current selection Range (if any), update editingSection content from DOM,
 *   then try to restore the cloned Range. This avoids using startContainer/startOffset
 *   which can become invalid.
 */
const updateContent = () => {
    if (!contentEditor.value) return

    const sel = window.getSelection()
    let savedRange = null

    try {
        if (sel && sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0).cloneRange()
        }
    } catch (err) {
        // ignore if selection can't be cloned
        savedRange = null
    }

    // Update the reactive content from editor DOM (do NOT set innerHTML here)
    editingSection.value.content = contentEditor.value.innerHTML

    // Try to restore selection
    try {
        if (savedRange) {
            sel.removeAllRanges()
            sel.addRange(savedRange)
        }
    } catch (err) {
        // If we cannot restore (range invalid), put caret at end
        try {
            const range = document.createRange()
            range.selectNodeContents(contentEditor.value)
            range.collapse(false)
            sel.removeAllRanges()
            sel.addRange(range)
        } catch (e) {
            // final fallback: do nothing
        }
    }
}

const handlePaste = (event) => {
    event.preventDefault()

    // Get plain text from clipboard
    const text = event.clipboardData.getData('text/plain')

    // Or get HTML if you want to preserve formatting
    const html = event.clipboardData.getData('text/html')

    // Insert the content at cursor position
    if (html) {
        document.execCommand('insertHTML', false, html)
    } else {
        // insertText keeps plain text and preserves spacing/newlines
        document.execCommand('insertText', false, text)
    }

    // update reactive model and attempt to keep caret
    updateContent()
}

// API methods
const fetchSections = async () => {
    try {
        const response = await axios.get('/admin/landing_sections')
        sections.value = response.data
    } catch (error) {
        console.error('Error fetching sections:', error)
        alert('Error loading sections. Please refresh the page.')
    }
}

const saveSection = async () => {
    isLoading.value = true
    try {
        const formData = new FormData()

        // Append all section data
        Object.keys(editingSection.value).forEach(key => {
            if (key === 'image' && editingSection.value.image instanceof File) {
                formData.append('image', editingSection.value.image)
            } else if (key === 'background_value' && editingSection.value.background_value instanceof File) {
                formData.append('background_value', editingSection.value.background_value)
            } else if (key !== 'backgroundPreview' && key !== 'imagePreview' && key !== 'id') {
                const value = editingSection.value[key]
                // For boolean is_active ensure we send 1/0 instead of "true"/"false" strings
                if (key === 'is_active') {
                    formData.append(key, value ? 1 : 0)
                } else {
                    formData.append(key, value === null ? '' : value)
                }
            }
        })

        let url = '/admin/landing_sections'
        let method = 'post'

        if (editingSection.value.id) {
            url = `/admin/landing_sections/${editingSection.value.id}`
            formData.append('_method', 'PUT')
        }

        await axios({
            method,
            url,
            data: formData,
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        await fetchSections()
        showForm.value = false
        resetEditingSection()
    } catch (error) {
        console.error('Error saving section:', error)
        alert('Error saving section. Please try again.')
    } finally {
        isLoading.value = false
    }
}

const deleteSection = (id) => {
    const section = sections.value.find(s => s.id === id)
    if (section) {
        sectionToDelete.value = section
        showDeleteModal.value = true
    }
}

const confirmDelete = async () => {
    if (!sectionToDelete.value) return

    try {
        await axios.delete(`/admin/landing_sections/${sectionToDelete.value.id}`)
        await fetchSections()
        showDeleteModal.value = false
        sectionToDelete.value = null
    } catch (error) {
        console.error('Error deleting section:', error)
        alert('Error deleting section. Please try again.')
    }
}

const toggleActive = async (section) => {
    try {
        const updatedSection = {
            ...section,
            is_active: !section.is_active
        }

        await axios.patch(`/admin/landing_sections/${section.id}`, {
            is_active: updatedSection.is_active
        })

        // Update local state
        const index = sections.value.findIndex(s => s.id === section.id)
        if (index !== -1) {
            sections.value[index].is_active = updatedSection.is_active
        }
    } catch (error) {
        console.error('Error toggling section:', error)
        alert('Error updating section. Please try again.')
    }
}

// UI methods
const editSection = async (section) => {
    editingSection.value = {
        ...createEmptySection(),
        ...section,
        backgroundPreview: section.background_type === 'image' ? section.background_value : '',
        imagePreview: section.image || ''
    }
    showForm.value = true

    // Wait for the editor to be rendered
    await nextTick()
    if (contentEditor.value) {
        // set innerHTML from the record (do this once, not on every keystroke)
        contentEditor.value.innerHTML = section.content || ''
        fixEditorTyping()
    }
}

const newSection = () => {
    editingSection.value = createEmptySection()
    editingSection.value.order = sections.value.length > 0
        ? Math.max(...sections.value.map(s => s.order)) + 1
        : 1
    showForm.value = true

    // Clear editor content
    nextTick(() => {
        if (contentEditor.value) {
            contentEditor.value.innerHTML = ''
            fixEditorTyping()
        }
    })
}

const resetEditingSection = () => {
    editingSection.value = createEmptySection()
}

// Image handling methods
const compressImage = (file, maxWidth = 1920, quality = 0.8) => {
    return new Promise((resolve) => {
        const img = new Image()
        const reader = new FileReader()

        reader.onload = (e) => {
            img.src = e.target.result
            img.onload = () => {
                const canvas = document.createElement("canvas")
                const scale = Math.min(maxWidth / img.width, 1)
                canvas.width = img.width * scale
                canvas.height = img.height * scale

                const ctx = canvas.getContext("2d")
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height)

                canvas.toBlob(
                    (blob) => resolve(new File([blob], file.name, { type: "image/jpeg" })),
                    "image/jpeg",
                    quality
                )
            }
        }
        reader.readAsDataURL(file)
    })
}

const handleImageUpload = async (event) => {
    const file = event.target.files[0]
    if (!file) return

    try {
        const compressed = await compressImage(file)
        editingSection.value.image = compressed
        editingSection.value.imagePreview = URL.createObjectURL(compressed)
    } catch (error) {
        console.error('Error processing image:', error)
        alert('Error processing image. Please try again.')
    }
}

const handleBackgroundImageUpload = async (event) => {
    const file = event.target.files[0]
    if (!file) return

    try {
        const compressed = await compressImage(file)
        editingSection.value.background_value = compressed
        editingSection.value.backgroundPreview = URL.createObjectURL(compressed)
    } catch (error) {
        console.error('Error processing background image:', error)
        alert('Error processing background image. Please try again.')
    }
}

const fixEditorTyping = () => {
    if (contentEditor.value) {
        // force LTR and friendly text flow styles
        contentEditor.value.setAttribute('dir', 'ltr')
        contentEditor.value.style.direction = 'ltr'
        // use plaintext unicode bidi to avoid browser auto-reshaping
        contentEditor.value.style.unicodeBidi = 'plaintext'
        contentEditor.value.style.textAlign = 'left'
        contentEditor.value.style.whiteSpace = 'pre-wrap'
        contentEditor.value.style.wordBreak = 'break-word'
    }
}

// Lifecycle
onMounted(() => {
    fetchSections()

    // Attach editor behaviours after DOM is ready
    nextTick(() => {
        if (!contentEditor.value) return

        // Make editable and apply initial styles
        contentEditor.value.setAttribute('contenteditable', 'true')
        fixEditorTyping()

        // Handle input and paste events
        // Use input so updateContent runs after DOM is changed by user typing
        contentEditor.value.addEventListener('input', updateContent)
        contentEditor.value.addEventListener('paste', handlePaste)
    })
})
</script>


<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Rich text editor styles */
.prose :deep(p) {
    margin-bottom: 0.5em;
}

.prose :deep(ul) {
    list-style-type: disc;
    margin-left: 1.5em;
    margin-bottom: 0.5em;
}

.prose :deep(ol) {
    list-style-type: decimal;
    margin-left: 1.5em;
    margin-bottom: 0.5em;
}

.prose :deep(strong) {
    font-weight: bold;
}

.prose :deep(em) {
    font-style: italic;
}

.prose :deep(u) {
    text-decoration: underline;
}
</style>
