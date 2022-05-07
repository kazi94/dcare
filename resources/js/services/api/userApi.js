import axios from "axios";

const apiUrl = "/api/users/";

const api = {
    async getAuthUser() {
        return await axios.get(`${apiUrl}get-auth-user`);
    },
}

export default api;