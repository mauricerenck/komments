<template>
  <k-view class="k-kommentviews-view">
    <k-header>Komments</k-header>

    <k-column width="1/2">
    <QueuedKomments />
    </k-column>
  </k-view>
</template>

<script>

import QueuedKomments from "./Queued.vue";

export default {
    components: {
        QueuedKomments
    }
};

</script>