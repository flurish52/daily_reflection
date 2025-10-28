<template>
    <nav
        class="sticky top-0 z-50 bg-primary text-secondary px-6 md:px-24 py-6 flex items-center justify-between shadow-md">
        <!-- Logo -->
        <Link href="/" class="text-lg font-semibold hover:text-gray-500">Daily Reflections</Link>

        <!-- Center Menu (Desktop) -->
        <ul v-for="cat in $page.props.categories"
            class="hidden md:flex items-center justify-center text-sm font-medium">

            <li>
                <Link :href="`/category/${cat.slug}`" class="hover:text-gray-500">
                    {{ cat.name.toUpperCase() }}
                </Link>
            </li>

        </ul>

        <!-- Search (Desktop) -->
        <div class="hidden md:block">
            <SearchBar/>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="toggleMenu" class="md:hidden text-secondary focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Overlay -->
        <transition name="fade">
            <div
                v-if="menuOpen"
                class="fixed inset-0 bg-black bg-opacity-50 z-40"
                @click.self="toggleMenu"
            ></div>
        </transition>

        <!-- Sidebar -->
        <transition name="slide">
            <div
                v-if="menuOpen"
                class="fixed top-0 left-0 h-full w-64 bg-primary text-secondary z-50 shadow-lg p-6 md:hidden"
            >
                <ul class="flex flex-col space-y-4 mt-12">
                    <li v-for="(cat, index) in $page.props.categories"
                    >
                        <Link :href="`/category/${cat.slug}`"
                              class="hover:text-white">{{ cat.name.toUpperCase() }}
                        </Link>
                    </li>
                    <li>
                        <SearchBar/>
                    </li>
                </ul>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import {ref} from 'vue'
import SearchBar from './SearchBar.vue'
import {Link} from '@inertiajs/vue3'


const menuOpen = ref(false)
const toggleMenu = () => {
    menuOpen.value = !menuOpen.value
}
</script>

<style scoped>
/* Overlay fade */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Sidebar slide */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}
</style>
