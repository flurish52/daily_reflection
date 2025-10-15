<template>
    <section>
            <div class="md:w-1/3 flex md:justify-end justify-start gap-5">
                <Link href="#" class="hover:opacity-80 transition" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 1 0-11.6 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.2l-.4 3h-1.8v7A10 10 0 0 0 22 12z"/>
                    </svg>
                </Link>

                <Link href="#" class="hover:opacity-80 transition" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 0 1-3.1 1.5A4.4 4.4 0 0 0 22.4.4a9 9 0 0 1-2.8 1.1A4.5 4.5 0 0 0 16 .4a4.5 4.5 0 0 0-4.5 4.5c0 .3 0 .6.1.9A12.8 12.8 0 0 1 1.6.9 4.5 4.5 0 0 0 3 6a4.5 4.5 0 0 1-2-.6v.1a4.5 4.5 0 0 0 3.6 4.4 4.5 4.5 0 0 1-2 .1A4.5 4.5 0 0 0 6.7 14a9 9 0 0 1-5.6 1.9A9 9 0 0 1 0 15.8a12.8 12.8 0 0 0 6.9 2"/>
                    </svg>
                </Link>

                <Link href="#" class="hover:opacity-80 transition" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm4.5-.8a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                </Link>

                <Link href="#" class="hover:opacity-80 transition" aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M20.4 20.4h-3.6v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7h-3.6V9h3.4v1.6h.1c.5-1 1.8-2 3.6-2 3.9 0 4.6 2.5 4.6 5.7v6.1zM5.3 7.4A2.1 2.1 0 1 1 5.3 3a2.1 2.1 0 0 1 0 4.4zM7 20.4H3.6V9H7v11.4z"/>
                    </svg>
                </Link>

                <Link href="#" class="hover:opacity-80 transition" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M10 15l5.2-3L10 9v6zm12-3a9 9 0 0 0-.8-3.8 2.7 2.7 0 0 0-1.9-1.9C17.6 6.8 12 6.8 12 6.8s-5.6 0-7.3.5A2.7 2.7 0 0 0 2.8 8.2 9 9 0 0 0 2 12a9 9 0 0 0 .8 3.8 2.7 2.7 0 0 0 1.9 1.9c1.7.5 7.3.5 7.3.5s5.6 0 7.3-.5a2.7 2.7 0 0 0 1.9-1.9A9 9 0 0 0 22 12z"/>
                    </svg>
                </Link>
            </div>
    </section>


</template>

<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<style scoped>

</style>
