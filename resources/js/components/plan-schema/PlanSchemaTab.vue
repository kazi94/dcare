<template>
    <div>
        <div class="text-center" v-show="isNotLoaded">
            <b-spinner variant="primary" label="Text Centered"></b-spinner>
        </div>
        <div
            class="row border-alternate justify-content-between"
            v-show="!isNotLoaded"
        >
            <div class="col-md-6 card" v-if="acceptedQuotation.length > 0">
                <div>
                    <payment-modal
                        ref="payment_modal"
                        button-title="Encaisser"
                        :patient="patient"
                        @payment-done="onPaymentDone"
                        :total-to-pay="totalToPay"
                        :quot_id="quot_id"
                    ></payment-modal>
                    <!-- ------------------------ "Actes fait" Section ------------------------- -->
                    <b-button
                        size="sm"
                        variant="success"
                        :hidden="btnDone"
                        class="pull-right mb-1"
                        v-b-modal.modal-acts-done
                    >
                        <b-icon
                            icon="check-circle-fill"
                            aria-hidden="true"
                        ></b-icon>
                        Actes fait
                    </b-button>
                    <!-- Acts done Model -->
                    <b-modal
                        id="modal-acts-done"
                        title="Liste des Actes fait"
                        size="lg"
                        ok-title="Fermer"
                        :ok-only="onlyOk"
                        header-bg-variant="success"
                        header-text-variant="white"
                    >
                        <b-table
                            bordered
                            responsive="sm"
                            small
                            head-variant="light"
                            :items="actsDoneItems"
                            :fields="actsDoneFields"
                        >
                            <template v-slot:cell(index)="data">
                                <!-- data = acceptedQuotation -->
                                {{ data.index + 1 }}
                            </template>
                            <template v-slot:cell(act)="data">{{
                                data.value.nom
                            }}</template>
                            <template v-slot:cell(price)="data">
                                {{ data.item.price }} DA
                            </template>
                        </b-table>
                        <div class="bg-light h5 pull-right text-info">
                            Total des actes faits : {{ total_done }} DA
                        </div>
                    </b-modal>
                    <!-- END Acts done Model -->
                </div>
                <!-- ---------------------- "End Actes fait" Section ----------------------- -->

                <!-- ----------------------------- Tratment PLan table ------------------------------ -->
                <div>
                    <b-table
                        bordered
                        responsive="sm"
                        small
                        head-variant="light"
                        :items="acceptedQuotation"
                        :fields="acceptedQuotationFields"
                        class="text-center"
                    >
                        <template v-slot:cell(act)="data"
                            >{{ data.value.nom }}
                        </template>
                        <template v-slot:cell(price)="data">
                            <b-form-group
                                id="priceid-1"
                                description="Tapez sur Entrée pour modifier le prix."
                                v-if="edit == data.item.id"
                            >
                                <b-form-input
                                    type="text"
                                    v-model="data.item.price"
                                    @keyup.enter="
                                        handlePriceOnKeyUpEnterEvent(
                                            $event,
                                            data
                                        )
                                    "
                                    trim
                                ></b-form-input>
                            </b-form-group>
                            <span v-else @click="edit = data.item.id">
                                <b class="text-info">
                                    {{ data.item.price }} DA
                                </b>
                            </span>
                        </template>
                        <template v-slot:cell(state)="data">
                            <!-- data = acceptedQuotation -->
                            <b-badge
                                pill
                                v-if="data.item.state == 'En cours'"
                                variant="secondary"
                                class="text-light"
                                @click="handleState(data.item)"
                                style="cursor:pointer"
                                >{{ data.item.state }}</b-badge
                            >
                            <b-badge
                                pill
                                v-if="data.item.state == 'A faire'"
                                variant="danger"
                                class="text-light"
                                @click="handleState(data.item)"
                                style="cursor:pointer"
                                >{{ data.item.state }}
                                <i class="fa fa-exclamation-circle"></i>
                            </b-badge>
                            <b-badge
                                pill
                                v-if="data.item.state == 'fait'"
                                variant="success"
                                class="text-light"
                                @click="handleState(data.item)"
                                style="cursor:pointer"
                                >{{ data.item.state }}
                                <i class="fa fa-check-fill"></i
                            ></b-badge>
                        </template>
                        <template v-slot:cell(delete)="data">
                            <b-icon
                                v-b-tooltip.hover.bottom
                                tiltle="Supprimer l'acte dentaire"
                                icon="x-circle"
                                scale="2"
                                variant="danger"
                                style="cursor : pointer"
                                class="text-center"
                                @click="removeLine(data.item)"
                            ></b-icon>
                        </template>
                    </b-table>
                </div>
                <!-- --------------------------- End Table Plan ---------------------------- -->
            </div>
            <div class="row col-md-6 align-items-center" v-else>
                <div class="col">
                    <p class="h2 mb-2 text-center text-secondary">
                        Commencer par sélectionner les actes à faire
                        <b-icon
                            icon="arrow-right"
                            class="rounded-circle bg-success p-2 ml-4"
                            variant="light"
                            font-scale="1.5"
                        ></b-icon>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <b-card>
                    <schema-component
                        :selectedTooth="selectedTooth"
                        :patient="patient"
                        isToothVisible="true"
                        ref="schema"
                    ></schema-component>
                    <category
                        ref="categories"
                        @select-acts="addActsToPlan"
                    ></category>
                </b-card>
                <!-- Display Informations about quotation  -->
                <div class="mt-3 " v-if="total_to_do || total_paid">
                    <b-card>
                        <b-col class="text-center">
                            <p v-if="total_to_do">
                                <span class="font-weight-bolder">TOTAL :</span>
                                <span>{{ total_to_do }} DA</span>
                            </p>
                            <p v-if="total_paid">
                                <span class="font-weight-bolder"
                                    >TOTAL VERSEMENTS:</span
                                >
                                <span>{{ total_paid }} DA</span>
                            </p>
                            <p v-if="total_paid && total_to_do && total_done">
                                <span class="font-weight-bolder">RESTE :</span>
                                <span>
                                    {{
                                        total_to_do - total_done - total_paid
                                    }}
                                    DA
                                </span>
                            </p>
                        </b-col>
                    </b-card>
                </div>
                <!-- End Display Informations about quotation -->
            </div>
        </div>
    </div>
</template>

<script src="./script.js"></script>

<style></style>
