const apiUrl = "/api/appointements/";

const appointementApi = {
    async updateState(form, id) {
        return await axios.post(`${apiUrl}${id}/update-state`, form);
    },
};

export default appointementApi;