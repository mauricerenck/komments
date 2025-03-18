<template>
    <div>
        <k-grid variant="fields">
            <k-box
                v-if="status === 'in-progress'"
                key="inprogress"
                :theme="progressValue >= 100 ? 'positive' : 'warning'"
                :html="true"
                style="--width: 1/2; margin-bottom: var(--spacing-6); padding: var(--spacing-6); display: block"
            >
                <p v-if="progressValue < 100">
                    Conversion in progress, please wait. <strong>DO NOT CLOSE THIS PAGE.</strong>
                </p>
                <div v-else>
                    <p><strong>Conversion complete!</strong></p>
                    <k-checkboxes-field
                        name="checkboxes"
                        label="Please complete the following steps:"
                        :options="[
                            { value: 1, text: 'Check if all comments are converted' },
                            { value: 2, text: 'Go to your config.php and disable migration' },
                            { value: 3, text: 'Adapt your theme to the new comment format' },
                            { value: 4, text: 'Remove old comments from your page files' },
                        ]"
                    />
                </div>

                <k-progress v-if="progressValue < 100" :value="progressValue" style="margin-top: var(--spacing-6)" />
            </k-box>

            <div style="--width: 1/2; margin-bottom: var(--spacing-6)">
                <k-box
                    v-if="status !== 'in-progress'"
                    key="info"
                    theme="info"
                    :html="true"
                    text="It seems like you used an older version of this plugin. We need to convert old comments to the new format. This will take a while. For data safety reasons, <strong>old comments will not be deleted automatically.</strong> You can delete them manually after the conversion."
                    icon="bell"
                    style="padding: var(--spacing-6)"
                />

                <k-box
                    v-if="this.storageType === 'markdown'"
                    key="markdown"
                    theme="error"
                    :html="true"
                    text="You set the storage type to Markdown. This means that comments will be stored in the page files. This may lead to issues when receiving a lot of comments at the same time. It is recommended to use a database storage type for better performance. Markdown storage also does not support batch operations. If you can, please consider switching to the sqlite storage type."
                    icon="bell"
                    style="padding: var(--spacing-6); margin-top: var(--spacing-6)"
                />
            </div>
            <k-box v-if="status !== 'in-progress'" style="--width: 1/4" align="center">
                <k-button variant="filled" icon="play" theme="green" size="lg" :click="this.getComments">
                    Start conversion
                </k-button>
            </k-box>
        </k-grid>

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
</template>
<script>
export default {
    props: {
        storageType: String,
    },
    data() {
        return {
            status: 'idle',
            comments: [],
            queue: [],
            processIndex: 0,
            processRunning: false,
            progressValue: 0,
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

            this.progressValue = (100 / this.queue.length) * this.processIndex

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

            panel.api.post(`komments/converter/convert`, comment).then((response) => {
                const convertedComment = this.comments.find((item) => item.pageUuid === comment.pageUuid)
                if (response.status === 'success') {
                    convertedComment.converted++
                } else {
                    convertedComment.failed++
                }
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
