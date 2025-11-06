<template>
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto py-8"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div
                class="border-b border-gray-200 px-6 py-4 sticky top-0 bg-white"
            >
                <h2 class="text-xl font-bold text-gray-900">
                    Create New Category
                </h2>
            </div>

            <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                <form @submit.prevent="handleSubmit" class="space-y-5">
                    <!-- Name Field -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Category Name
                        </label>
                        <input
                            v-model="formData.name"
                            type="text"
                            placeholder="Enter category name"
                            @input="generateSlug"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            required
                        />
                    </div>

                    <!-- Slug Field -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Slug
                        </label>
                        <input
                            v-model="formData.slug"
                            type="text"
                            placeholder="auto-generated-from-name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-gray-50 text-gray-600"
                        />
                        <p class="text-xs text-gray-500 mt-1">
                            Auto-generated from name, can be edited manually
                        </p>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Description
                        </label>
                        <textarea
                            v-model="formData.description"
                            placeholder="Enter category description"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"
                        ></textarea>
                    </div>

                    <!-- Color and Icon Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Color Picker -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Color
                            </label>
                            <div class="flex items-center gap-2">
                                <input
                                    v-model="formData.color"
                                    type="color"
                                    class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer"
                                />
                                <input
                                    v-model="formData.color"
                                    type="text"
                                    placeholder="#3B82F6"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm font-mono"
                                />
                            </div>
                        </div>

                        <!-- Icon Field -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Icon
                            </label>
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    @click="showEmojiPicker = !showEmojiPicker"
                                    class="w-12 h-10 flex items-center justify-center text-2xl bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition cursor-pointer"
                                >
                                    {{ formData.icon }}
                                </button>
                                <div
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm font-medium"
                                >
                                    {{ getEmojiName(formData.icon) }}
                                </div>
                            </div>

                            <!-- Emoji Picker -->
                            <div
                                v-if="showEmojiPicker"
                                class="mt-2 p-3 border border-gray-300 rounded-lg bg-white shadow-lg"
                            >
                                <div
                                    class="grid grid-cols-6 gap-2 max-h-64 overflow-y-auto"
                                >
                                    <button
                                        v-for="emoji in emojiList"
                                        :key="emoji"
                                        type="button"
                                        @click="selectEmoji(emoji)"
                                        class="w-10 h-10 flex items-center justify-center text-xl hover:bg-gray-100 rounded-lg transition cursor-pointer"
                                        :class="
                                            formData.icon === emoji
                                                ? 'bg-blue-100 border border-blue-300'
                                                : ''
                                        "
                                    >
                                        {{ emoji }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Color Preview -->
                    <div
                        v-if="formData.color"
                        class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200"
                    >
                        <div
                            class="w-16 h-16 rounded-lg border-2 border-gray-300"
                            :style="{ backgroundColor: formData.color }"
                        ></div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Color Preview
                            </p>
                            <p class="text-sm text-gray-600 font-mono">
                                {{ formData.color }}
                            </p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex gap-3 justify-end pt-4 border-t border-gray-200"
                    >
                        <button
                            type="button"
                            @click="close"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            :disabled="loading || !formData.name.trim()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                        >
                            <svg
                                v-if="loading"
                                class="w-4 h-4 animate-spin"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                            {{ loading ? "Creating..." : "Create Category" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useCategoryService } from "../composables/useCategoryService";
const { createCategory } = useCategoryService();

export default {
    name: "CategoryModal",
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["save", "close"],
    setup(props, { emit }) {
        const formData = ref({
            name: "",
            slug: "",
            description: "",
            color: "#3B82F6",
            icon: "📦",
        });

        const showEmojiPicker = ref(false);

        const emojiList = [
            "📦",
            "🏪",
            "🛍️",
            "🎁",
            "💝",
            "👕",
            "👗",
            "👠",
            "👜",
            "🧢",
            "📱",
            "💻",
            "⌚",
            "🎧",
            "📷",
            "🎮",
            "🎯",
            "🎪",
            "🎨",
            "🎭",
            "📚",
            "📖",
            "✏️",
            "📝",
            "🖊️",
            "🍕",
            "🍔",
            "🍜",
            "🍱",
            "🍰",
            "☕",
            "🍷",
            "🍹",
            "🧃",
            "🍦",
            "⚽",
            "🏀",
            "🎾",
            "🏐",
            "⛳",
            "🚗",
            "🚕",
            "🚙",
            "🚌",
            "🚎",
            "✈️",
            "🚁",
            "🚂",
            "🚢",
            "⛵",
            "🌟",
            "💎",
            "💍",
            "👑",
            "🏆",
            "❤️",
            "💚",
            "💙",
            "💛",
            "🧡",
            "🌈",
            "☀️",
            "🌙",
            "⭐",
            "✨",
            "🎀",
            "🎗️",
            "🎊",
            "🎉",
            "🎈",
            "🔥",
            "💥",
            "⚡",
            "🌊",
            "❄️",
        ];

        const emojiNames = {
            "📦": "Package",
            "🏪": "Store",
            "🛍️": "Shopping Bags",
            "🎁": "Gift",
            "💝": "Heart with Ribbon",
            "👕": "T-Shirt",
            "👗": "Dress",
            "👠": "High Heel",
            "👜": "Handbag",
            "🧢": "Cap",
            "📱": "Mobile Phone",
            "💻": "Laptop",
            "⌚": "Watch",
            "🎧": "Headphones",
            "📷": "Camera",
            "🎮": "Video Game",
            "🎯": "Target",
            "🎪": "Circus Tent",
            "🎨": "Palette",
            "🎭": "Theater",
            "📚": "Books",
            "📖": "Book",
            "✏️": "Pencil",
            "📝": "Memo",
            "🖊️": "Pen",
            "🍕": "Pizza",
            "🍔": "Burger",
            "🍜": "Ramen",
            "🍱": "Bento Box",
            "🍰": "Cake",
            "☕": "Coffee",
            "🍷": "Wine",
            "🍹": "Cocktail",
            "🧃": "Juice",
            "🍦": "Ice Cream",
            "⚽": "Soccer Ball",
            "🏀": "Basketball",
            "🎾": "Tennis",
            "🏐": "Volleyball",
            "⛳": "Golf",
            "🚗": "Car",
            "🚕": "Taxi",
            "🚙": "SUV",
            "🚌": "Bus",
            "🚎": "Trolleybus",
            "✈️": "Airplane",
            "🚁": "Helicopter",
            "🚂": "Train",
            "🚢": "Ship",
            "⛵": "Sailboat",
            "🌟": "Star",
            "💎": "Diamond",
            "💍": "Ring",
            "👑": "Crown",
            "🏆": "Trophy",
            "❤️": "Red Heart",
            "💚": "Green Heart",
            "💙": "Blue Heart",
            "💛": "Yellow Heart",
            "🧡": "Orange Heart",
            "🌈": "Rainbow",
            "☀️": "Sun",
            "🌙": "Moon",
            "⭐": "Star",
            "✨": "Sparkles",
            "🎀": "Ribbon",
            "🎗️": "Badge",
            "🎊": "Confetti",
            "🎉": "Party Popper",
            "🎈": "Balloon",
            "🔥": "Fire",
            "💥": "Explosion",
            "⚡": "Lightning",
            "🌊": "Ocean Wave",
            "❄️": "Snowflake",
        };

        const generateSlug = () => {
            if (!formData.value.name) return;
            formData.value.slug = formData.value.name
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, "")
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-");
        };

        const selectEmoji = (emoji) => {
            formData.value.icon = emoji;
            showEmojiPicker.value = false;
        };

        const getEmojiName = (emoji) => {
            return emojiNames[emoji] || "Select emoji";
        };

        const handleSubmit = async () => {
            if (!formData.value.name.trim()) return;
            try {
                await createCategory({ ...formData.value });
                emit("save");
                await resetForm();
            } catch (error) {
                console.error("Failed to create category:", error);
            }
        };

        const resetForm = () => {
            formData.value = {
                name: "",
                slug: "",
                description: "",
                color: "#3B82F6",
                icon: "📦",
            };
            showEmojiPicker.value = false;
        };

        const close = () => {
            resetForm();
            emit("close");
        };

        return {
            formData,
            showEmojiPicker,
            emojiList,
            handleSubmit,
            close,
            generateSlug,
            selectEmoji,
            getEmojiName,
        };
    },
};
</script>
