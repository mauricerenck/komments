<template>
    <k-view class="k-komments-view">
        <k-header>Komments</k-header>

        <k-grid gutter="medium">
            <k-column width="3/4">
                <k-grid>
                    <k-column width="1/2" class="komment-list">
                        <KommentList
                            :queuedKomments="kommentList"
                            :onSelectKomment="selectKomment"
                            :selectedKomment="this.selectedKomment"
                        />
                    </k-column>
                    <k-column width="1/2" class="komment-details">
                        <KommentDetails
                            :komment="this.selectedKomment"
                            :onMarkAsSpam="this.onMarkAsSpam"
                            :onMarkAsVerified="this.onMarkAsVerified"
                            :onMarkAsPublished="this.onMarkAsPublished"
                            :onDelete="this.onDelete"
                        />
                    </k-column>
                </k-grid>
            </k-column>

            <k-column width="1/4">
                <KommentVersion :version="version" />
            </k-column>
        </k-grid>
    </k-view>
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
        version: Object,
    },
    created() {
        this.kommentList = this.queuedKomments
        this.selectKomment(this.kommentList[0].id)
        this.loadKomments()
    },
    methods: {
        loadKomments() {
            this.$api.get('komments/queued').then(komments => {
                this.komments = komments
            })
        },
        selectKomment(id) {
            this.selectedKomment = this.queuedKomments.find(komment => {
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
            this.kommentList = this.kommentList.filter(entry => {
                return entry.id !== this.selectedKomment.id
            })
        },
    },
}
</script>
