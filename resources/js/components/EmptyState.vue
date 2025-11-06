<template>
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg
            class="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
            />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">
            No products found
        </h3>
        <p class="mt-2 text-gray-600">
            Try adjusting your filters or search criteria, or create your first
            product!
        </p>
    </div>
</template>

<script>
export default {
    name: "EmptyState",
};
</script>
