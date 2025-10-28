<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import GuestNavBar from "@/Components/GuestPartials/GuestNavBar.vue";
import SocialIcons from "@/Components/GuestPartials/SocialIcons.vue";
import SearchBar from "@/Components/GuestPartials/SearchBar.vue";
</script>

<template>
    <div
        class=""
    >
        <GuestNavBar />
            <slot />

        <section
            class="relative bg-primary px-6 md:px-24 bg-cover bg-center text-secondary py-20">
            <div class="relative py-12 z-10 max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
                <!-- Left Text -->
                <div class="md:w-2/3 space-y-6">
                    <h2 class="text-3xl md:text-3xl font-bold leading-tight text-justify">
                        Fuel our mission with your donations and help us spread faith and community
                    </h2>

                    <div class="space-y-2">
                        <p class="font-semibold">Contact</p>
                        <p>Email: info@dailyreflections.com</p>
                    </div>
                </div>

                <!-- Right Social Icons -->
                <div class="md:w-1/3 flex md:justify-end justify-start gap-4 text-2xl">
                    <SocialIcons />
                </div>
            </div>
        </section>
        <nav class="sticky bg-primary text-secondary px-6 md:px-24 py-6 flex items-center justify-between relative">
            <!-- Center Menu (Desktop) -->
            <ul class="flex space-x-6 text-sm font-medium text-sm">
                <li><Link href="/" class="hover:text-white text-sm">HOME</Link></li>
                <li><Link href="/reflection" class="hover:text-white text-sm">REFLECTIONS</Link></li>
                <li><Link href="/sermons" class="hover:text-white text-sm">SERMONS</Link></li>
                <li><Link href="/saints_of_the_day" class="hover:text-white text-sm">SAINT(S) OF THE DAY</Link></li>
            </ul>

        </nav>
    </div>
</template>
