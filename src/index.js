import View from './components/View.vue'
import DrawerDetails from './components/DrawerDetails.vue'
import DrawerReply from './components/DrawerReply.vue'
import KommentDetails from './components/KommentDetails.vue'
import KommentList from './components/KommentList.vue'
import KommentsPending from './components/fields/KommentsPending.vue'
import NoKomments from './components/NoKomments.vue'

panel.plugin('mauricerenck/komments', {
    components: {
        'k-komments-view': View,
        KommentDetails: KommentDetails,
        KommentList: KommentList,
        NoKomments: NoKomments,
        'komments-detail-drawer': DrawerDetails,
        'komments-reply-drawer': DrawerReply,
    },
    fields: {
        // komments: KommentsView,
        kommentsPending: KommentsPending,
    },
})
