<template>
    <k-inside>
        <div
            class="k-komments-view"
            v-bind:class="{
                version3: this.kirbyMajorVersion === '3',
            }"
        >
            <k-header>Komments</k-header>

            <div>
                <div v-if="kommentList.length === 0" class="so-empty">
                    <NoKomments />
                    <div>
                        <k-info-field
                            theme="positive"
                            text="There are no comments waiting for moderation. Have a nice day!"
                        />
                    </div>
                </div>

                <div class="comments-grid" v-else>
                    <k-column width="1/3" class="komment-list">
                        <KommentList
                            :queuedKomments="kommentList"
                            :onSelectKomment="selectKomment"
                            :selectedKomment="this.selectedKomment"
                        />
                    </k-column>
                    <k-column width="2/3" class="komment-details">
                        <KommentDetails
                            :komment="this.selectedKomment"
                            :onMarkAsSpam="this.onMarkAsSpam"
                            :onMarkAsVerified="this.onMarkAsVerified"
                            :onMarkAsPublished="this.onMarkAsPublished"
                            :onDelete="this.onDelete"
                            :kommentApi="this.kommentApi"
                        />
                    </k-column>
                </div>
            </div>
        </div>
    </k-inside>
</template>

<script>
export default {
    data() {
        return {
            selectedKomment: {},
            kommentList: [],
        }
    },
    props: {
        title: String,
        queuedKomments: Array,
        kirbyVersion: String,
    },
    created() {
        this.kommentList = this.queuedKomments
        if (this.kommentList[0]) {
            this.selectKomment(this.kommentList[0].id)
        }
    },
    computed: {
        kirbyMajorVersion() {
            return this.kirbyVersion.split('.')[0]
        },
    },
    methods: {
        kommentApi() {
            return !panel.api ? this.$api : panel.api
        },
        selectKomment(id) {
            this.selectedKomment = this.queuedKomments.find((komment) => {
                return komment.id === id
            })
        },
        onMarkAsSpam(isSpam) {
            for (let index = 0; index < this.kommentList.length; index++) {
                if (this.kommentList[index].id === this.selectedKomment.id) {
                    this.kommentList[index].spamlevel = isSpam ? 100 : 0

                    if (isSpam) {
                        this.kommentList[index].verified = false
                        this.kommentList[index].status = false
                    }
                }
            }
        },
        onMarkAsVerified(isVerified) {
            for (let index = 0; index < this.kommentList.length; index++) {
                if (this.kommentList[index].id === this.selectedKomment.id) {
                    this.kommentList[index].verified = isVerified
                }
            }
        },
        onMarkAsPublished(isPublished) {
            for (let index = 0; index < this.kommentList.length; index++) {
                if (this.kommentList[index].id === this.selectedKomment.id) {
                    this.kommentList[index].status = isPublished
                }
            }
        },
        onDelete() {
            this.kommentList = this.kommentList.filter((entry) => {
                return entry.id !== this.selectedKomment.id
            })

            this.selectedKomment = this.kommentList[0]
        },
    },
}
</script>
<style lang="scss">
.k-komments-view {
    &.version3 {
        padding: var(--spacing-10);

        .komment-list,
        .komment-details {
            grid-column-start: inherit;
        }
    }

    .comments-grid {
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: var(--spacing-4);
    }
}
</style>
