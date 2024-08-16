<template>
    <k-drawer v-bind="$props">
        <k-box
            v-if="!this.originPublished"
            key="unpublished"
            theme="notice"
            text="This comment is not published yet. When you reply, it will be published along with your reply."
            style="margin-bottom: var(--spacing-6)"
        />

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

        <CommentContent :spamlevel="comment.spamlevel" :content="comment.content" />

        <k-writer-field
            :autofocus="true"
            :label="`Reply to ${comment.authorname}`"
            :value="content"
            @input="content = $event"
            style="margin-bottom: var(--spacing-1)"
        />
        <k-button
            key="green"
            theme="green"
            variant="filled"
            @click="this.sendReply"
            :icon="isSending ? loader : null"
            :disabled="isSending"
        >
            Send reply
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
                    content: this.content,
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
