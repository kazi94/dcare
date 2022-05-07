<template>
    <div>
        <b-tab :title="title" lazy>
            <div class="d-flex mb-2">
                <datepicker
                    placeholder="Date Début"
                    v-model="startDate"
                    name="start-date"
                    class="mr-2"
                ></datepicker>
                <datepicker
                    placeholder="Date Fin"
                    v-model="endDate"
                    name="end-date"
                    class="mr-2"
                ></datepicker>
                <b-select
                    v-model="periodSelected"
                    class="rounded-pill mr-1"
                    size="sm"
                >
                    <b-select-option value="this-week"
                        >Cette semaine</b-select-option
                    >
                    <b-select-option value="last-week"
                        >La semaine précédente</b-select-option
                    >
                    <b-select-option value="current-month"
                        >Ce mois-ci</b-select-option
                    >
                    <b-select-option value="last-month"
                        >Le mois précédent</b-select-option
                    >
                    <b-select-option value="this-year"
                        >Cette année</b-select-option
                    >
                </b-select>
                <b-button
                    variant="outline-success"
                    size="sm"
                    class="rounded-pill font-weight-bolder mr-2"
                    @click="updateChart"
                    >Filtrer</b-button
                >
            </div>
            <slot name="chart-container"></slot>
        </b-tab>
    </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import {
    dateToDay,
    firstDateOfCurrentMonth,
    endDateOfCurrentMonth,
    firstDateOfCurrentYear,
    firstDateOfCurrentWeek,
    firstDateOflastWeek,
    endDateOflastWeek,
    firstDateOflastMonth,
    endDateOflastMonth
} from "@/utils/dateFormatter";

export default {
    props: {
        title: {
            type: String,
            default: "Base"
        }
    },
    components: { Datepicker },
    data() {
        return {
            startDate: firstDateOfCurrentMonth(),
            endDate: dateToDay(new Date()),
            periodSelected: "current-month"
        };
    },
    methods: {
        updateChart() {
            if (this.startDate && this.endDate)
                this.$emit("update-chart", this.period);
        }
    },
    computed: {
        _endDate() {
            return dateToDay(this.endDate);
        },
        _startDate() {
            return dateToDay(this.startDate);
        },
        period() {
            if (this.endDate && this.startDate)
                return this._startDate + ":" + this._endDate;
            return "current-month";
        }
    },
    watch: {
        periodSelected(val) {
            console.log();
            if (val == "current-month") {
                this.startDate = firstDateOfCurrentMonth();
                this.endDate = dateToDay(new Date());
            }

            if (val == "this-year") {
                this.startDate = firstDateOfCurrentYear();
                this.endDate = dateToDay(new Date());
            }
            if (val == "this-week") {
                this.startDate = firstDateOfCurrentWeek();
                this.endDate = dateToDay(new Date());
            }
            if (val == "last-week") {
                this.startDate = firstDateOflastWeek();
                this.endDate = endDateOflastWeek();
            }
            if (val == "last-month") {
                this.startDate = firstDateOflastMonth();
                this.endDate = endDateOflastMonth();
            }
        }
    }
};
</script>
