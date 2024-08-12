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
                :index="false"
                :rows="this.commentList"
                :options="[
                    { text: 'View', icon: 'view', click: () => {} },
                    { text: 'Verify', icon: 'view', click: () => {} },
                    { text: 'Reply', icon: 'view', click: () => {} },
                    { text: 'Delete', icon: 'alert', click: () => {} },
                ]"
                :pagination="{
                    page: pagination.page,
                    limit: pagination.limit,
                    total: pagination.total,
                    details: true,
                }"
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
                            type="alert"
                            style="color: var(--color-red-700)"
                        />
                        <span v-else>{{ label }}</span>
                    </span>
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
            const queuedKomments = JSON.parse(this.queuedKomments)
            const commentList = []
            this.pagination.total = 0

            queuedKomments.forEach((comment) => {
                const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid)

                const newComment = {
                    pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
                    author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
                    content: comment.content,
                    updatedAt: comment.updatedat,
                    spamlevel:
                        comment.spamlevel > 0
                            ? '<svg aria-hidden="true" data-type="alert" class="k-icon" style="color: var(--color-red-700);"><use xlink:href="#icon-alert"></use></svg>'
                            : '',
                    verified: comment.verified
                        ? '<svg aria-hidden="true" data-type="check" class="k-icon" style="color: var(--color-green-700);"><use xlink:href="#icon-check"></use></svg>'
                        : '',
                }

                commentList.push(newComment)
                this.pagination.total++
            })

            return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page)
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
