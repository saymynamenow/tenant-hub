import axios from "axios";
import api from "../axios";

export function useProductService() {
    const API_BASE_URL = "/products";

    const fetchProducts = async () => {
        try {
            const response = await api.get(API_BASE_URL, {
                withCredentials: true,
            });
            return response.data.products || response.data;
        } catch (error) {
            console.error("Error fetching products:", error);
            throw error;
        }
    };

    const saveProduct = async (productData, productId = null) => {
        try {
            const url = productId
                ? `${API_BASE_URL}/${productId}`
                : API_BASE_URL;
            const method = productId ? "put" : "post";

            const response = await api({
                method,
                url,
                data: productData,
            });
            return response.data;
        } catch (error) {
            console.error("Error saving product:", error);
            throw error;
        }
    };

    const deleteProduct = async (productId) => {
        try {
            const response = await axios.delete(
                `${API_BASE_URL}/${productId}`,
                {
                    withCredentials: true,
                    headers: {
                        Accept: "application/json",
                    },
                }
            );
            return response.data;
        } catch (error) {
            console.error("Error deleting product:", error);
            throw error;
        }
    };

    return {
        fetchProducts,
        saveProduct,
        deleteProduct,
    };
}
