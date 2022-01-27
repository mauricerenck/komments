<template>
    <div class="version-box">
        <span v-if="version.error" class="error">
            <k-info-field theme="negative" label="Sorry" text="The current version could not be fetched." />
        </span>
        <span v-else-if="version.updateAvailable" class="version">
            <span class="update-available">Update to {{ version.latest }} available</span>
            / <span>Your installed version is {{ version.local }} </span>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        version: Object,
    },
}
</script>

<style lang="scss">
.k-komments-view {
    .version-box {
        text-align: right;
        .version {
            font-size: 14px;
            padding: 0.5em 0;
        }

        .update-available {
            color: var(--color-positive);
        }

        .align-center {
            display: block;
            text-align: center;
        }
    }
}
</style>
