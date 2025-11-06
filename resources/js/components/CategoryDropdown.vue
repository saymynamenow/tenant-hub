<template>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <div class="relative">
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <!-- Input for searching/filtering -->
                    <input
                        v-model="searchQuery"
                        type="text"
                        :placeholder="placeholder"
                        @focus="showDropdown = true"
                        @blur="handleBlur"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    />

                    <!-- Dropdown list -->
                    <div
                        v-if="showDropdown"
                        class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-48 overflow-y-auto"
                    >
                        <!-- Existing categories -->
                        <div v-if="filteredCategories.length > 0">
                            <button
                                v-for="category in filteredCategories"
                                :key="category.id"
                                type="button"
                                @click="selectCategory(category)"
                                class="w-full text-left px-4 py-2 hover:bg-blue-50 transition border-b border-gray-100 last:border-b-0"
                            >
                                <span class="text-gray-900">{{
                                    category.name
                                }}</span>
                            </button>
                        </div>

                        <!-- Create new category option -->
                        <div
                            v-if="searchQuery && !categoryExists"
                            class="border-t border-gray-200"
                        >
                            <button
                                type="button"
                                @click="createNewCategory"
                                class="w-full text-left px-4 py-2 hover:bg-green-50 transition text-green-700 font-medium flex items-center gap-2"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                Create "{{ searchQuery }}"
                            </button>
                        </div>

                        <!-- No results -->
                        <div
                            v-if="
                                filteredCategories.length === 0 && !searchQuery
                            "
                            class="px-4 py-2 text-gray-500 text-sm"
                        >
                            No categories available
                        </div>
                    </div>
                </div>

                <!-- Loading indicator -->
                <div v-if="loading" class="flex items-center">
                    <svg
                        class="animate-spin h-5 w-5 text-blue-600"
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
                </div>
            </div>

            <!-- Selected category display -->
            <div
                v-if="modelValue"
                class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between"
            >
                <span class="text-sm text-gray-900">
                    <strong>Selected:</strong> {{ selectedCategoryName }}
                </span>
                <button
                    type="button"
                    @click="clearSelection"
                    class="text-gray-500 hover:text-red-600 transition"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Error message -->
        <div v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { useCategoryService } from "../composables/useCategoryService";

export default {
    name: "CategoryDropdown",
    props: {
        modelValue: {
            type: [String, Number],
            default: null,
        },
        label: {
            type: String,
            default: "Category",
        },
        placeholder: {
            type: String,
            default: "Search or create category...",
        },
        required: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["update:modelValue"],
    setup(props, { emit }) {
        const categories = ref([]);
        const searchQuery = ref("");
        const showDropdown = ref(false);
        const loading = ref(false);
        const error = ref("");

        const { fetchCategories, createCategory } = useCategoryService();

        const filteredCategories = computed(() => {
            if (!searchQuery.value) return categories.value;
            return categories.value.filter((cat) =>
                cat.name.toLowerCase().includes(searchQuery.value.toLowerCase())
            );
        });

        const categoryExists = computed(() => {
            return categories.value.some(
                (cat) =>
                    cat.name.toLowerCase() === searchQuery.value.toLowerCase()
            );
        });

        const selectedCategoryName = computed(() => {
            const category = categories.value.find(
                (cat) => cat.id === props.modelValue
            );
            return category ? category.name : "";
        });

        const loadCategories = async () => {
            loading.value = true;
            try {
                const data = await fetchCategories();
                categories.value = data;
                error.value = "";
            } catch (err) {
                error.value = "Failed to load categories";
                console.error(err);
            } finally {
                loading.value = false;
            }
        };

        const selectCategory = (category) => {
            emit("update:modelValue", category.id);
            searchQuery.value = "";
            showDropdown.value = false;
        };

        const createNewCategory = async () => {
            if (!searchQuery.value.trim()) return;

            loading.value = true;
            try {
                const newCategory = await createCategory(searchQuery.value);
                categories.value.push(newCategory);
                selectCategory(newCategory);
                error.value = "";
            } catch (err) {
                error.value = "Failed to create category";
                console.error(err);
            } finally {
                loading.value = false;
            }
        };

        const clearSelection = () => {
            emit("update:modelValue", null);
            searchQuery.value = "";
        };

        const handleBlur = () => {
            // Delay to allow click on dropdown items
            setTimeout(() => {
                showDropdown.value = false;
            }, 200);
        };

        onMounted(() => {
            loadCategories();
        });

        return {
            categories,
            searchQuery,
            showDropdown,
            loading,
            error,
            filteredCategories,
            categoryExists,
            selectedCategoryName,
            selectCategory,
            createNewCategory,
            clearSelection,
            handleBlur,
        };
    },
};
</script>
