import api from "../axios";

export function useCheckoutService() {
    const API_BASE_URL = "/orders";

    const checkout = async (checkoutData) => {
        try {
            const response = await api.post(
                `${API_BASE_URL}/checkout`,
                {
                    address: checkoutData.address,
                    payment_method: checkoutData.paymentMethod,
                    idempotency_key: checkoutData.idempotencyKey,
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
            console.error("Error during checkout:", error);
            throw error;
        }
    };

    return {
        checkout,
    };
}
