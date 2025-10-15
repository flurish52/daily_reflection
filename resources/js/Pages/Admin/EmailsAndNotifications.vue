<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Email & Notifications</h1>
                        <p class="text-gray-600 mt-2">Manage email templates and system notifications</p>
                    </div>
                    <div class="flex gap-3 mt-4 sm:mt-0">
                        <button
                            @click="openCreateModal('email')"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Email Template
                        </button>
                        <button
                            @click="openCreateModal('notification')"
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Notification
                        </button>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Email Templates</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ emailTemplates.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Notifications</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ notifications.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Templates</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ activeTemplates }}</p>
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
                                <p class="text-sm font-medium text-gray-600">Sent Today</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ sentToday }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button
                                v-for="tab in tabs"
                                :key="tab.id"
                                @click="activeTab = tab.id"
                                class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors"
                                :class="activeTab === tab.id
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            >
                                <div class="flex items-center justify-center gap-2">
                                    <component :is="tab.icon" class="w-5 h-5" />
                                    {{ tab.name }}
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                        {{ tab.count }}
                                    </span>
                                </div>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Email Templates Tab -->
                        <div v-if="activeTab === 'emails'">
                            <!-- Search and Filters -->
                            <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center mb-6">
                                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                                    <div class="relative flex-1 sm:flex-none">
                                        <input
                                            v-model="emailSearchQuery"
                                            type="text"
                                            placeholder="Search email templates..."
                                            class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64 transition-all"
                                        >
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>

                                    <select
                                        v-model="emailStatusFilter"
                                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                        <option value="all">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>

                                    <select
                                        v-model="emailTypeFilter"
                                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                        <option value="all">All Types</option>
                                        <option value="newsletter">Newsletter</option>
                                        <option value="transactional">Transactional</option>
                                        <option value="promotional">Promotional</option>
                                        <option value="system">System</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-3 w-full lg:w-auto">
                                    <button
                                        @click="clearEmailFilters"
                                        class="px-4 py-2.5 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                                    >
                                        Clear Filters
                                    </button>
                                </div>
                            </div>

                            <!-- Email Templates Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div
                                    v-for="template in filteredEmailTemplates"
                                    :key="template.id"
                                    class="bg-white border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300 overflow-hidden"
                                >
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ template.name }}</h3>
                                                <p class="text-gray-600 text-sm">{{ template.description }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full capitalize"
                                                  :class="getStatusClass(template.status)"
                                            >
                                                {{ template.status }}
                                            </span>
                                        </div>

                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Type: <span class="font-medium text-gray-900">{{ template.type }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Updated: {{ formatDate(template.updated_at) }}
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    @click="previewTemplate(template)"
                                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                                    title="Preview Template"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="editTemplate(template)"
                                                    class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                                    title="Edit Template"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="duplicateTemplate(template)"
                                                    class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all duration-200"
                                                    title="Duplicate Template"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button
                                                @click="deleteTemplate(template)"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                title="Delete Template"
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
                            <div v-if="filteredEmailTemplates.length === 0" class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No email templates found</h3>
                                <p class="text-gray-600 mb-4">Try adjusting your search or create a new template</p>
                                <button
                                    @click="openCreateModal('email')"
                                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors"
                                >
                                    Create Email Template
                                </button>
                            </div>
                        </div>

                        <!-- Notifications Tab -->
                        <div v-if="activeTab === 'notifications'">
                            <!-- Search and Filters -->
                            <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center mb-6">
                                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                                    <div class="relative flex-1 sm:flex-none">
                                        <input
                                            v-model="notificationSearchQuery"
                                            type="text"
                                            placeholder="Search notifications..."
                                            class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 w-full sm:w-64 transition-all"
                                        >
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>

                                    <select
                                        v-model="notificationStatusFilter"
                                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                    >
                                        <option value="all">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>

                                    <select
                                        v-model="notificationTypeFilter"
                                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                    >
                                        <option value="all">All Types</option>
                                        <option value="system">System</option>
                                        <option value="user">User</option>
                                        <option value="alert">Alert</option>
                                        <option value="update">Update</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-3 w-full lg:w-auto">
                                    <button
                                        @click="clearNotificationFilters"
                                        class="px-4 py-2.5 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                                    >
                                        Clear Filters
                                    </button>
                                </div>
                            </div>

                            <!-- Notifications List -->
                            <div class="space-y-4">
                                <div
                                    v-for="notification in filteredNotifications"
                                    :key="notification.id"
                                    class="bg-white border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300 overflow-hidden"
                                >
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-start gap-4">
                                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ notification.title }}</h3>
                                                    <p class="text-gray-600 text-sm mb-2">{{ notification.description }}</p>
                                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                                        <span class="px-2 py-1 font-medium rounded-full capitalize"
                                                              :class="getStatusClass(notification.status)"
                                                        >
                                                            {{ notification.status }}
                                                        </span>
                                                        <span class="px-2 py-1 font-medium rounded-full bg-gray-100 text-gray-700 capitalize">
                                                            {{ notification.type }}
                                                        </span>
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Created {{ formatDate(notification.created_at) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    @click="previewNotification(notification)"
                                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                                    title="Preview Notification"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="editNotification(notification)"
                                                    class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                                    title="Edit Notification"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="testNotification(notification)"
                                                    class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                                    title="Test Notification"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button
                                                @click="deleteNotification(notification)"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                title="Delete Notification"
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
                            <div v-if="filteredNotifications.length === 0" class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications found</h3>
                                <p class="text-gray-600 mb-4">Try adjusting your search or create a new notification</p>
                                <button
                                    @click="openCreateModal('notification')"
                                    class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition-colors"
                                >
                                    Create Notification
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Template Modal -->
        <EmailTemplateModal
            :show="showEmailModal"
            :template="selectedTemplate"
            :mode="modalMode"
            @close="closeEmailModal"
            @saved="handleTemplateSaved"
        />

        <!-- Notification Modal -->
        <NotificationModal
            :show="showNotificationModal"
            :notification="selectedNotification"
            :mode="modalMode"
            @close="closeNotificationModal"
            @saved="handleNotificationSaved"
        />

        <!-- Preview Modal -->
        <PreviewModal
            :show="showPreviewModal"
            :content="previewContent"
            :type="previewType"
            @close="closePreviewModal"
        />

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete {{ deleteType === 'email' ? 'Email Template' : 'Notification' }}</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete "{{ itemToDelete?.name || itemToDelete?.title }}"? This action cannot be undone.
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
                            Delete {{ deleteType === 'email' ? 'Template' : 'Notification' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EmailTemplateModal from "@/Components/AdminPanel/EmailsAndNotifications/EmailTemplateModal.vue";
import NotificationsModal from "@/Components/AdminPanel/EmailsAndNotifications/NotificationsModal.vue";
import PreviewModal from "@/Components/AdminPanel/EmailsAndNotifications/PreviewModal.vue";

// Icons for tabs
const EmailIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    `
}

const NotificationIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.79 1.17 5.97 5.97 0 01-3.79-1.17"></path>
        </svg>
    `
}

// Email Templates data
const emailTemplates = ref([
    {
        id: 1,
        name: 'Welcome Email',
        description: 'Sent to new subscribers when they join',
        type: 'transactional',
        status: 'active',
        subject: 'Welcome to Our Community!',
        content: '<p>Hello {name},</p><p>Welcome to our community...</p>',
        created_at: '2024-01-15',
        updated_at: '2024-01-20'
    },
    {
        id: 2,
        name: 'Weekly Newsletter',
        description: 'Weekly updates and featured content',
        type: 'newsletter',
        status: 'active',
        subject: 'This Week\'s Updates & News',
        content: '<p>Here are this week\'s highlights...</p>',
        created_at: '2024-01-10',
        updated_at: '2024-01-17'
    },
    {
        id: 3,
        name: 'Password Reset',
        description: 'Password reset instructions',
        type: 'system',
        status: 'active',
        subject: 'Reset Your Password',
        content: '<p>Click here to reset your password...</p>',
        created_at: '2024-01-08',
        updated_at: '2024-01-08'
    },
    {
        id: 4,
        name: 'Promotional Offer',
        description: 'Special offers and discounts',
        type: 'promotional',
        status: 'inactive',
        subject: 'Special Offer Just for You!',
        content: '<p>Don\'t miss this limited time offer...</p>',
        created_at: '2024-01-05',
        updated_at: '2024-01-12'
    }
])

// Notifications data
const notifications = ref([
    {
        id: 1,
        title: 'New Comment Notification',
        description: 'Notify users when someone comments on their post',
        type: 'user',
        status: 'active',
        content: 'Someone commented on your post: {post_title}',
        trigger: 'comment_created',
        created_at: '2024-01-15'
    },
    {
        id: 2,
        title: 'System Maintenance Alert',
        description: 'Notify users about scheduled maintenance',
        type: 'system',
        status: 'active',
        content: 'System maintenance scheduled for {date}',
        trigger: 'maintenance_scheduled',
        created_at: '2024-01-12'
    },
    {
        id: 3,
        title: 'New Follower Alert',
        description: 'Notify users when they get new followers',
        type: 'user',
        status: 'inactive',
        content: 'You have a new follower: {follower_name}',
        trigger: 'new_follower',
        created_at: '2024-01-10'
    },
    {
        id: 4,
        title: 'Security Update',
        description: 'Important security updates and patches',
        type: 'alert',
        status: 'active',
        content: 'Important security update available',
        trigger: 'security_update',
        created_at: '2024-01-08'
    }
])

// UI States
const activeTab = ref('emails')
const showEmailModal = ref(false)
const showNotificationModal = ref(false)
const showPreviewModal = ref(false)
const showDeleteModal = ref(false)
const selectedTemplate = ref(null)
const selectedNotification = ref(null)
const itemToDelete = ref(null)
const deleteType = ref('email')
const modalMode = ref('create')
const previewContent = ref('')
const previewType = ref('email')

// Search and Filter states
const emailSearchQuery = ref('')
const emailStatusFilter = ref('all')
const emailTypeFilter = ref('all')
const notificationSearchQuery = ref('')
const notificationStatusFilter = ref('all')
const notificationTypeFilter = ref('all')

// Tabs configuration
const tabs = computed(() => [
    {
        id: 'emails',
        name: 'Email Templates',
        icon: EmailIcon,
        count: emailTemplates.value.length
    },
    {
        id: 'notifications',
        name: 'Notifications',
        icon: NotificationIcon,
        count: notifications.value.length
    }
])

// Computed properties
const activeTemplates = computed(() => {
    return emailTemplates.value.filter(template => template.status === 'active').length
})

const sentToday = computed(() => {
    // Mock data - in real app, this would come from API
    return 247
})

const filteredEmailTemplates = computed(() => {
    let filtered = emailTemplates.value

    if (emailSearchQuery.value) {
        const query = emailSearchQuery.value.toLowerCase()
        filtered = filtered.filter(template =>
            template.name.toLowerCase().includes(query) ||
            template.description.toLowerCase().includes(query) ||
            template.subject.toLowerCase().includes(query)
        )
    }

    if (emailStatusFilter.value !== 'all') {
        filtered = filtered.filter(template => template.status === emailStatusFilter.value)
    }

    if (emailTypeFilter.value !== 'all') {
        filtered = filtered.filter(template => template.type === emailTypeFilter.value)
    }

    return filtered
})

const filteredNotifications = computed(() => {
    let filtered = notifications.value

    if (notificationSearchQuery.value) {
        const query = notificationSearchQuery.value.toLowerCase()
        filtered = filtered.filter(notification =>
            notification.title.toLowerCase().includes(query) ||
            notification.description.toLowerCase().includes(query) ||
            notification.content.toLowerCase().includes(query)
        )
    }

    if (notificationStatusFilter.value !== 'all') {
        filtered = filtered.filter(notification => notification.status === notificationStatusFilter.value)
    }

    if (notificationTypeFilter.value !== 'all') {
        filtered = filtered.filter(notification => notification.type === notificationTypeFilter.value)
    }

    return filtered
})

// Methods
const getStatusClass = (status) => {
    const classes = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('en-US', options)
}

const openCreateModal = (type) => {
    if (type === 'email') {
        selectedTemplate.value = null
        modalMode.value = 'create'
        showEmailModal.value = true
    } else {
        selectedNotification.value = null
        modalMode.value = 'create'
        showNotificationModal.value = true
    }
}

const editTemplate = (template) => {
    selectedTemplate.value = { ...template }
    modalMode.value = 'edit'
    showEmailModal.value = true
}

const editNotification = (notification) => {
    selectedNotification.value = { ...notification }
    modalMode.value = 'edit'
    showNotificationModal.value = true
}

const previewTemplate = (template) => {
    previewContent.value = template.content
    previewType.value = 'email'
    showPreviewModal.value = true
}

const previewNotification = (notification) => {
    previewContent.value = notification.content
    previewType.value = 'notification'
    showPreviewModal.value = true
}

const testNotification = async (notification) => {
    try {
        await axios.post(`/notifications/test/${notification.id}`)
        alert('Test notification sent successfully!')
    } catch (error) {
        console.error('Error testing notification:', error)
        alert('Error sending test notification. Please try again.')
    }
}

const duplicateTemplate = (template) => {
    const duplicated = {
        ...template,
        id: Math.max(...emailTemplates.value.map(t => t.id)) + 1,
        name: `${template.name} (Copy)`,
        status: 'inactive'
    }
    emailTemplates.value.push(duplicated)
    alert('Template duplicated successfully!')
}

const deleteTemplate = (template) => {
    itemToDelete.value = template
    deleteType.value = 'email'
    showDeleteModal.value = true
}

const deleteNotification = (notification) => {
    itemToDelete.value = notification
    deleteType.value = 'notification'
    showDeleteModal.value = true
}

const confirmDelete = async () => {
    if (itemToDelete.value) {
        try {
            if (deleteType.value === 'email') {
                await axios.delete(`/email-templates/delete/${itemToDelete.value.id}`)
                emailTemplates.value = emailTemplates.value.filter(t => t.id !== itemToDelete.value.id)
            } else {
                await axios.delete(`/notifications/delete/${itemToDelete.value.id}`)
                notifications.value = notifications.value.filter(n => n.id !== itemToDelete.value.id)
            }

            showDeleteModal.value = false
            itemToDelete.value = null

            alert(`${deleteType.value === 'email' ? 'Template' : 'Notification'} deleted successfully!`)
        } catch (error) {
            console.error('Error deleting item:', error)
            alert('Error deleting item. Please try again.')
        }
    }
}

const closeEmailModal = () => {
    showEmailModal.value = false
    selectedTemplate.value = null
}

const closeNotificationModal = () => {
    showNotificationModal.value = false
    selectedNotification.value = null
}

const closePreviewModal = () => {
    showPreviewModal.value = false
    previewContent.value = ''
}

const handleTemplateSaved = (templateData) => {
    if (modalMode.value === 'create') {
        const newTemplate = {
            ...templateData,
            id: Math.max(...emailTemplates.value.map(t => t.id)) + 1,
            created_at: new Date().toISOString().split('T')[0],
            updated_at: new Date().toISOString().split('T')[0]
        }
        emailTemplates.value.push(newTemplate)
    } else if (modalMode.value === 'edit' && selectedTemplate.value) {
        const index = emailTemplates.value.findIndex(t => t.id === selectedTemplate.value.id)
        if (index !== -1) {
            emailTemplates.value[index] = {
                ...emailTemplates.value[index],
                ...templateData,
                updated_at: new Date().toISOString().split('T')[0]
            }
        }
    }

    closeEmailModal()
}

const handleNotificationSaved = (notificationData) => {
    if (modalMode.value === 'create') {
        const newNotification = {
            ...notificationData,
            id: Math.max(...notifications.value.map(n => n.id)) + 1,
            created_at: new Date().toISOString().split('T')[0]
        }
        notifications.value.push(newNotification)
    } else if (modalMode.value === 'edit' && selectedNotification.value) {
        const index = notifications.value.findIndex(n => n.id === selectedNotification.value.id)
        if (index !== -1) {
            notifications.value[index] = {
                ...notifications.value[index],
                ...notificationData
            }
        }
    }

    closeNotificationModal()
}

const clearEmailFilters = () => {
    emailSearchQuery.value = ''
    emailStatusFilter.value = 'all'
    emailTypeFilter.value = 'all'
}

const clearNotificationFilters = () => {
    notificationSearchQuery.value = ''
    notificationStatusFilter.value = 'all'
    notificationTypeFilter.value = 'all'
}

// Lifecycle
onMounted(() => {
    console.log('Email & Notifications management component mounted')
})
</script>

<style scoped>
/* Smooth transitions for all interactive elements */
button, select, input {
    transition: all 0.2s ease-in-out;
}
</style>
