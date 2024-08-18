<template>
    <div class="k-komments-view">
        <k-table
            :columns="this.visibleColumns"
            :index="true"
            :rows="this.commentList"
            :pagination="{ page: pagination.page, limit: pagination.limit, total: pagination.total, details: true }"
            @paginate="pagination.page = $event.page"
        >
            <template #header="{ columnIndex, label }">
                <span :title="label">
                    <k-icon v-if="columnIndex === 'verified'" type="sparkling" style="color: var(--color-yellow-700)" />
                    <k-icon v-else-if="columnIndex === 'spamlevel'" type="flag" style="color: var(--color-red-700)" />
                    <k-icon
                        v-else-if="columnIndex === 'published'"
                        type="preview"
                        style="color: var(--color-green-700)"
                    />
                    <k-icon v-else-if="columnIndex === 'type'" type="box" style="color: var(--color-blue-700)" />
                    <span v-else>{{ label }}</span>
                </span>
            </template>
            <template #options="{ row }">
                <k-options-dropdown :options="dropdownOptions(row)" />
            </template>
        </k-table>
    </div>
</template>
<script>
export default {
    props: {
        comments: Object,
        affectedPages: Array,
        columns: Array,
        webmentions: Boolean,
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
            const availableColumns = [
                'author',
                'content',
                'pageTitle',
                'updatedAt',
                'spamlevel',
                'verified',
                'published',
                'type',
            ]

            const visibleColumns = this.columns || availableColumns
            const filteredColumns = [...visibleColumns].filter((column) => availableColumns.includes(column))

            const columnConfigs = {
                author: { label: 'Author', type: 'html' },
                content: { label: 'Comment', type: 'text' },
                pageTitle: { label: 'Page', type: 'html' },
                updatedAt: { label: 'Last Update', type: 'html' },
                spamlevel: { label: 'Spamlevel', type: 'html', width: '40px', align: 'center' },
                verified: { label: 'Verified', type: 'html', width: '40px', align: 'center' },
                published: { label: 'Published', type: 'html', width: '40px', align: 'center' },
                type: { label: 'Type', type: 'html', width: '40px', align: 'center' },
            }

            return Object.fromEntries(filteredColumns.map((column) => [column, columnConfigs[column]]))
        },
        commentList() {
            const typeIcons = {
                comment: 'chat',
                'in-reply-to': 'megaphone',
                'repost-of': 'indie-repost',
                'mention-of': 'indie-mention',
                'like-of': 'heart',
                'bookmark-of': 'bookmark',
                rsvp: 'calendar',
                invite: 'calendar',
            }

            const actionTypes = {
                'in-reply-to': 'Webmention reply',
                'repost-of': 'Webmention repost',
                'mention-of': 'Webmention mention',
                'like-of': 'Webmention like',
                'bookmark-of': 'Webmention bookmark',
                rsvp: 'Webmention RSVP',
                invite: 'Webmention invite',
            }

            const commentList = []
            this.pagination.total = 0
            const comments = this.webmentions
                ? this.comments
                : this.comments.filter((comment) => comment.type === 'comment')

            comments.forEach((comment) => {
                const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid)

                const content = comment.content
                    ? comment.content.replace(/<[^>]*>/g, '')
                    : `(${actionTypes[comment.type]})`

                const publishDate = this.$library.dayjs
                    .pattern('YYYY-MM-DD HH:mm')
                    .format(this.$library.dayjs(comment.updatedat))

                const newComment = {
                    id: comment.id,
                    pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
                    author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
                    content: content,
                    updatedAt: publishDate,
                    type: this.tableIcon(typeIcons[comment.type], '--color-blue-700', comment.type),
                    spamlevel: comment.spamlevel > 0 ? this.tableIcon('flag', '--color-red-700') : '',
                    verified: comment.verified ? this.tableIcon('sparkling', '--color-yellow-700') : '',
                    published: comment.published
                        ? this.tableIcon('preview', '--color-green-700')
                        : this.tableIcon('hidden', '--color-red-700'),
                }

                commentList.push(newComment)
                this.pagination.total++
            })

            return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page)
        },
    },
    methods: {
        showCommentDetails(id) {
            const comment = this.comments.find((comment) => comment.id === id)

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
            const comment = this.comments.find((comment) => comment.id === id)

            panel.drawer.open({
                component: 'komments-reply-drawer',
                props: {
                    icon: 'chat',
                    title: 'Reply to comment',
                    comment: comment,
                },
            })
        },
        publishComment(id) {
            panel.api.post(`komments/publish/${id}`).then((response) => {
                this.comments.find((item) => item.id === id).published = response.published
            })
        },

        deleteComment(id) {
            panel.dialog.open(`comment/delete/${id}`)
        },

        flagComment(id, type) {
            panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
                this.comments.find((item) => item.id === id)[type] = response[type]
            })
        },

        dropdownOptions(row) {
            const comment = this.comments.find((item) => item.id === row.id)

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

        tableIcon(icon, color, title = '') {
            return `<span title="${title}"><svg aria-hidden="true" data-type="${icon}" class="k-icon" style="color: var(${color});"><use xlink:href="#icon-${icon}"></use></svg></span>`
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

    .center-icon {
        display: flex;
        justify-content: center;

        svg {
            display: inline-block;
        }
    }
}
</style>
