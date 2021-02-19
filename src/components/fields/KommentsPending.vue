<template>
  <div class="kommentsPendingCounter">
      <k-headline>{{label}}</k-headline>
    <div class="count">{{pendingKomments}}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pendingKomments: 'loading…',
      interval: null,
    };
  },
  created() {
    this.load();
  },
  props: {
    label: String,
  },
  methods: {
    load() {
      this.$api.get("komments/queued").then((komments) => {
        this.pendingKomments = komments.length;
      });
    },
  },
}
</script>

<style>
    .kommentsPendingCounter {
        position: relative;
        padding: 1rem;
        background: #fff;
        box-shadow: var(--box-shadow-item);
        text-align: center;
    }

    .count {
        font-size: var(--font-size-monster);
    }
</style>