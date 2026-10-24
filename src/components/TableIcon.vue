<template>
    <k-icon :type="this.icon" :style="`color: var(${this.color})`" />
</template>
<script>
export default {
    props: {
        icon: String,
        color: String,
    },
}
</script>
