<template>
  <k-view class="k-kommentviews-view">
    <k-header>Komments</k-header>

    <k-grid gutter="large">
      <!-- first row -->
      <k-column width="3/6">
        <k-headline-field label="In moderation" />
        <QueuedKomments />
      </k-column>
      <k-column width="2/6">
        <k-headline-field label="Marked as spam" />
        <SpamKomments />
      </k-column>
      <k-column width="1/6">
        <k-headline-field label="Support" />
      </k-column>
    </k-grid>
  </k-view>
</template>

<script>
import QueuedKomments from "./Queued.vue";
import SpamKomments from "./Spam.vue";

export default {
  components: {
    QueuedKomments,
    SpamKomments,
  },
};
</script>
