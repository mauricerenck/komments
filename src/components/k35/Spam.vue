<template>
    <div class="k-spam-komments">
        <k-list data-size="medium">
            <k-list-item
                v-for="komment in komments"
                :key="komment.title"
                :link="komment.url + '#komments'"
                :info="`${komment.author}`"
                :text="`${komment.title} - ${komment.komment}`"
                :image="{
                    ratio: '1/1',
                    cover: true,
                    back: 'pattern',
                    url: komment.image,
                }"
                target="_self"
            />
        </k-list>
    </div>
</template>

<script>
export default {
    data() {
        return {
            komments: [],
        }
    },
    created() {
        this.load()
    },
    methods: {
        load() {
            this.$api.get('komments/spam').then(komments => {
                this.komments = komments
            })
        },
    },
}
</script>
