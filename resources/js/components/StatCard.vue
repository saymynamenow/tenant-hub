<template>
    <div class="bg-white rounded-lg shadow p-6 border-l-4" :class="borderColor">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">{{ label }}</p>
                <p class="text-3xl font-bold mt-2" :class="textColor">
                    {{ value }}
                </p>
            </div>
            <div class="p-3 rounded-lg" :class="bgColor">
                <svg
                    class="w-6 h-6 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        v-if="icon === 'package'"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                    />
                    <path
                        v-else-if="icon === 'check-circle'"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <path
                        v-else-if="icon === 'alert-circle'"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <path
                        v-else-if="icon === 'dollar-sign'"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "StatCard",
    props: {
        icon: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        value: {
            type: [String, Number],
            required: true,
        },
        color: {
            type: String,
            default: "blue",
        },
    },
    computed: {
        borderColor() {
            const colors = {
                blue: "border-blue-500",
                green: "border-green-500",
                red: "border-red-500",
                purple: "border-purple-500",
            };
            return colors[this.color] || colors.blue;
        },
        bgColor() {
            const colors = {
                blue: "bg-blue-500",
                green: "bg-green-500",
                red: "bg-red-500",
                purple: "bg-purple-500",
            };
            return colors[this.color] || colors.blue;
        },
        textColor() {
            const colors = {
                blue: "text-blue-600",
                green: "text-green-600",
                red: "text-red-600",
                purple: "text-purple-600",
            };
            return colors[this.color] || colors.blue;
        },
    },
};
</script>
