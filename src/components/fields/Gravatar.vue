<template>
  <img :src="value" />
</template>

<script>
export default {
  props: {
    label: String,
    value: String
  }
};
</script>

<style lang="stylus">
img {
  width: 100%;
}
</style>