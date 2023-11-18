<template>
    <div class="komments-list">
        <ul>
            <li
                v-for="(komment, index) in queuedKomments"
                :key="index"
                v-on:click="onSelectKomment(komment.id)"
                @keypress="onSelectKomment(komment.id)"
                class="list-item"
                v-bind:class="{
                    active: selectedKomment.id === komment.id,
                    isSpam: komment.spamlevel > 0,
                    isVerified: komment.verified === true,
                }"
            >
                <img :src="komment.image" v-if="komment.image" />

                <div class="komment-preview">
                    <div class="author">
                        <strong>{{ komment.author }}</strong>
                    </div>
                    <div class="meta">{{ komment.published }} - {{ komment.title }}</div>
                    <div class="status">
                        <span v-if="komment.status === false" alt="pending" title="pending" class="badge">
                            pending
                        </span>
                        <span v-else-if="komment.status === true" alt="published" title="published" class="badge blue">
                            published
                        </span>
                        <span
                            v-if="komment.verified === true"
                            alt="Verified user"
                            title="Verified user"
                            class="badge green"
                        >
                            verified
                        </span>
                        <span
                            v-if="komment.spamlevel > 0"
                            alt="Possible spam comment"
                            title="Possible spam comment"
                            class="badge red"
                        >
                            spam
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        queuedKomments: Array,
        onSelectKomment: Function,
        selectedKomment: Object,
    },
}
</script>

<style lang="scss">
.k-komments-view {
    .komments-list {
        ul {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-2);
        }

        .komment-preview {
            line-height: 1.5;
        }

        .answer {
            align-self: end;
            box-shadow: var(--box-shadow-focus);
        }

        .meta {
            color: var(--color-gray-500);
            font-size: var(--text-sm);
            padding-bottom: var(--spacing-1);
        }

        .badge {
            border-radius: var(--rounded);

            background: var(--color-gray-300);
            font-size: var(--text-xs);
            padding: 0 7px;
            line-height: 1.5;
            display: inline-block;

            &.green {
                background: var(--color-green);
                color: var(--color-white);
            }

            &.blue {
                background: var(--color-blue);
                color: var(--color-white);
            }

            &.red {
                background: var(--color-red);
                color: var(--color-white);
            }
        }

        .status {
            span {
                margin-right: var(--spacing-1);
            }
        }

        .list-item {
            display: flex;
            gap: var(--spacing-2);
            place-items: center;
            transition: all 0.125s;
            border: 1px solid var(--color-border);
            border-radius: var(--rounded);
            cursor: pointer;
            // margin: 0 20px 2px 0;
            box-shadow: var(--shadow);
            background-color: var(--color-white);
            padding: var(--spacing-2);

            img {
                width: 60px;
                border-radius: var(--rounded);
                margin-right: var(--spacing-2);
            }

            &.active {
                position: relative;
                box-shadow: var(--shadow-lg);
                background-color: var(--color-gray-200);
                border-color: var(--color-blue);
            }

            &:hover,
            &:focus {
                background-color: var(--color-gray-100);
            }
        }
    }
}
</style>
