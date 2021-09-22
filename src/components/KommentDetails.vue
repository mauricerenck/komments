<template>
  <div>
    <k-grid gutter="small">
      <div class="avatar">
        <k-image
          :src="komment.image"
          ratio="1/1"
          :crop="true"
          v-if="komment.image"
        />
      </div>

      <div class="komment-info">
        <div>
          <k-icon type="account" />
          <strong>{{ komment.author }}</strong>
        </div>
        <div class="light">
          <k-icon type="calendar" />
          {{ komment.published }}
        </div>
        <div class="light"><k-icon type="page" /> {{ komment.title }}</div>
      </div>
    </k-grid>

    <div class="actions">
      <k-bar>
        <template slot="left">
          <k-button
            v-if="komment.verified === true"
            theme="positive"
            icon="toggle-on"
            v-on:click="markAsVerified(komment.slug, komment.id, false)"
          >
            Verified
          </k-button>
          <k-button
            v-else
            icon="toggle-off"
            v-bind:disabled="komment.spamlevel > 0"
            v-on:click="markAsVerified(komment.slug, komment.id, true)"
          >
            Verified
          </k-button>

          <k-button
            v-if="komment.spamlevel === 0"
            v-on:click="markAsSpam(komment.slug, komment.id, true)"
            icon="toggle-off"
          >
            Spam
          </k-button>
          <k-button
            v-else
            theme="negative"
            v-on:click="markAsSpam(komment.slug, komment.id, false)"
            icon="toggle-on"
          >
            Spam
          </k-button>

          <k-button
            v-if="komment.status === true"
            class="publish"
            theme="positive"
            icon="toggle-on"
            v-on:click="publish(komment.slug, komment.id, false)"
          >
            Published
          </k-button>
          <k-button
            v-else
            class="publish"
            v-bind:disabled="komment.spamlevel > 0"
            icon="toggle-off"
            v-on:click="publish(komment.slug, komment.id, true)"
          >
            Published
          </k-button>
        </template>
        <template slot="right">
          <k-button
            theme="negative"
            icon="trash"
            @click="$refs.deleteDialog.open()"
          >
            Delete
          </k-button>

          <k-dialog
            ref="deleteDialog"
            button="Delete"
            theme="negative"
            icon="trash"
            @submit="deleteKomment(komment.slug, komment.id, $refs)"
          >
            <k-text>
              Do you really want to delete the comment? This cannot be undone.
            </k-text>
          </k-dialog>
        </template>
      </k-bar>
    </div>

    <div class="text">
      {{ komment.komment }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    komment: Object,
    onMarkAsSpam: Function,
    onMarkAsVerified: Function,
    onMarkAsPublished: Function,
    onDelete: Function,
  },
  methods: {
    markAsSpam(pageSlug, kommentId, isSpam) {
      this.$api
        .post("komments/spam", {
          pageSlug: pageSlug,
          kommentId: kommentId,
          isSpam: isSpam,
        })
        .then(() => {
          this.onMarkAsSpam(isSpam);
        });
    },
    markAsVerified(pageSlug, kommentId, isVerified) {
      console.log(this);
      this.$api
        .post("komments/verify", {
          pageSlug: pageSlug,
          kommentId: kommentId,
          isVerified: isVerified,
        })
        .then(() => {
          this.onMarkAsVerified(isVerified);
        });
    },
    publish(pageSlug, kommentId, isPublished) {
      this.$api
        .post("komments/publish", {
          pageSlug: pageSlug,
          kommentId: kommentId,
          isPublished: isPublished,
        })
        .then(() => {
          this.onMarkAsPublished(isPublished);
        });
    },
    deleteKomment(pageSlug, kommentId, ref) {
      this.$api
        .post("komments/delete", {
          pageSlug: pageSlug,
          kommentId: kommentId,
        })
        .then(() => {
          this.onDelete();
          ref.deleteDialog.close();
        });
    },
  },
};
</script>

<style lang="scss">
.k-komments-view {
  .komment-moderation {
    background: #fff;
    box-shadow: var(--box-shadow-item);
    border: 1px solid var(--color-border);
  }

  .komment-details {
    padding: 1rem;

    .avatar {
      grid-column-start: span 2;

      img {
        border-radius: 5px;
      }
    }

    .k-icon {
      display: inline-block;
    }

    .komment-info {
      grid-column-start: span 10;
      line-height: 1.5;

      .light {
        color: var(--color-text-light);
      }
    }

    .text {
      padding: 1rem;
    }

    .actions {
      padding: 2rem 0;

      .k-button {
        margin-right: 0.5em;
      }

      .k-bar-slot[data-position="right"] {
        text-align: right;
      }
    }
  }

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
}
</style>
