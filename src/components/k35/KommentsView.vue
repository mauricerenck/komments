<template>
    <k-view class="k-kommentviews-view">
        <k-header>Komments</k-header>

        <k-grid gutter="large">
            <!-- first row -->
            <k-column width="2/4">
                <k-headline-field label="In moderation" />
                <QueuedKomments />
            </k-column>
            <k-column width="1/4">
                <k-headline-field label="Marked as spam" />
                <SpamKomments />
            </k-column>
            <k-column width="1/4">
                <k-headline-field label="Plugin" />
                <Support />
            </k-column>
        </k-grid>
    </k-view>
</template>

<script>
import QueuedKomments from './Queued.vue'
import SpamKomments from './Spam.vue'
import Support from './Support.vue'
export default {
    components: {
        QueuedKomments,
        SpamKomments,
        Support,
    },
}
</script>
