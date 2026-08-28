<template>
    <div>
        <k-grid>
            <k-box style="--width: 1/5" v-html="avatar"></k-box>
            <k-box style="margin-bottom: var(--spacing-6); --width: 4/5">
                <k-box theme="text">
                    <k-text v-html="content" v-if="spamlevel === 0" />
                    <k-text v-else>{{ content }}</k-text>
                </k-box>
            </k-box>
        </k-grid>
    </div>
</template>
<script>
export default {
    props: {
        spamlevel: Number,
        content: String,
        avatar: String,
    },
}
</script>
