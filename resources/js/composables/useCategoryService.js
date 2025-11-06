import axios from "axios";
import api from "../axios";

export function useCategoryService() {
    const API_BASE_URL = "/categories";

    const fetchCategories = async () => {
        try {
            const response = await api.get(API_BASE_URL, {
                withCredentials: true,
                headers: {
                    Accept: "application/json",
                },
            });
            return response.data.categories || response.data;
        } catch (error) {
            console.error("Error fetching categories:", error);
            throw error;
        }
    };

    const createCategory = async (categoryData) => {
        try {
            const response = await api.post(
                API_BASE_URL,
                { ...categoryData },
                {
                    withCredentials: true,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                }
            );
            return response.data;
        } catch (error) {
            console.error("Error creating category:", error);
            throw error;
        }
    };

    return {
        fetchCategories,
        createCategory,
    };
}
