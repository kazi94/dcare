import axios from "axios";

const API_URL = `/api/patients`;

const patientsApi = {
    async fetchPatientsWithDebt() {
        return await axios.get(`/api/patientss/get-with-debt`);
    },
    async searchPatient(query) {
        return await axios.get('/api/patients/search/' + query + "/with-total-paid");
    },
    /**
     * Filter Patients by name
     */
    async filterPatientsByName(query) {
        return await axios.get('/api/patients/search/' + query);
    }
};

export default patientsApi;