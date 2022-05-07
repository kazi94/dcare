import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        globalCategories: [],
        GlobalBasicCoords: [],
        patients: [],
        totalToDo: 0,
        totalPaid: 0,
        totalDone: 0,
        reste: '',
    },

    getters: {

    },

    mutations: {
        affect(state, categories) {
            state.globalCategories = categories;
        },
        storeBasicCoords(state, coords) {
            state.GlobalBasicCoords = coords;
        },
        storePatients(state, patients) {
            state.patients = patients;
        },
        addPatient(state, patient) {
            state.patients.push(patient);
        },
        updateTotalToDo(state, val) {

            state.totalToDo = val;

            // Update the Reste
            state.reste = state.totalToDo + state.totalDone - state.totalPaid;

        },
        updateTotalPaid(state, args) {
            state.totalPaid = args.operation == "increase" ? state.totalPaid + parseInt(args.payment) : state.totalPaid - parseInt(args.payment);

            // Update the Reste
            state.reste = state.totalToDo + state.totalDone - state.totalPaid;

        },
        updateTotalDone(state, val) {

            state.totalDone = val;

            // Update the Reste
            state.reste = state.totalToDo + state.totalDone - state.totalPaid;

        },
        updateReste(state, val) {
            return state.reste = state.totalToDo + state.totalDone - state.totalPaid;
        },
    }
})
