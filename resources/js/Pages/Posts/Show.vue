<template>
    <GuestLayout>
        <div class="flex">
            <div class="pt-12  px-3 md:px-12  max-w-7xl mx-auto p-4 space-y-6 ">
                <img
                    :src="article.image"
                    alt="Article Image"
                    class="w-full h-64 object-cover rounded-lg"
                />

                <div class="max-w-7xl ">
                    <p class="text-sm text-gray-500">
                        {{ formattedDate }} • {{ article.category }}
                    </p>
                    <h1 class="text-2xl font-bold mt-2">{{ article.title }}</h1>

                    <div class="mt-4 text-gray-700 leading-relaxed text-justify">
                        {{ article.content }}
                    </div>
                </div>
            </div>

            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Sidebar (Archives) -->
                    <div class="md:w-full border p-4 rounded-lg h-fit">
                        <h3 class="font-bold mb-3">Archives</h3>
                        <ul class="space-y-2">
                            <li
                                v-for="month in months"
                                :key="month"
                                @click="selectMonth(month)"
                                class="cursor-pointer text-blue-600 hover:underline"
                            >
                                {{ month }}
                            </li>
                        </ul>
                    </div>
                    <!-- Categories Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-xl text-gray-800 mb-4 pb-3 border-b border-gray-100">Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            <Link
                                v-for="category in categories"
                                :key="category"
                                :href="`/category/${category.slug}`"
                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer"
                            >
                                {{ category.name }}
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
import GuestLayout from '@/Layouts/GuestLayout.vue'
import {computed} from 'vue'
import {Link} from "@inertiajs/vue3";
import SubscriberForNewLetter from "@/Components/DynamicPage/SubscriberForNewLetter.vue";

const props = defineProps({
    article: {
        type: Object,
        default: () => ({
            id: 4,
            title: 'Saint Peter of Verona',
            slug: 'saint-peter-of-verona',
            description: 'Story of Saint Peter and his unwavering faith in difficult times.',
            content: 'Lorem ipsum – tekst składający się z łacińskich i quasi-łacińskich wyrazów, mający korzenie w klasycznej łacinie, wzorowany na fragmencie traktatu Cycerona „O granicach dobra i zła” (De finibus bonorum et malorum) napisanego w 45 p.n.e. Tekst jest stosowany do demonstracji krojów pisma (czcionek, fontów), kompozycji kolumny itp. Po raz pierwszy został użyty przez nieznanego drukarza w XVI wieku.\n' +
                '\n' +
                'Tekst w obcym języku pozwala skoncentrować uwagę na wizualnych aspektach tekstu, a nie jego znaczeniu.\n' +
                '\n' +
                'W łacinie niektóre z często występujących w językach nowożytnych liter używane były sporadycznie (k, z), bądź nie było ich wcale (w, j), stąd niektóre wariacje tego tekstu mogą zawierać także wyrazy z tymi literami, aby również i one były zademonstrowane.\n' +
                '\n' +
                'Fragment używany do demonstracji tekstu:\n' +
                '\n' +
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n' +
                'Wersja oryginalna\n' +
                'Oryginalna wersja tekstu Cycerona z pogrubionymi fragmentami używanymi do demonstracji tekstu:\n' +
                '\n' +
                '[32] Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?\n' +
                '[33] At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat',
            image: 'https://i.pinimg.com/1200x/34/af/47/34af474371aa007bc5c07e68a64ae9a6.jpg',
            created_at: '2025-10-05',
            category: 'saint_of_the_day',
        }),
    },
})

const article = props.article

// const months = computed(() => {
//     const list = allPosts.value.map(p => {
//         const d = new Date(p.created_at)
//         return `${d.toLocaleString('default', {month: 'long'})}, ${d.getFullYear()}`
//     })
//     return [...new Set(list)]
// })

// const selectMonth = month => {
//     selectedMonth.value = month
//     currentPage.value = 1
// }
const formattedDate = computed(() => {
    const date = new Date(article.created_at)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
})
const categories = () => [
    { slug: 'reflections', name: 'Reflections' },
    { slug: 'sermons', name: 'Sermons' },
    { slug: 'saints-of-the-day', name: 'Saints of the Day' },
]
</script>

<style scoped>
</style>
