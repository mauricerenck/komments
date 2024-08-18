<template>
    <svg aria-hidden="true" :data-type="this.icon" class="k-icon" :style="`color: var(${this.color})`">
        <use :xlink:href="`#icon-${this.icon}`"></use>
    </svg>
</template>
<script>
export default {
    props: {
        icon: String,
        color: String,
    },
}
</script>
