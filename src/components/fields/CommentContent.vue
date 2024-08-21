<template>
    <div>
        <k-box
            v-if="spamlevel > 0"
            key="spam"
            theme="warning"
            text="This comment is marked as spam. Its content is shown as plain text to prevent accidental exposure to harmful content."
            style="margin-bottom: var(--spacing-6)"
        />
        <k-box theme="text" style="margin-bottom: var(--spacing-6)">
            <k-text v-html="content" v-if="spamlevel === 0" />
            <k-text v-else>{{ content }}</k-text>
        </k-box>
    </div>
</template>
<script>
export default {
    props: {
        spamlevel: Number,
        content: String,
    },
}
</script>
