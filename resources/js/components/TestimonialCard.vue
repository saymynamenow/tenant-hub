<template>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="text-3xl">{{ testimonial.avatar }}</div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900">
                    {{ testimonial.name }}
                </h3>
                <div class="flex gap-1 mt-1">
                    <span
                        v-for="i in testimonial.rating"
                        :key="i"
                        class="text-yellow-400"
                        >★</span
                    >
                </div>
            </div>
        </div>
        <p class="text-gray-600">{{ testimonial.text }}</p>
    </div>
</template>

<script>
export default {
    name: "TestimonialCard",
    props: {
        testimonial: {
            type: Object,
            required: true,
        },
    },
};
</script>
