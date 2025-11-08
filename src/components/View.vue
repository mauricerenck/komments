<template>
    <k-panel-inside>
        <div class="k-komments-view">
            <div v-if="showMigration">
                <k-headline tag="h2">Converter</k-headline>
                <Converter :storageType="this.storageType" />
            </div>
            <div v-else>
                <k-headline tag="h2">Comments</k-headline>
                <CommentsTable
                    :comments="this.queuedKomments"
                    :affectedPages="this.affectedPages"
                    :webmentions="this.webmentions"
                    :storageType="this.storageType"
                    :relatedComment="this.relatedComment"
                    :markRelatedComment="markRelatedComment"
                />

                <div v-if="isVerificationEnabled">
                    <k-headline tag="h2">Pending Verifications</k-headline>
                    <TokenTable
                        :queuedVerifications="this.queuedVerifications"
                        :relatedComment="this.relatedComment"
                        :markRelatedComment="markRelatedComment"
                        :verificationTtl="verificationTtl"
                    />
                </div>
            </div>
        </div>
    </k-panel-inside>
</template>

<script>
export default {
    props: {
        queuedKomments: Object,
        affectedPages: Array,
        webmentions: Boolean,
        showMigration: Boolean,
        storageType: String,
        isVerificationEnabled: Boolean,
        queuedVerifications: Object,
        verificationTtl: Number,
    },
    data() {
        return {
            relatedComment: null,
        }
    },
    methods: {
        markRelatedComment(id) {
            this.relatedComment = id
        },
    },
}
</script>
<style lang="css">
.k-komments-view {
    h2 {
        font-size: var(--text-3xl);
        margin: 2em 0 1em 0;
    }
}
</style>
