import axios from "axios";

const apiUrl = "/api/statistic/";

const api = {
    async getDailyData() {
        return await axios.get(`${apiUrl}daily-data`);
    },

    async getToDayAppointements() {
        return await axios.get(`${apiUrl}to-day-appointements`);
    },

    /**
     * Get Number of patients by age range
     */
    async countPatientsGroupByAge(period) {
        return await axios.get(`${apiUrl}patients/get-by-age/${period}`);
    },

    /**
     * Get Number of patients by sex
     */
    async countPatientsGroupBySex(period) {
        return await axios.get(`${apiUrl}patients/get-by-sexe/${period}`);
    },
    /**
     * Get Number of patients by act
     */
    async countPatientsGroupByActs(period) {
        return await axios.get(`${apiUrl}patients/get-by-acts/${period}`);
    },
    /**
     * Get Number of patients by motivation
     */
    async countPatientsGroupByMotivations(period) {
        return await axios.get(`${apiUrl}patients/get-by-motivations/${period}`);
    },
    /**
     * Get Number of patients by category
     */
    async countPatientsGroupByCategories(period) {
        return await axios.get(`${apiUrl}patients/get-by-categories/${period}`);
    },
    /**
     * Get Number of patients by sex
     */
    async countActsGroupByTime(period) {
        return await axios.get(`${apiUrl}acts/get-by-time/${period}`);
    },
    /**
     * Get the number of acts done by period
     */
    async countActsDone(period) {
        return await axios.get(`${apiUrl}acts/get-acts-done/${period}`);
    },
    /**
     * Get the total revenue by month
     */
    async countTotalRevenuByMonth(period) {
        return await axios.get(`${apiUrl}payments/get-by-month/${period}`)
    },
    /**
     * Get the total of revenue for each category
     */
    async calculateTotalActsDoneByCategory(period) {
        return await axios.get(`${apiUrl}acts/sum-acts-done-per-category/${period}`)
    },
    /**
     * Get the total revenu per acts done
     */
    async getTotalRevenuPerActDone(period) {
        return await axios.get(`${apiUrl}acts/sum-acts-done/${period}`)
    },
    /**
     * Get Total debtor
     */
    async getTotalDebtor() {
        return await axios.get(`${apiUrl}payments/get-total-debtor`)
    }

}

export default api;