import View from './components/View.vue'
import DrawerDetails from './components/DrawerDetails.vue'
import TableIcon from './components/TableIcon.vue'
import CommentContent from './components/fields/CommentContent.vue'
import CommentsTable from './components/fields/CommentsTable.vue'
import TokenTable from './components/fields/TokenTable.vue'
import Converter from './components/fields/Converter.vue'

panel.plugin('mauricerenck/komments', {
    components: {
        'k-komments-view': View,
        CommentContent: CommentContent,
        CommentsTable: CommentsTable,
        TokenTable: TokenTable,
        Converter: Converter,
        TableIcon: TableIcon,
        'komments-detail-drawer': DrawerDetails,
    },
    fields: {
        CommentsTable: CommentsTable,
    },
    icons: {
        'indie-mention':
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>',
        'indie-repost':
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4H21C21.5523 4 22 4.44772 22 5V12H20V6H6V9L1 5L6 1V4ZM18 20H3C2.44772 20 2 19.5523 2 19V12H4V18H18V15L23 19L18 23V20Z"></path></svg>',
        'indie-sent':
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.99989 13.9999L4.99976 5L6.99976 4.99997L6.99986 11.9999L17.1717 12L13.222 8.05024L14.6362 6.63603L21.0001 13L14.6362 19.364L13.222 17.9497L17.1717 14L4.99989 13.9999Z"></path></svg>',
    },
})
