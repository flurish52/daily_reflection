<template>
    <div
        class="relative px-6 md:px-24 h-[100vh] flex items-center justify-start overflow-hidden   text-secondary py-32"
        :style="{
      backgroundImage: `url(${slides[currentIndex].background_image})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }"
    >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

        <!-- Slide Content -->
        <transition name="fade-slide" mode="out-in">
            <div :key="currentIndex" class="relative leading-loose z-10 text-left md:w-2/3">
                <h1 class="text-4xl md:text-8xl font-bold mb-3 leading-loose">
                    {{ slides[currentIndex].main_text }}
                </h1>
                <p class="text-lg md:text-2xl font-medium mb-6">
                    {{ slides[currentIndex].subtitle }}
                </p>

                <div class="flex justify-start space-x-4">
                    <Link
                        href="/category/reflections"
                        class="bg-secondary text-primary px-6 py-2  p-6 rounded-md font-semibold hover:opacity-90 transition"
                    >
                        REFLECTION
                    </Link>
                    <Link
                        href="/contact"
                        class="border border-secondary px-6 py-2 rounded-md font-semibold hover:bg-secondary hover:text-primary transition"
                    >
                        CONTACT US
                    </Link>
                </div>
            </div>
        </transition>

        <!-- Vertical Indicators -->
        <div class="hidden md:flex flex-col items-center justify-center w-1/3 space-y-4 relative z-10">
            <button
                v-for="(slide, i) in slides"
                :key="i"
                @click="currentIndex = i"
                :class="[
          'w-3 h-3 rounded-full transition',
          i === currentIndex ? 'bg-secondary scale-125' : 'bg-secondary opacity-40'
        ]"
            ></button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    slides: Array,
})

const currentIndex = ref(0)

onMounted(() => {
    setInterval(() => {
        currentIndex.value = (currentIndex.value + 1) % props.slides.length
    }, 5000)
})
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.7s ease;
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>
