<template>
    <div>
        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center py-20">
            <div
                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
            ></div>
        </div>

        <!-- Requests Table -->
        <div
            v-else
            class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200"
        >
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Business
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Contact
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Submitted
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="request in requests"
                            :key="request.id"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">
                                    {{ request.business_name }}
                                </div>
                                <div
                                    v-if="request.description"
                                    class="text-sm text-gray-500"
                                >
                                    {{
                                        request.description.substring(0, 50)
                                    }}...
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"
                            >
                                {{ request.contact_name }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"
                            >
                                {{ request.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    v-if="request.status === 'pending'"
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800"
                                >
                                    Pending
                                </span>
                                <span
                                    v-else-if="request.status === 'approved'"
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"
                                >
                                    Approved
                                </span>
                                <span
                                    v-else
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800"
                                >
                                    Rejected
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"
                            >
                                {{ formatDate(request.created_at) }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm space-x-2"
                            >
                                <button
                                    v-if="request.status === 'pending'"
                                    @click="openApproveModal(request)"
                                    class="text-green-600 hover:text-green-800 font-medium"
                                >
                                    Approve
                                </button>
                                <button
                                    v-if="request.status === 'pending'"
                                    @click="rejectRequest(request.id)"
                                    class="text-red-600 hover:text-red-800 font-medium"
                                >
                                    Reject
                                </button>
                                <button
                                    @click="deleteRequest(request.id)"
                                    class="text-gray-600 hover:text-gray-800 font-medium"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="requests.length === 0">
                            <td
                                colspan="6"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                No tenant requests found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Approve Modal -->
        <div
            v-if="showApproveModal"
            class="fixed inset-0 z-50 overflow-y-auto"
            @click.self="showApproveModal = false"
        >
            <div class="flex items-center justify-center min-h-screen px-4">
                <div
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
                ></div>
                <div
                    class="relative bg-white rounded-lg max-w-md w-full shadow-xl"
                >
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Approve Tenant Request
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Approving this request will automatically create a
                            tenant account.
                        </p>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Business Name
                                </label>
                                <input
                                    type="text"
                                    :value="currentRequest?.business_name"
                                    disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="approveForm.username"
                                    type="text"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Enter username"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="approveForm.password"
                                    type="password"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Enter password"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Admin Notes (Optional)
                                </label>
                                <textarea
                                    v-model="approveForm.admin_notes"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Add any notes..."
                                ></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button
                                @click="showApproveModal = false"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button
                                @click="approveRequest"
                                :disabled="approving"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50"
                            >
                                {{
                                    approving
                                        ? "Approving..."
                                        : "Approve & Create Tenant"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const requests = ref([]);
const loading = ref(true);
const showApproveModal = ref(false);
const currentRequest = ref(null);
const approving = ref(false);

const approveForm = ref({
    username: "",
    password: "",
    admin_notes: "",
});

const emit = defineEmits(["requestApproved"]);

const loadRequests = async () => {
    loading.value = true;
    try {
        const response = await axios.get("/tenant-requests");
        requests.value = response.data.data || response.data;
    } catch (error) {
        console.error("Failed to load requests:", error);
    } finally {
        loading.value = false;
    }
};

const openApproveModal = (request) => {
    currentRequest.value = request;
    approveForm.value = {
        username: request.business_name.toLowerCase().replace(/\s+/g, ""),
        password: "",
        admin_notes: "",
    };
    showApproveModal.value = true;
};

const approveRequest = async () => {
    if (!approveForm.value.username || !approveForm.value.password) {
        alert("Username and password are required");
        return;
    }

    approving.value = true;
    try {
        await axios.post(
            `/tenant-requests/${currentRequest.value.id}/approve`,
            approveForm.value
        );
        alert("Tenant request approved and tenant created successfully!");
        showApproveModal.value = false;
        currentRequest.value = null;
        await loadRequests();
        emit("requestApproved");
    } catch (error) {
        console.error("Failed to approve request:", error);
        alert(error.response?.data?.message || "Failed to approve request");
    } finally {
        approving.value = false;
    }
};

const rejectRequest = async (id) => {
    if (!confirm("Are you sure you want to reject this request?")) return;

    try {
        await axios.patch(`/tenant-requests/${id}/status`, {
            status: "rejected",
            admin_notes: "Request rejected by admin",
        });
        alert("Request rejected successfully");
        await loadRequests();
    } catch (error) {
        console.error("Failed to reject request:", error);
        alert("Failed to reject request");
    }
};

const deleteRequest = async (id) => {
    if (!confirm("Are you sure you want to delete this request?")) return;

    try {
        await axios.delete(`/tenant-requests/${id}`);
        alert("Request deleted successfully");
        await loadRequests();
    } catch (error) {
        console.error("Failed to delete request:", error);
        alert("Failed to delete request");
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

onMounted(() => {
    loadRequests();
});

defineExpose({ loadRequests });
</script>
