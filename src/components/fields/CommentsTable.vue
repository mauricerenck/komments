<template>
    <div class="k-komments-view">
        <k-button-group
            style="margin-bottom: var(--spacing-6)"
            layout="collapsed"
            v-if="this.storageType !== 'markdown'"
        >
            <k-button variant="filled" icon="checklist" :click="this.toggleSelect"> Select </k-button>

            <k-button
                variant="filled"
                icon="toggle-off"
                theme="green"
                v-if="this.selectMode === true"
                :disabled="this.selection.length === 0"
                :click="this.publishSelectedComments"
            >
                Publish {{ this.selection.length }}
            </k-button>
            <k-button
                variant="filled"
                icon="badge"
                theme="yellow"
                v-if="this.selectMode === true"
                :disabled="this.selection.length === 0"
                :click="this.markSelectedCommentsAsVerified"
            >
                Verify {{ this.selection.length }}
            </k-button>
            <k-button
                variant="filled"
                icon="flag"
                theme="orange"
                v-if="this.selectMode === true"
                :disabled="this.selection.length === 0"
                :click="this.markSelectedCommentsAsSpam"
            >
                Spam {{ this.selection.length }}
            </k-button>
            <k-button
                variant="filled"
                icon="trash"
                theme="red"
                v-if="this.selectMode === true"
                :disabled="this.selection.length === 0"
                :click="this.deleteSelectedComments"
            >
                Delete {{ this.selection.length }}
            </k-button>

            <k-button
                variant="filled"
                icon="toggle-off"
                theme="green-icon"
                v-if="this.selectMode === false"
                :disabled="!this.hasPendingComments"
                :click="this.publishPendingComments"
            >
                Publish all
            </k-button>

            <k-button
                variant="filled"
                icon="flag"
                theme="orange-icon"
                v-if="this.selectMode === false"
                :disabled="!this.hasSpamComments"
                :click="this.deleteSpamComments"
            >
                Delete spam
            </k-button>

            <k-button
                variant="filled"
                icon="trash"
                theme="red-icon"
                v-if="this.selectMode === false"
                :disabled="!this.hasPendingComments"
                :click="this.deletePendingComments"
            >
                Delete all pending
            </k-button>
        </k-button-group>

        <k-table
            :columns="this.visibleColumns"
            :index="true"
            :rows="this.commentList"
            empty="No comments found"
            :selecting="this.selectMode"
            @cell="openDrawer"
            :pagination="{ page: pagination.page, limit: pagination.limit, total: pagination.total, details: true }"
            @paginate="pagination.page = $event.page"
            @select="selectRow"
        >
            <template #header="{ columnIndex, label }">
                <span :title="label">
                    <k-icon v-if="columnIndex === 'verified'" type="badge" style="color: var(--color-yellow-700)" />
                    <k-icon v-else-if="columnIndex === 'spamlevel'" type="flag" style="color: var(--color-red-700)" />
                    <k-icon v-else-if="columnIndex === 'status'" type="preview" style="color: var(--color-green-700)" />
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
        storageType: String,
        relatedComment: String,
        markRelatedComment: Function,
    },
    data() {
        return {
            pagination: {
                page: 1,
                limit: 20,
                total: 0,
            },
            selectMode: false,
            selection: [],
        }
    },
    watch: {
        relatedComment(commentId) {
            if (!commentId) {
                return
            }
            this.showCommentDetails(commentId)
        },
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
                'status',
                'type',
            ]

            const visibleColumns = this.columns || availableColumns
            const filteredColumns = visibleColumns.filter((column) => availableColumns.includes(column))

            const columnConfigs = {
                author: { label: 'Author', type: 'html' },
                content: { label: 'Comment', type: 'text' },
                pageTitle: { label: 'Page', type: 'html' },
                updatedAt: { label: 'Last Update', type: 'html' },
                spamlevel: { label: 'Spamlevel', type: 'html', width: '40px', align: 'center' },
                verified: { label: 'Verified', type: 'html', width: '40px', align: 'center' },
                status: { label: 'Status', type: 'html', width: '40px', align: 'center' },
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

                let statusIcon

                switch (comment.status) {
                    case 'VERIFIED':
                        statusIcon = 'circle-half'
                        break
                    case 'PUBLISHED':
                        statusIcon = 'check'
                        break
                    default:
                        statusIcon = 'clock'
                        break
                }

                const newComment = {
                    id: comment.id,
                    pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
                    author: `<span class="author-entry">${comment.authoravatar} ${comment.authorname}</span>`,
                    content: content,
                    updatedAt: publishDate,
                    type: this.tableIcon(typeIcons[comment.type], '--color-blue-700', comment.type),
                    spamlevel: comment.spamlevel > 0 ? this.tableIcon('flag', '--color-red-700') : '',
                    verified: comment.verified ? this.tableIcon('badge', '--color-yellow-700') : '',
                    status: this.tableIcon(statusIcon, '--color-black'),
                }

                commentList.push(newComment)
                this.pagination.total++
            })

            return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page)
        },
        hasSpamComments() {
            return this.comments.some((comment) => comment.spamlevel > 0)
        },
        hasPendingComments() {
            return this.comments.some((comment) => comment.published === false)
        },
    },
    methods: {
        removeMarkedComment() {
            this.markRelatedComment(null)
        },
        showCommentDetails(id) {
            const comment = this.comments.find((comment) => comment.id === id)

            panel.drawer.open({
                component: 'komments-detail-drawer',
                props: {
                    icon: 'chat',
                    title: 'Comment',
                    comment: comment,
                },
                on: {
                    submit: () => {
                        this.removeMarkedComment()
                    },
                    cancel: () => {
                        this.removeMarkedComment()
                    },
                    close: () => {
                        this.removeMarkedComment()
                    },
                },
            })
        },
        publishComment(id) {
            panel.api.post(`komments/publish/${id}`).then((response) => {
                this.comments.find((item) => item.id === id).published = response.published
                this.comments.find((item) => item.id === id).status = response.published ? 'PUBLISHED' : 'PENDING'
            })
        },

        publishPendingComments() {
            panel.dialog.open(`comments/publish/pending`)
        },

        publishSelectedComments() {
            this.flagSelectedComments('published')
        },

        deleteComment(id) {
            panel.dialog.open(`comment/delete/${id}`)
        },

        deleteSpamComments() {
            panel.dialog.open(`comments/delete/spam`)
        },

        markSelectedCommentsAsSpam() {
            this.flagSelectedComments('spamlevel')
        },

        markSelectedCommentsAsVerified() {
            this.flagSelectedComments('verified')
        },

        deletePendingComments() {
            panel.dialog.open(`comments/delete/pending`)
        },

        deleteSelectedComments() {
            panel.api.post(`komments/batch-delete`, { ids: this.selection }).then((response) => {
                if (response.success === true) {
                    this.selection = []
                    this.selectMode = false
                    panel.reload()
                }
            })
        },

        flagComment(id, type) {
            panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
                this.comments.find((item) => item.id === id)[type] = response[type]
            })
        },

        flagSelectedComments(type) {
            panel.api.post(`komments/batch-flag`, { type, ids: this.selection }).then((response) => {
                if (response.success === true) {
                    this.selection = []
                    this.selectMode = false
                    panel.reload()
                }
            })
        },

        dropdownOptions(row) {
            const comment = this.comments.find((item) => item.id === row.id)

            return [
                {
                    label: 'Reply to',
                    icon: 'chat',
                    click: () => this.showCommentDetails(row.id),
                },
                '-',
                {
                    label: comment.published ? 'Unpublish' : 'Publish',
                    icon: comment.published ? 'toggle-on' : 'toggle-off',
                    click: () => this.publishComment(row.id),
                },
                {
                    label: comment.verified ? 'Mark as unverified' : 'Mark as verified',
                    icon: comment.verified ? 'cancel-small' : 'badge',
                    disabled: comment.spamlevel > 0,
                    click: () => this.flagComment(row.id, 'verified'),
                },
                {
                    label: comment.spamlevel > 0 ? 'Remove from spam' : 'Mark as spam' + row.spamlevel,
                    icon: comment.spamlevel > 0 ? 'cancel-small' : 'flag',
                    click: () => this.flagComment(row.id, 'spamlevel'),
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

        toggleSelect() {
            this.selectMode = !this.selectMode
        },

        selectRow(row) {
            const index = this.selection.indexOf(row.id)

            if (index > -1) {
                // ID exists, remove it
                this.selection.splice(index, 1)
            } else {
                // ID does not exist, add it
                this.selection.push(row.id)
            }
        },

        openDrawer(cell) {
            const commentId = cell.row.id
            const blockedColumns = ['spamlevel', 'verified']

            if (blockedColumns.indexOf(cell.columnIndex) !== -1) {
                switch (cell.columnIndex) {
                    case 'spamlevel':
                        this.flagComment(commentId, 'spamlevel')
                        break
                    case 'verified':
                        this.flagComment(commentId, 'verified')
                        break
                }

                return
            }
            this.showCommentDetails(commentId)
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

        svg,
        img {
            width: 32px;
            height: 32px;
            object-fit: cover;
        }
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
