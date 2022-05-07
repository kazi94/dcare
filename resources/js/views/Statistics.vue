<template>
    <div>
        <div class="app-main__inner" style="padding-top: 15px;">
            <div class="row">
                <div class="col-md-6 col-xl-6" v-if="user.role_id != 3">
                    <div class="card mb-3 widget-content bg-happy-green">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        CAISSE DU JOUR
                                    </div>
                                    <div class="widget-subheading">
                                        Sommes d'argents versés<br />
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div
                                        class="widget-numbers"
                                        v-if="dailyData.totalPayments"
                                    >
                                        {{
                                            numberWithSpaces(
                                                dailyData.totalPayments.total
                                            )
                                        }}
                                        DA
                                    </div>
                                    <div class="widget-numbers" v-else>
                                        0 DA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6" v-if="user.role_id != 3">
                    <div class="card mb-3 widget-content bg-danger">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        CREANCES
                                    </div>
                                    <div class="widget-subheading">
                                        Sommes d'argents en débiteur<br />
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        {{ numberWithSpaces(totalDebtor) }} DA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div>
                        <b-card no-body>
                            <b-tabs
                                card
                                align="right"
                                active-nav-item-class="font-weight-bold text-uppercase text-info"
                            >
                                <base-chart
                                    title="AGE"
                                    @update-chart="
                                        $refs.patient_age_chart.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <patient-age-chart
                                            ref="patient_age_chart"
                                        ></patient-age-chart>
                                    </template>
                                </base-chart>
                                <base-chart
                                    title="SEXE"
                                    @update-chart="
                                        $refs.patient_sexe_chart.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <patient-sexe-chart
                                            ref="patient_sexe_chart"
                                        ></patient-sexe-chart>
                                    </template>
                                </base-chart>
                                <base-chart
                                    title="MOTIVATION"
                                    @update-chart="
                                        $refs.patient_motivation_chart.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <patient-motivation-chart
                                            ref="patient_motivation_chart"
                                        ></patient-motivation-chart>
                                    </template>
                                </base-chart>
                                <template #tabs-start>
                                    <li
                                        role="presentation"
                                        class="nav-item mr-auto"
                                    >
                                        PATIENTS
                                    </li>
                                </template>
                            </b-tabs>
                        </b-card>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div>
                        <b-card no-body>
                            <b-tabs
                                card
                                align="right"
                                active-nav-item-class="font-weight-bold text-uppercase text-info"
                            >
                                <template #tabs-start>
                                    <li
                                        role="presentation"
                                        class="nav-item mr-auto"
                                    >
                                        ACTIVITÉS
                                    </li>
                                </template>
                                <base-chart
                                    title="ACTES"
                                    @update-chart="
                                        $refs.act_chart_table.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <act-chart-table
                                            ref="act_chart_table"
                                        ></act-chart-table>
                                    </template>
                                </base-chart>
                            </b-tabs>
                        </b-card>
                    </div>
                </div>
                <div class="col-sm-6 mt-3">
                    <div>
                        <b-card no-body>
                            <b-tabs
                                card
                                align="right"
                                active-nav-item-class="font-weight-bold text-uppercase text-info"
                            >
                                <template #tabs-start>
                                    <li
                                        role="presentation"
                                        class="nav-item mr-auto"
                                    >
                                        REVENUS
                                    </li>
                                </template>
                                <base-chart
                                    title="TOTAL"
                                    @update-chart="
                                        $refs.revenu_chart.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <revenu-chart
                                            ref="revenu_chart"
                                        ></revenu-chart>
                                    </template>
                                </base-chart>
                                <base-chart
                                    title="CATEGORIES"
                                    @update-chart="
                                        $refs.revenu_category_chart.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <revenu-category-chart
                                            ref="revenu_category_chart"
                                        ></revenu-category-chart>
                                    </template>
                                </base-chart>
                                <base-chart
                                    title="ACTES FAIT"
                                    @update-chart="
                                        $refs.act_revenu_chart_table.updateChart(
                                            arguments
                                        )
                                    "
                                >
                                    <template #chart-container>
                                        <act-revenu-chart-table
                                            ref="act_revenu_chart_table"
                                        ></act-revenu-chart-table>
                                    </template>
                                </base-chart>
                            </b-tabs>
                        </b-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticApi from "@/services/api/statisticApi.js";
import userApi from "@/services/api/userApi.js";
import BaseChart from "@/components/Chart/BaseChart.vue";
import PatientAgeChart from "@/Components/Chart/PatientAgeChart";
import PatientSexeChart from "@/Components/Chart/PatientSexeChart";
import PatientActChart from "@/Components/Chart/PatientActChart";
import ActCategoryChart from "@/Components/Chart/ActCategoryChart";
import RevenuChart from "@/Components/Chart/RevenuChart";
import RevenuCategoryChart from "@/Components/Chart/RevenuCategoryChart";
import PatientCategoryChart from "@/Components/Chart/PatientCategoryChart";
import PatientMotivationChart from "@/Components/Chart/PatientMotivationChart";
import ActChart from "@/Components/Chart/ActChart";
import ActChartTable from "@/Components/Chart/ActChartTable";
import ActRevenuChartTable from "@/components/Chart/ActRevenuChartTable.vue";
export default {
    components: {
        BaseChart,
        ActChartTable,
        ActChart,
        PatientMotivationChart,
        PatientCategoryChart,
        PatientActChart,
        ActCategoryChart,
        RevenuCategoryChart,
        RevenuChart,
        PatientSexeChart,
        PatientAgeChart,
        ActRevenuChartTable
    },
    data() {
        return {
            dailyData: {
                actesNumber: "",
                prescriptionsNumber: "",
                patientsNumber: "",
                totalPayments: ""
            },
            totalDebtor: "",
            user: ""
        };
    },
    methods: {
        async fetchToDayData() {
            const response = await statisticApi.getDailyData();
            this.dailyData = {
                patientsNumber: response.data.patientsNumber,
                prescriptionsNumber: response.data.prescriptionsNumber,
                actesNumber: response.data.actesNumber,
                totalPayments: response.data.totalPayments
            };
        },
        async fetchUser() {
            const response = await userApi.getAuthUser();

            this.user = response.data;
        },
        reset() {
            this.startDate = "";
            this.endDate = "";
            this.sexe = null;
            this.fetchPatients();
        },
        updateChart() {
            if (this.startDate === "" && this.endDate === "") return;
            this.reloadPatients();
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        },
        async fetchTotalDebtor() {
            const response = await statisticApi.getTotalDebtor();
            this.totalDebtor = response.data;
        }
    },

    mounted() {
        //* GET THE DAY DATA
        this.fetchToDayData();

        //* GET TOTAL DEBTOR
        this.fetchTotalDebtor();

        //* GET USERS
        this.fetchUser();
    }
};
</script>

<style lang="scss">
.small {
    max-width: 600px;
    margin: 150px auto;
}
.vdp-datepicker {
    input {
        border: 1px solid #dee2e6 !important;
        border-radius: 50rem !important;
        height: calc(1.8125rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
}
input:focus-visible {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(128 189 255 / 50%);
}
</style>
