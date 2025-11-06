import api from "../axios";

export function useCartService() {
    const API_BASE_URL = "/cart";

    const addToCart = async (productId, quantity = 1) => {
        try {
            const response = await api.post(
                `${API_BASE_URL}/add-to-cart`,
                {
                    product_id: productId,
                    quantity: quantity,
                },
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
            console.error("Error adding to cart:", error);
            throw error;
        }
    };

    const fetchCart = async () => {
        try {
            const response = await api.get(`${API_BASE_URL}/view-cart`, {
                withCredentials: true,
                headers: {
                    Accept: "application/json",
                },
            });
            return response.data.cart || response.data;
        } catch (error) {
            console.error("Error fetching cart:", error);
            throw error;
        }
    };

    const updateCartItem = async (itemId, quantity) => {
        try {
            const response = await api.put(
                `${API_BASE_URL}/update-item/${itemId}`,
                {
                    quantity: quantity,
                },
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
            console.error("Error updating cart item:", error);
            throw error;
        }
    };

    const removeFromCart = async (itemId) => {
        try {
            const response = await api.delete(
                `${API_BASE_URL}/remove-item/${itemId}`,
                {
                    withCredentials: true,
                    headers: {
                        Accept: "application/json",
                    },
                }
            );
            return response.data;
        } catch (error) {
            console.error("Error removing from cart:", error);
            throw error;
        }
    };

    const clearCart = async () => {
        try {
            const response = await api.delete(`${API_BASE_URL}/clear-cart`, {
                withCredentials: true,
                headers: {
                    Accept: "application/json",
                },
            });
            return response.data;
        } catch (error) {
            console.error("Error clearing cart:", error);
            throw error;
        }
    };

    return {
        addToCart,
        fetchCart,
        updateCartItem,
        removeFromCart,
        clearCart,
    };
}
