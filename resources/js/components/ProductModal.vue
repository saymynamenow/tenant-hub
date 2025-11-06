<template>
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ product ? "Edit Product" : "Add New Product" }}
                </h2>
                <button
                    @click="$emit('close')"
                    class="text-gray-500 hover:text-gray-700 text-2xl font-light"
                >
                    ×
                </button>
            </div>

            <form @submit.prevent="submitForm" class="space-y-4">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Product Name *</label
                    >
                    <input
                        v-model="formData.name"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="Enter product name"
                    />
                    <span
                        v-if="errors.name"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.name }}</span
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Description *</label
                    >
                    <input
                        v-model="formData.description"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="Enter product description"
                    />
                    <span
                        v-if="errors.description"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.description }}</span
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Slug *</label
                    >
                    <input
                        v-model="formData.slug"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="Enter product slug"
                    />
                    <span
                        v-if="errors.slug"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.slug }}</span
                    >
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <div class="flex gap-2">
                        <select
                            v-model="formData.category_id"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        >
                            <option value="">Select a category</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ cat.icon }} {{ cat.name }}
                            </option>
                        </select>
                        <button
                            type="button"
                            @click="showCategoryForm = true"
                            class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium"
                            title="Create new category"
                        >
                            +
                        </button>
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Price *</label
                    >
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500"
                            >$</span
                        >
                        <input
                            v-model.number="formData.price"
                            type="number"
                            step="0.01"
                            min="0"
                            required
                            class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="0.00"
                        />
                    </div>
                    <span
                        v-if="errors.price"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.price }}</span
                    >
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Stock Quantity *</label
                    >
                    <input
                        v-model.number="formData.stock"
                        type="number"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="0"
                    />
                    <span
                        v-if="errors.stock"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.stock }}</span
                    >
                </div>

                <!-- Image URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Image URL</label
                    >
                    <input
                        v-model="formData.imageUrl"
                        type="url"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="https://example.com/image.jpg"
                    />
                    <span
                        v-if="errors.image_url"
                        class="text-red-500 text-xs mt-1"
                        >{{ errors.image_url }}</span
                    >
                </div>

                <!-- Image Preview -->
                <div v-if="formData.image_url" class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">
                        Preview:
                    </p>
                    <img
                        :src="formData.image_url"
                        :alt="formData.name"
                        class="h-32 w-32 rounded object-cover"
                        @error="errors.image_url = 'Invalid image URL'"
                    />
                </div>

                <!-- Error Message -->
                <div
                    v-if="formError"
                    class="p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm"
                >
                    {{ formError }}
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-6 border-t">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="loading"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <svg
                            v-if="loading"
                            class="animate-spin h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            />
                        </svg>
                        {{ loading ? "Saving..." : "Save Product" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Inline Category Creation Modal -->
    <div
        v-if="showCategoryForm"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[60]"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">
                    Create New Category
                </h3>
                <button
                    @click="showCategoryForm = false"
                    class="text-gray-500 hover:text-gray-700 text-2xl font-light"
                >
                    ×
                </button>
            </div>

            <form @submit.prevent="createCategory" class="space-y-3">
                <!-- Category Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Name *
                    </label>
                    <input
                        v-model="categoryForm.name"
                        type="text"
                        placeholder="e.g., Electronics"
                        @input="generateCategorySlug"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition text-sm"
                        required
                    />
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Slug *
                    </label>
                    <input
                        v-model="categoryForm.slug"
                        type="text"
                        placeholder="auto-generated"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm"
                    />
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description *
                    </label>
                    <textarea
                        v-model="categoryForm.description"
                        placeholder="Brief description"
                        rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition text-sm resize-none"
                        required
                    ></textarea>
                </div>

                <!-- Color and Icon Row -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Color -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Color *
                        </label>
                        <input
                            v-model="categoryForm.color"
                            type="color"
                            class="w-full h-9 border border-gray-300 rounded-lg cursor-pointer"
                        />
                    </div>

                    <!-- Icon Emoji Picker -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Icon *
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                @click="showEmojiPicker = !showEmojiPicker"
                                class="w-full h-9 flex items-center justify-center text-lg bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition cursor-pointer"
                            >
                                {{ categoryForm.icon }}
                            </button>

                            <!-- Emoji Picker Dropdown -->
                            <div
                                v-if="showEmojiPicker"
                                class="absolute top-full left-0 right-0 mt-1 p-2 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-48 overflow-y-auto"
                            >
                                <div class="grid grid-cols-6 gap-1">
                                    <button
                                        v-for="emoji in emojiList"
                                        :key="emoji"
                                        type="button"
                                        @click="
                                            categoryForm.icon = emoji;
                                            showEmojiPicker = false;
                                        "
                                        class="w-8 h-8 flex items-center justify-center text-base hover:bg-gray-100 rounded transition"
                                        :class="
                                            categoryForm.icon === emoji
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
                </div>

                <!-- Error Message -->
                <div
                    v-if="categoryError"
                    class="p-2 bg-red-100 border border-red-400 text-red-700 rounded text-xs"
                >
                    {{ categoryError }}
                </div>

                <!-- Actions -->
                <div class="flex gap-2 pt-4 border-t">
                    <button
                        type="button"
                        @click="showCategoryForm = false"
                        class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition text-sm"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="
                            creatingCategory ||
                            !categoryForm.name ||
                            !categoryForm.slug ||
                            !categoryForm.description
                        "
                        class="flex-1 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1 text-sm"
                    >
                        <svg
                            v-if="creatingCategory"
                            class="animate-spin h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            />
                        </svg>
                        {{ creatingCategory ? "Creating..." : "Create" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, watch, onMounted } from "vue";
import { useCategoryService } from "../composables/useCategoryService";

export default {
    name: "ProductModal",
    props: {
        product: {
            type: Object,
            default: null,
        },
        loading: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["save", "close"],
    setup(props, { emit }) {
        const formData = ref({
            name: "",
            price: "",
            stock: "",
            imageUrl: "",
            description: "",
            category_id: null,
        });

        const categories = ref([]);
        const errors = ref({});
        const formError = ref("");

        // Category creation form
        const showCategoryForm = ref(false);
        const showEmojiPicker = ref(false);
        const creatingCategory = ref(false);
        const categoryError = ref("");

        const categoryForm = ref({
            name: "",
            slug: "",
            description: "",
            color: "#3B82F6",
            icon: "📦",
        });

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
        ];

        const { fetchCategories, createCategory: createCategoryAPI } =
            useCategoryService();

        // Load product data when modal opens
        watch(
            () => props.product,
            (newProduct) => {
                if (newProduct) {
                    formData.value = { ...newProduct };
                } else {
                    formData.value = {
                        name: "",
                        description: "",
                        price: "",
                        stock: "",
                        image_url: "",
                        category_id: null,
                    };
                }
                errors.value = {};
                formError.value = "";
            },
            { immediate: true }
        );

        const loadCategories = async () => {
            try {
                const data = await fetchCategories();
                categories.value = data;
            } catch (error) {
                console.error("Failed to load categories:", error);
            }
        };

        const generateCategorySlug = () => {
            if (!categoryForm.value.name) return;
            categoryForm.value.slug = categoryForm.value.name
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, "")
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-");
        };

        const createCategory = async () => {
            if (
                !categoryForm.value.name.trim() ||
                !categoryForm.value.slug.trim() ||
                !categoryForm.value.description.trim()
            ) {
                categoryError.value = "All fields are required";
                return;
            }

            creatingCategory.value = true;
            categoryError.value = "";

            try {
                const newCategory = await createCategoryAPI(categoryForm.value);
                categories.value.push(newCategory);
                formData.value.category_id = newCategory.id;
                showCategoryForm.value = false;
                resetCategoryForm();
            } catch (error) {
                categoryError.value =
                    error.response?.data?.message ||
                    "Failed to create category";
                console.error("Error creating category:", error);
            } finally {
                creatingCategory.value = false;
            }
        };

        const resetCategoryForm = () => {
            categoryForm.value = {
                name: "",
                slug: "",
                description: "",
                color: "#3B82F6",
                icon: "📦",
            };
            showEmojiPicker.value = false;
            categoryError.value = "";
        };

        const validateForm = () => {
            errors.value = {};

            if (!formData.value.name.trim()) {
                errors.value.name = "Product name is required";
            }

            if (!formData.value.price || formData.value.price <= 0) {
                errors.value.price = "Price must be greater than 0";
            }

            if (formData.value.stock === "" || formData.value.stock < 0) {
                errors.value.stock =
                    "Stock quantity is required and must be non-negative";
            }

            return Object.keys(errors.value).length === 0;
        };

        const submitForm = async () => {
            if (!validateForm()) {
                return;
            }

            try {
                formError.value = "";
                emit("save", { ...formData.value });
            } catch (error) {
                formError.value = error.message || "Failed to save product";
            }
        };

        onMounted(() => {
            loadCategories();
        });

        return {
            formData,
            categories,
            errors,
            formError,
            submitForm,
            showCategoryForm,
            showEmojiPicker,
            creatingCategory,
            categoryError,
            categoryForm,
            emojiList,
            generateCategorySlug,
            createCategory,
            resetCategoryForm,
        };
    },
};
</script>
