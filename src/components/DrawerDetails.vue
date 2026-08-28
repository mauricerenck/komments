<template>
    <k-drawer v-bind="$props">
        <k-box
            v-if="this.replyCreated"
            key="created"
            theme="positive"
            text="Your reply has been published."
            style="margin-bottom: var(--spacing-6)"
        />
        <k-box
            v-else-if="this.replyCreated === false"
            key="not-created"
            theme="negative"
            text="Your reply could not be published. Please try again."
            style="margin-bottom: var(--spacing-6)"
        />

        <CommentContent :spamlevel="comment.spamlevel" :content="comment.content" :avatar="comment.authoravatar" />

        <div class="k-table k-komments-to-margin">
            <table style="table-layout: auto">
                <tbody>
                    <tr>
                        <th data-mobile="true">Created at</th>
                        <td data-mobile="true">
                            {{ this.$library.dayjs(comment.createdate).format('YYYY-MM-DD HH:mm') }}
                        </td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Author</th>
                        <td data-mobile="true">{{ comment.authorname }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Email</th>
                        <td data-mobile="true">{{ comment.authoremail }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Url</th>
                        <td data-mobile="true">{{ comment.authorurl }}</td>
                    </tr>
                    <tr v-if="comment.spamlevel > 0">
                        <th data-mobile="true">Spamlevel</th>
                        <td data-mobile="true">
                            <k-progress :value="comment.spamlevel" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <k-textarea-field
            :autofocus="true"
            :label="`Reply to ${comment.authorname}`"
            :value="content"
            @input="content = $event"
            style="margin-bottom: var(--spacing-2); margin-top: var(--spacing-6)"
        />

        <k-button
            key="green"
            theme="green"
            variant="filled"
            @click="this.sendReply"
            :icon="isSending ? loader : null"
            :disabled="isSending"
        >
            Send reply {{ !this.originPublished && 'and publish' }}
        </k-button>
    </k-drawer>
</template>

<script>
export default {
    mixins: ['drawer'],
    props: {
        comment: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            originPublished: this.comment.published,
            replyCreated: null,
            isSending: false,
        }
    },
    methods: {
        sendReply() {
            this.isSending = true
            panel.api
                .post(`komments/reply/${this.comment.id}`, {
                    comment: this.content,
                    pageUuid: this.comment.pageuuid,
                    language: this.comment.language,
                })
                .then((response) => {
                    this.originPublished = response['published']
                    this.replyCreated = response['created']
                    this.isSending = false
                })
                .catch(() => {
                    this.replyCreated = false
                    this.isSending = false
                })
        },
    },
}
</script>

<style lang="css">
.k-komments-to-margin {
    margin-top: var(--spacing-12);
}
</style>
