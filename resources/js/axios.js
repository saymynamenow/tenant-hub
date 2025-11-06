import axios from "axios";

const api = axios.create({
    withCredentials: true,
});

api.get("/sanctum/csrf-cookie");

export default api;
