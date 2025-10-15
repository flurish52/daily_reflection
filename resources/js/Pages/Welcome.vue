<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import GuestLayout from "@/Layouts/GuestLayout.vue"
import { Link } from "@inertiajs/vue3"
import HeroSliders from "@/Components/LandingPage/HeroSliders.vue"

const props = defineProps({
    sections: Array,
    slides: Array,
})

const page = usePage()
const sections = computed(() => props.sections || [])
</script>

<template>
    <GuestLayout>
        <HeroSliders :slides="slides"/>

        <div
            v-for="section in sections"
            :key="section.id"
            v-show="section.is_active"
            class="py-12 px-6"
            :style="{
                backgroundColor: section.background_type === 'color' ? section.background_value : '',
                backgroundImage: section.background_type === 'image' ? `url(${section.background_value})` : '',
                backgroundSize: section.background_type === 'image' ? 'cover' : '',
                backgroundPosition: section.background_type === 'image' ? 'center' : '',
                color: section.text_color && section.text_color !== 'light' && section.text_color !== 'dark'
                    ? section.text_color
                    : '',
            }"
        >
            <div
                class="max-w-6xl mx-auto flex gap-10 items-start"
                :class="{
                    'flex-row': section.layout_type === 'image_left_text_right',
                    'flex-row-reverse': section.layout_type === 'text_left_image_right',
                    'flex-col': section.layout_type === 'image_top',
                    'flex-col-reverse': section.layout_type === 'image_bottom',
                    'justify-center text-center flex-col': section.layout_type === 'centered',
                    'flex-col w-full': section.layout_type === 'full_width',
                }"
            >
                <!-- Image -->
                <div
                    v-if="section.image && section.layout_type !== 'full_width'"
                    class="flex justify-center w-full md:w-1/2"
                >
                    <img
                        :src="`${section.image}`"
                        alt="Section image"
                        class="rounded-2xl shadow-lg object-cover w-full h-[400px]"
                    />
                </div>

                <!-- Text Content -->
                <div
                    v-if="section.title || section.content"
                    class="flex-1 space-y-4"
                    :class="section.layout_type === 'centered' ? 'max-w-3xl mx-auto' : ''"
                >
                    <h2
                        v-if="section.title"
                        class="text-3xl font-bold"
                        :class="{
                            'text-white': section.text_color === 'light',
                            'text-gray-900': section.text_color === 'dark',
                        }"
                    >
                        {{ section.title }}
                    </h2>

                    <p
                        v-if="section.subtitle"
                        class="text-lg font-semibold"
                        :class="{
                            'text-gray-100': section.text_color === 'light',
                            'text-gray-700': section.text_color === 'dark',
                        }"
                    >
                        {{ section.subtitle }}
                    </p>

                    <div class="leading-relaxed text-justify" v-html="section.content"></div>

                    <Link
                        v-if="section.button_text && section.button_link"
                        :href="section.button_link"
                        class="inline-block bg-secondary text-primary px-6 py-3 rounded-md font-semibold hover:opacity-90 transition"
                    >
                        {{ section.button_text }}
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
