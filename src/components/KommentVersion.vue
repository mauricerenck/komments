<template>
  <div>
    <div v-if="version.error" class="error">
      <k-info-field
        theme="negative"
        label="Sorry"
        text="The current version could not be fetched."
      />
    </div>
    <div v-else class="version-box">
      <div v-if="version.updateAvailable">
        <h4 class="update-available">There is an update available</h4>
        <h3 class="version">{{ version.latest }}</h3>
      </div>
      <div v-else>
        <h4>This plugin is up to date</h4>
      </div>
      <small class="align-center">
        Your installed version is {{ version.local }}
      </small>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    version: Object,
  },
};
</script>

<style lang="scss">
.k-komments-view {
  .version-box {
    position: relative;
    padding: 1rem;
    background: #fff;
    box-shadow: var(--box-shadow-item);
    text-align: center;

    .version {
      font-size: 40px;
      padding: 0.5em 0;
    }

    .update-available {
      color: var(--color-positive);
    }

    .align-center {
      display: block;
      text-align: center;
    }
  }
}
</style>
