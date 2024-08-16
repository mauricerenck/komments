<template>
    <k-drawer v-bind="$props">
        <CommentContent :spamlevel="comment.spamlevel" :content="comment.content" />

        <div class="k-table">
            <table style="table-layout: auto">
                <tbody>
                    <tr>
                        <th data-mobile="true">Id</th>
                        <td data-mobile="true">{{ comment.id }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Type</th>
                        <td data-mobile="true">{{ comment.type }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Language</th>
                        <td data-mobile="true">{{ comment.language }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Published</th>
                        <td data-mobile="true">{{ comment.published }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Verified</th>
                        <td data-mobile="true">{{ comment.verified }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Reply To</th>
                        <td data-mobile="true">{{ comment.parentid }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Spam level</th>
                        <td data-mobile="true">{{ comment.spamlevel }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Upvotes</th>
                        <td data-mobile="true">{{ comment.upvotes }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Downvotes</th>
                        <td data-mobile="true">{{ comment.downvotes }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Created at</th>
                        <td data-mobile="true">{{ comment.createdat }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Updated at</th>
                        <td data-mobile="true">{{ comment.updatedat }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Permalink</th>
                        <td data-mobile="true">{{ comment.permalink }}</td>
                    </tr>

                    <tr>
                        <th data-mobile="true">Author</th>
                        <td data-mobile="true">{{ comment.authorname }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Avatar</th>
                        <td data-mobile="true">{{ comment.authoravatar }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Email</th>
                        <td data-mobile="true">{{ comment.authoremail }}</td>
                    </tr>
                    <tr>
                        <th data-mobile="true">Url</th>
                        <td data-mobile="true">{{ comment.authorurl }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </k-drawer>
</template>

<script>
export default {
    mixins: ['drawer'],
    props: {
        comment: {
            type: Object,
            default: {},
        },
    },
}
</script>
