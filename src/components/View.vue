<template>
    <k-inside>
        <div class="k-komments-view">
            <k-headline tag="h2">Comments</k-headline>
            <CommentsTable
                :comments="this.queuedKomments"
                :affectedPages="this.affectedPages"
                :webmentions="this.webmentions"
            />

            <div v-if="showMigration">
                <k-headline tag="h2">Converter</k-headline>
                <Converter />
            </div>
        </div>
    </k-inside>
</template>

<script>
export default {
    props: {
        queuedKomments: Object,
        affectedPages: Array,
        webmentions: Boolean,
        showMigration: Boolean,
    },
}
</script>
<style lang="scss">
.k-komments-view {
    h2 {
        font-size: var(--text-3xl);
        margin: 2em 0 1em 0;
    }
}
</style>
