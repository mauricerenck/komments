<template>
  <div class="kommentsPendingCounter">
    <k-headline>Pending Comments</k-headline>
    <div class="count">{{ queuedComments }}</div>
  </div>
</template>

<script>
export default {
  props: {
    queuedComments: Number,
  },
};
</script>

<style>
.kommentsPendingCounter {
  position: relative;
  padding: 1rem;
  background: #fff;
  box-shadow: var(--box-shadow-item);
  text-align: center;
}

.kommentsPendingCounter .count {
  font-size: var(--text-5xl);
}
</style>
