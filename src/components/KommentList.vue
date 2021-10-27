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
                <k-grid>
                    <k-column width="2/12" class="avatar">
                        <img :src="komment.image" v-if="komment.image" />
                    </k-column>
                    <k-column width="10/12">
                        <div class="komment-preview">
                            <div class="author">
                                <strong>{{ komment.author }}</strong>
                            </div>
                            <div class="meta">{{ komment.published }} - {{ komment.title }}</div>
                            <div class="preview">
                                {{ komment.komment.substr(0, 60) + '&hellip;' }}
                            </div>
                        </div>
                    </k-column>
                    <k-column width="2/12"></k-column>
                    <k-column width="10/12">
                        <div class="status">
                            <span v-if="komment.status === false" alt="pending" title="pending" class="badge">
                                pending
                            </span>
                            <span
                                v-else-if="komment.status === true"
                                alt="published"
                                title="published"
                                class="badge blue"
                            >
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
                    </k-column>
                </k-grid>
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
    methods: {},
}
</script>

<style lang="scss">
.k-komments-view {
    .komments-list {
        .komment-preview {
            padding: 1rem;
        }

        .answer {
            align-self: end;
            box-shadow: var(--box-shadow-focus);
        }

        .meta {
            color: var(--color-gray-500);
            font-size: var(--text-sm);
            padding-bottom: var(--spacing-4);
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
            padding: var(--spacing-2);
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;

            img {
                width: 60px;
                border-radius: var(--rounded);
            }
        }

        .list-item {
            transition: all 0.125s;
            border: 1px solid var(--color-border);
            border-radius: var(--rounded);
            cursor: pointer;
            margin: 0 20px 10px 0;
            box-shadow: var(--shadow);
            background-color: var(--color-white);

            &.active {
                margin: 0 10px 10px 10px;
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
