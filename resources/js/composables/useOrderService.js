import api from "../axios";

export function useOrderService() {
    const API_BASE_URL = "/orders";

    const getOrders = async () => {
        try {
            const response = await api.get(`${API_BASE_URL}`, {
                withCredentials: true,
                headers: {
                    Accept: "application/json",
                },
            });
            return response.data.orders || [];
        } catch (error) {
            console.error("Error fetching orders:", error);
            throw error;
        }
    };

    const getOrderDetails = async (orderId) => {
        try {
            const response = await api.get(`${API_BASE_URL}/${orderId}`, {
                withCredentials: true,
                headers: {
                    Accept: "application/json",
                },
            });
            return response.data.order;
        } catch (error) {
            console.error("Error fetching order details:", error);
            throw error;
        }
    };

    const updateOrderStatus = async (orderId, status) => {
        try {
            const response = await api.put(
                `${API_BASE_URL}/${orderId}/status`,
                {
                    status: status,
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
            console.error("Error updating order status:", error);
            throw error;
        }
    };

    const getAllAdminOrders = async () => {
        try {
            const response = await api.delete(
                `${API_BASE_URL.replace("/orders", "")}/getallorders`,
                {
                    withCredentials: true,
                    headers: {
                        Accept: "application/json",
                    },
                }
            );
            return response.data.orders || [];
        } catch (error) {
            console.error("Error fetching admin orders:", error);
            throw error;
        }
    };

    return {
        getOrders,
        getOrderDetails,
        updateOrderStatus,
        getAllAdminOrders,
    };
}
