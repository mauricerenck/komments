<template>
    <k-drawer v-bind="$props">
        <k-box
            v-if="!comment.published"
            key="notice"
            theme="notice"
            text="This comment is not published yet. When you reply, it will be published along with your reply."
            style="margin-bottom: var(--spacing-6)"
        />

        <k-box theme="text" style="margin-bottom: var(--spacing-6)">
            <k-text>{{ comment.content }}</k-text>
        </k-box>

        <k-writer-field
            :autofocus="true"
            :label="`Reply to ${comment.authorname}`"
            :value="value"
            @input="value = $event"
            style="margin-bottom: var(--spacing-1)"
        />
        <k-button key="green" theme="green" variant="filled"> Send reply </k-button>
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
}
</script>
