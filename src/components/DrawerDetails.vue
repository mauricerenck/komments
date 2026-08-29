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

        <k-button-group
            style="margin-bottom: var(--spacing-6); margin-top: var(--spacing-6)"
            layout="collapsed"
            v-if="this.storageType !== 'markdown'"
        >
            <k-button
                size="sm"
                variant="filled"
                icon="edit"
                theme="blue-icon"
                :click="this.toggleEditMode"
                :disabled="this.editMode"
            >
                Edit
            </k-button>
            <k-button
                size="sm"
                variant="filled"
                icon="trash"
                theme="red-icon"
                :click="this.deleteComment"
                :disabled="this.editMode"
            >
                Delete
            </k-button>
            <k-button
                size="sm"
                variant="filled"
                icon="trash"
                theme="green-icon"
                :click="this.publishComment"
                :disabled="this.editMode"
            >
                {{ comment.published === true ? 'Unpublish' : 'Publish' }}
            </k-button>
            <k-button
                size="sm"
                variant="filled"
                icon="parent"
                theme="blue-icon"
                :click="this.toggleReplyMode"
                :disabled="this.editMode"
            >
                Reply
            </k-button>
        </k-button-group>

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
                        <th data-mobile="true">URL</th>
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

        <k-grid variant="columns">
            <k-textarea-field
                v-if="this.editMode"
                label="Edit comment"
                :value="newText"
                @input="newText = $event"
                style="--width: 1/1; margin-top: var(--spacing-6)"
            />
            <k-text-field
                v-if="this.editMode"
                style="--width: 1/3"
                label="URL"
                :value="newUrl"
                @input="newUrl = $event"
            />
            <k-text-field
                v-if="this.editMode"
                style="--width: 1/3"
                label="Name"
                :value="newName"
                @input="newName = $event"
            />
            <k-text-field
                v-if="this.editMode"
                style="--width: 1/3"
                label="Email"
                :value="newMail"
                @input="newMail = $event"
            />
        </k-grid>

        <k-button-group
            style="margin-bottom: var(--spacing-6); margin-top: var(--spacing-6)"
            layout="collapsed"
            v-if="this.storageType !== 'markdown'"
        >
            <k-button
                size="sm"
                variant="filled"
                icon="check"
                theme="green-icon"
                :click="this.updateComment"
                v-if="this.editMode"
            >
                Save
            </k-button>
            <k-button
                size="sm"
                variant="filled"
                icon="cancel"
                theme="red-icon"
                :click="this.toggleEditMode"
                v-if="this.editMode"
            >
                Cancel
            </k-button>
        </k-button-group>

        <k-textarea-field
            :autofocus="true"
            :label="`Reply to ${comment.authorname}`"
            :value="replyText"
            @input="replyText = $event"
            style="margin-bottom: var(--spacing-2); margin-top: var(--spacing-6)"
            :disabled="this.editMode"
            v-if="this.replyMode && !this.editMode"
        />

        <k-button
            key="green"
            theme="green"
            variant="filled"
            @click="this.sendReply"
            :icon="isSending ? loader : null"
            :disabled="isSending"
            v-if="this.replyMode && !this.editMode"
        >
            Send reply {{ !this.originPublished ? 'and publish' : '' }}
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
            editMode: false,
            replyMode: false,
            newText: this.comment.content || '',
            newName: this.comment.authorname || '',
            newUrl: this.comment.authorurl || '',
            newMail: this.comment.authormail || '',
        }
    },
    methods: {
        sendReply() {
            this.isSending = true
            panel.api
                .post(`komments/reply/${this.comment.id}`, {
                    comment: this.replyText,
                    pageUuid: this.comment.pageuuid,
                    language: this.comment.language,
                })
                .then((response) => {
                    this.originPublished = response['published']
                    this.comment.published = response['published']
                    this.replyCreated = response['created']
                    this.isSending = false
                    this.toggleReplyMode()
                    this.replyText = ''
                })
                .catch(() => {
                    this.replyCreated = false
                    this.isSending = false
                    this.toggleReplyMode()
                })
        },
        publishComment() {
            panel.api.post(`komments/publish/${this.comment.id}`).then((response) => {
                this.comment.published = response.published
                this.comment.status = response.published ? 'PUBLISHED' : 'PENDING'
            })
        },

        deleteComment() {
            panel.dialog.open(`comment/delete/${this.comment.id}`)
        },
        toggleEditMode() {
            this.editMode = !this.editMode
        },
        toggleReplyMode() {
            this.replyMode = !this.replyMode
        },
        updateComment() {
            panel.api
                .post(`komments/update-comment/${this.comment.id}`, {
                    content: this.newText,
                    authorname: this.newName,
                    authorurl: this.newUrl,
                    authoremail: this.newMail,
                })
                .then((response) => {
                    this.comment.content = response.content
                    this.comment.authorname = response.author_name
                    this.comment.authorurl = response.author_url
                    this.comment.authoremail = response.author_email
                    this.editMode = false
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
