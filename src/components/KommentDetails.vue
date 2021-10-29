<template>
    <div class="komment-moderation">
        <k-grid gutter="medium">
            <k-column width="2/12" class="avatar">
                <img :src="komment.image" v-if="komment.image" />
            </k-column>
            <k-column width="10/12" class="komment-info">
                <div>
                    <strong>{{ komment.author }}</strong>
                </div>
                <div class="meta">
                    {{ komment.published }}
                </div>
                <div class="meta">{{ komment.title }}</div>
            </k-column>
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
                    <k-button theme="negative" icon="trash" @click="$refs.deleteDialog.open()">
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
                .post('komments/spam', {
                    pageSlug: pageSlug,
                    kommentId: kommentId,
                    isSpam: isSpam,
                })
                .then(() => {
                    this.onMarkAsSpam(isSpam)
                })
        },
        markAsVerified(pageSlug, kommentId, isVerified) {
            this.$api
                .post('komments/verify', {
                    pageSlug: pageSlug,
                    kommentId: kommentId,
                    isVerified: isVerified,
                })
                .then(() => {
                    this.onMarkAsVerified(isVerified)
                })
        },
        publish(pageSlug, kommentId, isPublished) {
            this.$api
                .post('komments/publish', {
                    pageSlug: pageSlug,
                    kommentId: kommentId,
                    isPublished: isPublished,
                })
                .then(() => {
                    this.onMarkAsPublished(isPublished)
                })
        },
        deleteKomment(pageSlug, kommentId, ref) {
            this.$api
                .post('komments/delete', {
                    pageSlug: pageSlug,
                    kommentId: kommentId,
                })
                .then(() => {
                    this.onDelete()
                    ref.deleteDialog.close()
                })
        },
    },
}
</script>

<style lang="scss">
.komment-moderation {
    border: 1px solid var(--color-border);
    border-radius: var(--rounded);
    box-shadow: var(--shadow);
    background-color: var(--color-white);
    padding: var(--spacing-8);

    .avatar {
        img {
            width: 60px;
            border-radius: var(--rounded);
        }
    }

    .meta {
        color: var(--color-gray-500);
        font-size: var(--text-sm);
    }

    .actions {
        margin: var(--spacing-4) 0;
        padding: var(--spacing-2);
        background-color: var(--color-gray-100);

        .k-button {
            margin-right: 0.5em;
        }

        .k-bar-slot[data-position='right'] {
            text-align: right;
        }
    }

    .text {
        padding: var(--spacing-2);
    }
}
</style>
