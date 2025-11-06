<template>
    <div
        class="bg-white rounded-lg shadow-md hover:shadow-lg hover:-translate-y-1 transition-all overflow-hidden cursor-pointer"
    >
        <div
            :class="`h-32 flex items-center justify-center text-5xl`"
            :style="{ backgroundColor: category.color }"
            @click="goToCategory(category)"
        >
            {{ category.icon }}
        </div>
        <div class="p-4 text-center">
            <h3 class="font-semibold text-gray-900">{{ category.name }}</h3>
            <p class="text-sm text-gray-600 mt-1">
                {{ category.products_count }} products
            </p>
        </div>
    </div>
</template>

<script>
import { useRouter } from "vue-router";

export default {
    name: "CategoryCard",
    props: {
        category: {
            type: Object,
            required: true,
        },
    },
    setup() {
        const router = useRouter();

        const goToCategory = (category) => {
            router.push({
                path: "/products",
                query: { category: category.id },
            });
        };

        return {
            goToCategory,
        };
    },
};
</script>
