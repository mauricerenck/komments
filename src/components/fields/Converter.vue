<template>
    <div class="sdfsd">
        It seems like you used an older version of this plugin. We need to convert old comments to the new format. This
        will take a while. For data safety reasons, we will not delete the old comments. You can delete them manually
        after the conversion.

        <button @click="getComments">Convert</button>

        <div v-if="status === 'in-progress'">
            <k-box
                key="inprogress"
                theme="warning"
                text="Conversion in progress, please wait. DO NOT CLOSE THIS PAGE."
                style="margin-bottom: var(--spacing-6)"
            />
            Found {{ queue.length }} comments.

            <k-table
                :columns="{
                    conversionStatus: { label: 'Status', width: '160px', type: 'html' },
                    pageTitle: { label: 'Page', type: 'html' },
                    comments: { label: 'Comments', type: 'text' },
                    converted: { label: 'Converted', type: 'text' },
                    failed: { label: 'Failed', type: 'text' },
                }"
                :index="true"
                :rows="conversionList"
                empty="No comments found"
            >
            </k-table>
        </div>
    </div>
</template>
<script>
export default {
    props: {},
    data() {
        return {
            status: 'idle',
            comments: [],
            queue: [],
            processIndex: 0,
            processRunning: false,
        }
    },
    computed: {
        conversionList() {
            return this.comments.map((item) => {
                return {
                    conversionStatus: `<span class="status ${item.conversionStatus}">${item.conversionStatus}</span>`,
                    pageUuid: item.pageUuid,
                    pageTitle: item.pageTitle,
                    comments: item.comments,
                    converted: item.converted,
                    failed: item.failed,
                }
            })
        },
    },
    methods: {
        getComments() {
            this.status = 'in-progress'
            panel.api.get(`komments/converter/get-comments`).then((response) => {
                const comments = []
                response.forEach((item) => {
                    const queueEntry = { ...item, ...{ queueStatus: 'idle' } }
                    this.queue.push(queueEntry)

                    const page = comments.find((entry) => entry.pageUuid === item.pageUuid)
                    if (page) {
                        page.comments++
                        return
                    }

                    const entry = {
                        conversionStatus: 'idle',
                        pageUuid: item.pageUuid,
                        pageTitle: item.pageTitle,
                        comments: 1,
                        converted: 0,
                        failed: 0,
                    }

                    comments.push(entry)
                })

                this.comments = comments
                this.processQueue()
            })
        },
        processQueue() {
            const limit = 1

            if (this.processIndex >= this.queue.length) {
                this.processIndex = 0
                this.processRunning = false
                return
            }

            this.processRunning = true
            const item = this.queue[this.processIndex]
            this.processIndex += limit

            const tableEntry = this.comments.find((comment) => item.pageUuid === comment.pageUuid)
            tableEntry.conversionStatus = 'running'

            panel.api
                .post(`komments/converter/convert`, item)
                .then((response) => {
                    const convertedComment = this.comments.find((comment) => item.pageUuid === comment.pageUuid)
                    if (response.status === 'success') {
                        convertedComment.converted++
                    } else {
                        convertedComment.failed++
                    }

                    tableEntry.conversionStatus =
                        convertedComment.comments.length === convertedComment.converted + convertedComment.failed
                            ? 'success'
                            : 'done'
                })
                .then(() => {
                    this.processQueue()
                })
        },
        convertComment(comment) {
            const tableEntry = this.comments.find((item) => item.pageUuid === comment.pageUuid)
            tableEntry.conversionStatus = 'running'

            panel.api
                .post(`komments/converter/convert`, comment)
                .then((response) => {
                    console.log(response)

                    const convertedComment = this.comments.find((item) => item.pageUuid === comment.pageUuid)
                    if (response.status === 'success') {
                        convertedComment.converted++
                    } else {
                        convertedComment.failed++
                    }
                })
                .then(() => {
                    // this.processQueue()
                })
        },
    },
}
</script>
<style lang="scss">
.k-komments-view {
    .status {
        border: 1px solid var(--color-gray-400);
        background-color: var(--color-gray-200);

        border-radius: var(--rounded-md);
        padding: var(--spacing-1) var(--spacing-2);

        &.error {
            border: 1px solid var(--color-red-400);
            background-color: var(--color-red-200);
        }

        &.running {
            border: 1px solid var(--color-blue-400);
            background-color: var(--color-blue-200);
        }

        &.failed {
            border: 1px solid var(--color-red-600);
            background-color: var(--color-red-400);
        }

        &.success {
            border: 1px solid var(--color-green-400);
            background-color: var(--color-green-200);
        }
    }
}
</style>
