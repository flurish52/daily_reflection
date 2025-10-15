<script setup>
import AuthSideLinks from "@/Components/AdminPanel/AuthSideLinks.vue";
import AuthNavBar from "@/Components/AdminPanel/AuthNavBar.vue";
</script>

<template>
    <div>

        <AuthNavBar class="hidden md:block " />
        <div class="min-h-screen bg-gray-100">
            <AuthSideLinks  class="fixed top-0" />
            <main class="md:pl-64">
                <slot />
            </main>
        </div>
    </div>
</template>
