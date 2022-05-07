<template>
    <div>
        <b-card class="mb-2" v-show="user.role_id == 3">
            <payment-tab
                :patient="patient"
                :user="user"
                ref="payment"
                :new-payment="newPayment"
            ></payment-tab>
        </b-card>
        <b-card class="mb-2" v-show="user.role_id == 1 || user.role_id == 2">
            <b-tabs
                card
                ref="tab"
                v-model="tabs"
                justified
                @input="getActiveTabID"
                active-nav-item-class="font-weight-bold text-uppercase"
            >
                <b-tab
                    title="Initial"
                    title-link-class="h6"
                    v-if="user.role_id == 1 || user.role_id == 2"
                >
                    <initial-schema-tab
                        :patient="patient"
                        :user="user"
                        @initial-formulas-drawed="onInitialFormulasDrawed"
                        @initial-formula-removed="onInitialFormulaRemoved"
                    ></initial-schema-tab>
                </b-tab>

                <b-tab
                    title="Devis"
                    title-link-class="h6"
                    v-if="user.role_id == 1 || user.role_id == 2"
                    lazy
                >
                    <quot-tab
                        :patient="patient"
                        :user="user"
                        @payment-done="newPayment = $event"
                        @validated-quotation="quotationValidated"
                        ref="quot_tab"
                        @img-fully-loaded="quotTabMounted"
                    ></quot-tab>
                </b-tab>
                <b-tab title="Plan" title-link-class="h6" :active="isActive">
                    <plan-schema-component
                        :patient="patient"
                        :user="user"
                        @payment-done="newPayment = $event"
                        @mounted="planSchemaMounted"
                        ref="plan_tab"
                    ></plan-schema-component>
                </b-tab>
                <b-tab title="Règlements" title-link-class="h6">
                    <payment-tab
                        :patient="patient"
                        :user="user"
                        ref="payment"
                        :new-payment="newPayment"
                        @payment-done="newPayment = $event"
                    ></payment-tab>
                </b-tab>
                <b-tab
                    title="Prescriptions"
                    lazy
                    title-link-class="h6"
                    v-if="user.role_id == 1 || user.role_id == 2"
                >
                    <prescription-tab
                        :patient="patient"
                        :user="user"
                        ref="prescription_tab"
                    ></prescription-tab>
                </b-tab>

                <radiographie-tab
                    ref="radiographie_tab"
                    :patient="patient"
                    :user="user"
                ></radiographie-tab>
            </b-tabs>
        </b-card>
    </div>
</template>

<script>
import InitialSchemaTab from "@/Components/Patient/InitialSchemaTab";
import PlanSchemaComponent from "@/Components/PlanSchema/PlanSchemaTab";
import QuotTab from "@/Components/Patient/Quotation/QuotationTab";
import PaymentTab from "@/Components/Patient/PaymentTab";
import PrescriptionTab from "@/Components/Patient/PrescriptionTab";
import RadiographieTab from "@/Components/Patient/RadiographieTab";
export default {
    components: {
        InitialSchemaTab,
        QuotTab,
        PlanSchemaComponent,
        PaymentTab,
        PrescriptionTab,
        RadiographieTab
    },
    props: ["patient", "showschema", "user"],
    data() {
        return {
            isRadioActive: false,
            isInitialActive: true,
            isPrescriptionActive: false,
            showSchema: false,
            newPayment: null,
            tabs: 0,
            quot: null,
            initschema: []
        };
    },
    methods: {
        getActiveTabID(tabIndex) {
            // console.log("tab index" + tabIndex);
        },
        getPrescription(prescription) {
            this.$refs.prescription_tab.getPrescription(prescription);
        },
        getImage(url) {
            this.isRadioActive = true; // show Radio tab
            this.isInitialActive = false; // hide initial tab
            this.$refs.radiographie_tab.addToGallery(url);
        },
        quotationValidated(quotation) {
            this.quot = quotation;
            this.tabs = 2;
            this.planSchemaMounted();
        },
        planSchemaMounted() {
            if (this.quot) this.$refs.plan_tab.updatePlan(this.quot);
        },
        /**
         * Listen to selected formulas and tooth from initial Schema
         */
        onInitialFormulasDrawed(InitSchemaCoords) {
            // Draw on Quot and Plan Schema

            console.log("this.$refs :>> ", this.$refs);
            console.log("this :>> ", this);
            this.$refs.plan_tab.$refs.schema.$refs.schema_layer.createShapes(
                InitSchemaCoords
            );
            this.initschema = InitSchemaCoords;
        },
        /**
         * Handle detach formula from selected teeth from the parent view
         * update treatment plan and quot schema for deletion
         */
        onInitialFormulaRemoved(args) {
            this.$refs.plan_tab.$refs.schema.$refs.schema_layer.removeShapesByTeeth(
                args.teeth,
                args.formula
            );
        },
        quotTabMounted() {
            console.log("Iamge fully loaded on listen");
            this.$refs.quot_tab.$refs.schema_1.$refs.schema_layer.createShapes(
                this.initschema
            );
        }
    },
    computed: {
        isActive() {
            if (this.user.role_id == 1 || this.user.role_id == 2) return true;
            else return false;
        }
    },
    mounted() {
    }
};
</script>
