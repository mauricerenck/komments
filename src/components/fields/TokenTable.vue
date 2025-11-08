<template>
    <div class="k-komments-view">
        <k-button-group
            style="margin-bottom: var(--spacing-6)"
            layout="collapsed"
            v-if="this.storageType !== 'markdown'"
        >
            <k-button
                variant="filled"
                icon="trash"
                theme="orange"
                :click="this.deleteExpiredToken"
                :disabled="queuedVerifications.length === 0"
            >
                Cleanup
            </k-button>
        </k-button-group>

        <k-table
            :columns="this.visibleColumns"
            :index="true"
            :rows="this.tokenList"
            empty="No pending verifications"
            :pagination="{ page: pagination.page, limit: pagination.limit, total: pagination.total, details: true }"
            @paginate="pagination.page = $event.page"
            @cell="markComment"
        />
    </div>
</template>
<script>
export default {
    props: {
        queuedVerifications: Object,
        relatedComment: String,
        verificationTtl: Number,
        markRelatedComment: Function,
    },
    data() {
        return {
            pagination: {
                page: 1,
                limit: 20,
                total: 0,
            },
        }
    },
    computed: {
        index() {
            return (this.pagination.page - 1) * this.pagination.limit + 1
        },

        visibleColumns() {
            return {
                hash: { label: 'Hash', type: 'text' },
                commentId: { label: 'Comment ID', type: 'text' },
                createdAt: { label: 'Created', type: 'html' },
                expiresAt: { label: 'Expires', type: 'html' },
            }
        },
        tokenList() {
            if (!this.queuedVerifications) {
                return []
            }

            const tokenList = []
            this.pagination.total = 0

            this.queuedVerifications.forEach((token) => {
                const createdDate = this.$library.dayjs
                    .pattern('YYYY-MM-DD HH:mm')
                    .format(this.$library.dayjs(token.created_at))

                const now = this.$library.dayjs()
                const expires = this.$library.dayjs(token.expires_at * 1000)

                const differenceInMinutes = expires.diff(now, 'minute')
                const percentageLeft = (100 / (this.verificationTtl * 60)) * differenceInMinutes
                const finalPercentage = Math.max(0, Math.min(100, percentageLeft))

                const newEntry = {
                    hash: token.hash,
                    commentId: token.comment_id,
                    createdAt: createdDate,
                    expiresAt: this.renderProgressBar(finalPercentage),
                }

                tokenList.push(newEntry)
                this.pagination.total++
            })

            return tokenList.slice(this.index - 1, this.pagination.limit * this.pagination.page)
        },
    },
    methods: {
        markComment(cell) {
            const commentId = cell.row.commentId
            this.markRelatedComment(commentId)
        },

        deleteExpiredToken() {
            panel.dialog.open(`tokens/delete/expired`)
        },

        renderProgressBar(value) {
            const percentage = Math.min(100, Math.max(0, value))

            let cssClass = ''

            if (percentage < 10) {
                cssClass = 'is-danger'
            } else if (percentage < 25) {
                cssClass = 'is-warning'
            }

            return `<progress class="${cssClass}" value="${value}" max="100"></progress>`
        },
    },
}
</script>
<style lang="scss">
.k-komments-view {
    progress {
        appearance: none;
        -webkit-appearance: none;
        width: 100%;
        height: 0.5rem;
        border: none;
        border-radius: var(--rounded);
        background-color: var(--color-gray-300);
        overflow: hidden;
    }

    progress::-webkit-progress-bar {
        background-color: var(--color-gray-300);
        border-radius: var(--rounded);
    }

    progress::-webkit-progress-value {
        background-color: var(--color-blue-600);
        border-radius: var(--rounded);
        transition: width 0.3s ease;
    }

    progress::-moz-progress-bar {
        background-color: var(--color-blue-600);
        border-radius: var(--rounded);
    }

    /* For different states, you can add classes */
    progress.is-warning::-webkit-progress-value,
    progress.is-warning::-moz-progress-bar {
        background-color: var(--color-yellow-600);
    }

    progress.is-danger::-webkit-progress-value,
    progress.is-danger::-moz-progress-bar {
        background-color: var(--color-red-600);
    }
}
</style>
