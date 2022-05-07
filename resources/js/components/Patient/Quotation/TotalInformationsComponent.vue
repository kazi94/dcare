<template lang="fr">
    <div>
        <b-card class="mt-1">
            <div class="text-center h6">
                    <p class="font-weight-bold alert-dark">
                        Total :
                        <span>{{ total }} DA</span>
                    </p>
                    <p
                        class="font-weight-bold alert-info border-alternate"
                    >
                        Total accepté :
                        <span>{{ total_accept }} DA</span>
                    </p>
                </div>
        </b-card>
    </div>
</template>

<script>
export default {
    props: {
        total: {
            type: Number,
            default: function () {
                return 0;
            },
        },
        total_accept: {
            type: Number,
            default: function () {
                return 0;
            },
        },
    },
};
</script>
