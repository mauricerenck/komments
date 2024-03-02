<template>
    <div class="komment-moderation">
        <div v-if="komment.id">
            <div class="metadata">
                <div class="avatar">
                    <img :src="komment.image" v-if="komment.image" />
                </div>
                <div class="komment-info">
                    <div class="author-short">
                        <strong>{{ komment.author }}</strong>
                        <k-link
                            :to="komment.authorUrl"
                            :title="komment.authorUrl"
                            target="_blank"
                            v-if="komment.authorUrl"
                        >
                            <k-icon type="url" />
                        </k-link>
                    </div>
                    <div class="meta">{{ komment.published }}</div>
                    <div class="meta">
                        <k-link :to="komment.url" :title="komment.url">{{ komment.title }}</k-link>
                    </div>
                </div>
            </div>

            <div class="actions">
                <div class="left">
                    <k-button
                        v-if="komment.status === true"
                        class="publish"
                        theme="positive"
                        icon="circle-filled"
                        v-on:click="publish(komment.slug, komment.id, false)"
                    >
                        Published
                    </k-button>
                    <k-button
                        v-else-if="komment.status === false && komment.spamlevel === 0"
                        class="publish"
                        v-bind:disabled="komment.spamlevel > 0"
                        icon="circle"
                        v-on:click="publish(komment.slug, komment.id, true)"
                    >
                        Publish
                    </k-button>
                    <k-button v-else icon="protected" v-bind:disabled="true"> Publish </k-button>

                    <k-button
                        v-if="komment.verified === true"
                        theme="positive"
                        icon="check"
                        v-on:click="markAsVerified(komment.slug, komment.id, false)"
                    >
                        Verified user
                    </k-button>
                    <k-button
                        v-else-if="komment.verified === false && komment.spamlevel === 0"
                        icon="check"
                        v-bind:disabled="komment.spamlevel > 0"
                        v-on:click="markAsVerified(komment.slug, komment.id, true)"
                    >
                        Verify user
                    </k-button>
                    <k-button v-else icon="protected" v-bind:disabled="true"> Verify user </k-button>

                    <k-button
                        v-if="komment.spamlevel === 0"
                        v-on:click="markAsSpam(komment.slug, komment.id, true)"
                        icon="bolt"
                    >
                        Flag as spam
                    </k-button>
                    <k-button
                        v-else-if="komment.spamlevel > 0"
                        theme="negative"
                        v-on:click="markAsSpam(komment.slug, komment.id, false)"
                        icon="bolt"
                    >
                        Remove from spam
                    </k-button>
                    <k-button v-else icon="clock" v-bind:disabled="true"> Marked as spam </k-button>
                </div>
                <div class="right">
                    <k-button theme="negative" icon="trash" @click="$refs.deleteDialog.open()"> Delete </k-button>

                    <k-dialog
                        ref="deleteDialog"
                        button="Delete"
                        theme="negative"
                        icon="trash"
                        @submit="deleteKomment(komment.slug, komment.id, $refs)"
                    >
                        <k-text> Do you really want to delete the comment? This cannot be undone. </k-text>
                    </k-dialog>
                </div>
            </div>
            <div class="text" v-html="komment.komment"></div>
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
        kommentApi: Function,
    },
    methods: {
        markAsSpam(pageSlug, kommentId, isSpam) {
            this.komment.spamlevel = null

            this.kommentApi()
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
            this.komment.verified = null

            this.kommentApi()
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
            this.komment.status = null

            this.kommentApi()
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
            this.kommentApi()
                .post('komments/delete', {
                    pageSlug: pageSlug,
                    kommentId: kommentId,
                })
                .then(() => {
                    this.onDelete()
                    ref.deleteDialog.close()
                })
        },
        nl2br(kommentText) {
            return kommentText.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2')
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

    .metadata {
        display: grid;
        grid-template-columns: 60px 1fr;
        gap: var(--spacing-4);
        line-height: 1.25;
    }

    .avatar {
        img {
            width: 60px;
            border-radius: var(--rounded);
        }
    }

    .author-short {
        .k-icon {
            display: inline-block;
            margin-left: 0.5em;
        }
    }

    .meta {
        color: var(--color-gray-500);
        font-size: var(--text-sm);
    }

    .actions {
        display: flex;
        justify-content: space-between;
        margin: var(--spacing-4) 0;
        padding: var(--spacing-2);
        background-color: var(--color-gray-100);

        .k-button {
            margin-right: 1.75em;

            &:last-child {
                margin-right: 0;
            }
        }

        .k-bar-slot[data-position='right'] {
            text-align: right;
        }
    }

    .text {
        padding: var(--spacing-2);

        a {
            color: var(--color-negative);
        }
    }
}
</style>
