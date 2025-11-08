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

        <k-textarea-field
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

        <div class="k-table k-komments-to-margin">
            <table style="table-layout: auto">
                <tbody>
                    <tr>
                        <th data-mobile="true">Id</th>
                        <td data-mobile="true">{{ comment.id }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Type</th>
                        <td data-mobile="true">{{ comment.type }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Language</th>
                        <td data-mobile="true">{{ comment.language }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Status</th>
                        <td data-mobile="true">{{ comment.status }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Verified</th>
                        <td data-mobile="true">{{ comment.verified }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Reply To</th>
                        <td data-mobile="true">{{ comment.parentid }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Spam level</th>
                        <td data-mobile="true">{{ comment.spamlevel }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Upvotes</th>
                        <td data-mobile="true">{{ comment.upvotes }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Downvotes</th>
                        <td data-mobile="true">{{ comment.downvotes }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Created at</th>
                        <td data-mobile="true">{{ comment.createdat }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Updated at</th>
                        <td data-mobile="true">{{ comment.updatedat }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Permalink</th>
                        <td data-mobile="true">{{ comment.permalink }}</td>
                    </tr>

                    <tr>
                        <th data-mobile="true">Author</th>
                        <td data-mobile="true">{{ comment.authorname }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Avatar</th>
                        <td data-mobile="true" v-html="comment.authoravatar"></td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Email</th>
                        <td data-mobile="true">{{ comment.authoremail }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Url</th>
                        <td data-mobile="true">{{ comment.authorurl }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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

<style lang="css">
.k-komments-to-margin {
    margin-top: var(--spacing-12);
}
</style>
