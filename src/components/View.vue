<template>
    <k-inside>
        <div class="k-komments-view">
            <k-headline tag="h2">Comments</k-headline>

            <k-table
                :columns="{
                    author: { label: 'Author', type: 'html' },
                    content: { label: 'Comment', type: 'text' },
                    pageTitle: { label: 'Page', type: 'html' },
                    updatedAt: { label: 'Last Update', type: 'html' },

                    spamlevel: { label: 'Spamlevel', type: 'html', width: '40px', align: 'center' },
                    verified: { label: 'Verified', type: 'html', width: '40px', align: 'center' },
                }"
                :index="true"
                :rows="this.commentList"
                :pagination="{ page: pagination.page, limit: pagination.limit, total: pagination.total, details: true }"
                @paginate="pagination.page = $event.page"
            >
                <template #header="{ columnIndex, label }">
                    <span :title="label">
                        <k-icon
                            v-if="columnIndex === 'verified'"
                            type="sparkling"
                            style="color: var(--color-yellow-700)"
                        />
                        <k-icon
                            v-else-if="columnIndex === 'spamlevel'"
                            type="flag"
                            style="color: var(--color-red-700)"
                        />
                        <span v-else>{{ label }}</span>
                    </span>
                </template>
                <template #options="{ row }">
                    <k-options-dropdown :options="dropdownOptions(row)" />
                </template>
            </k-table>
        </div>
    </k-inside>
</template>

<script>
export default {
    props: {
        queuedKomments: Object,
        affectedPages: Array,
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
        commentList() {
            const commentList = []
            this.pagination.total = 0

            this.queuedKomments
                .filter((comment) => !comment.published)
                .forEach((comment) => {
                    const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid)

                    const newComment = {
                        id: comment.id,
                        pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
                        author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
                        content: comment.content,
                        updatedAt: comment.updatedat,
                        spamlevel:
                            comment.spamlevel > 0
                                ? '<svg aria-hidden="true" data-type="flag" class="k-icon" style="color: var(--color-red-700);"><use xlink:href="#icon-flag"></use></svg>'
                                : '',
                        verified: comment.verified
                            ? '<svg aria-hidden="true" data-type="sparkling" class="k-icon" style="color: var(--color-green-700);"><use xlink:href="#icon-sparkling"></use></svg>'
                            : '',
                    }

                    commentList.push(newComment)
                    this.pagination.total++
                })

            return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page)
        },
    },
    methods: {
        showCommentDetails(id) {
            const comment = this.queuedKomments.find((comment) => comment.id === id)

            panel.drawer.open({
                component: 'komments-detail-drawer',
                props: {
                    icon: 'info',
                    title: 'Comment',
                    comment: comment,
                },
            })
        },
        replyToComment(id) {
            const comment = this.queuedKomments.find((comment) => comment.id === id)

            panel.drawer.open({
                component: 'komments-reply-drawer',
                props: {
                    icon: 'chat',
                    title: 'Comment',
                    comment: comment,
                },
            })
        },
        publishComment(id) {
            panel.api.post(`komments/publish/${id}`).then((response) => {
                this.queuedKomments.find((item) => item.id === id).published = response.published
            })
        },

        deleteComment(id) {
            panel.dialog.open(`comment/delete/${id}`)
        },

        flagComment(id, type) {
            panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
                this.queuedKomments.find((item) => item.id === id)[type] = response[type]
            })
        },

        dropdownOptions(row) {
            const comment = this.queuedKomments.find((item) => item.id === row.id)

            return [
                {
                    label: comment.published ? 'Unpublish' : 'Publish',
                    icon: comment.published ? 'toggle-on' : 'toggle-off',
                    click: () => this.publishComment(row.id),
                },
                {
                    label: 'Reply to',
                    icon: 'chat',
                    click: () => this.replyToComment(row.id),
                },
                '-',
                {
                    label: comment.verified ? 'Mark as unverified' : 'Mark as verified',
                    icon: comment.verified ? 'cancel-small' : 'sparkling',
                    disabled: comment.spamlevel > 0,
                    click: () => this.flagComment(row.id, 'verified'),
                },
                {
                    label: comment.spamlevel > 0 ? 'Remove from spam' : 'Mark as spam' + row.spamlevel,
                    icon: comment.spamlevel > 0 ? 'cancel-small' : 'flag',
                    click: () => this.flagComment(row.id, 'spamlevel'),
                },
                {
                    label: 'View Details',
                    icon: 'info',
                    click: () => this.showCommentDetails(row.id),
                },
                '-',
                {
                    label: 'Delete',
                    icon: 'trash',
                    click: () => this.deleteComment(row.id),
                },
            ]
        },
    },
}
</script>
<style lang="scss">
.k-komments-view {
    .author-entry {
        display: flex;
        gap: 10px;
        align-items: center;
        color: var(--color-black);
        text-decoration: none;
    }

    h2 {
        font-size: var(--text-3xl);
        margin: 2em 0 1em 0;
    }

    .center-icon {
        display: flex;
        justify-content: center;

        svg {
            display: inline-block;
        }
    }
}
</style>
