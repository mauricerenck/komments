<template>
  <div>
    <table>
      <tr
        v-for="(komment, index) in queuedKomments"
        :key="index"
        v-on:click="onSelectKomment(komment.id)"
        @keypress="onSelectKomment(komment.id)"
        class="list-item"
        v-bind:class="{
          active: selectedKomment.id === komment.id,
          isSpam: komment.spamlevel > 0,
          isVerified: komment.verified === true,
        }"
      >
        <td>
          <k-icon
            type="bolt"
            v-if="komment.spamlevel > 0"
            title="potential spam comment"
          />
          <k-icon
            type="clock"
            v-else-if="komment.status === false"
            title="pending"
          />
          <k-icon
            type="check"
            v-else-if="komment.status === true"
            title="published"
          />
        </td>
        <td>
          <em v-if="komment.spamlevel > 0">Spam</em>
          <k-image
            :src="komment.image"
            ratio="1/1"
            :crop="true"
            class="avatar"
            v-else-if="komment.image"
          />
        </td>
        <td class="komment-preview">
          <div class="title">
            <span
              v-if="komment.verified === true"
              alt="Verified user"
              title="Verified user"
            >
              ✓
            </span>
            <strong>{{ komment.author }}</strong>
          </div>
          <div class="preview">
            {{ komment.komment.substr(0, 60) + "&hellip;" }}
          </div>
          <div class="targetPage">{{ komment.title }}</div>
        </td>
        <td>{{ komment.published }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    queuedKomments: Array,
    onSelectKomment: Function,
    selectedKomment: Object,
  },
  methods: {},
};
</script>

<style lang="scss">
.k-komments-view {
  .komment-list {
    border-right: 1px solid var(--color-border);
  }

  .komment-preview {
    padding: 1rem;
  }

  .targetPage {
    color: grey;
    font-size: small;
  }

  .answer {
    align-self: end;
    box-shadow: var(--box-shadow-focus);
  }

  table {
    border-collapse: collapse;
  }

  .list-item {
    border-bottom: 1px solid var(--color-border);
    border-left: 3px solid transparent;
    cursor: pointer;

    .avatar {
      display: inline-block;
      width: 50px;

      img {
        border-radius: 5px;
      }
    }

    &.active {
      border-left: 3px solid var(--color-focus);
    }

    &.isSpam {
      background-color: var(--color-negative-outline);
    }

    &:hover,
    &:focus {
      background-color: #efefef;
    }

    td:first-child {
      padding: 0 1rem;
    }
  }
}
</style>
