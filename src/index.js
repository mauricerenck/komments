import KommentsView from "./components/views/Komments.vue";
import KommentDetails from "./components/KommentDetails.vue";
import KommentList from "./components/KommentList.vue";
import KommentsPending from "./components/fields/KommentsPending.vue";
import NoKomments from "./components/NoKomments.vue";


panel.plugin("mauricerenck/komments", {
    components: {
        'k-komments-view': KommentsView,
        'KommentDetails': KommentDetails,
        'KommentList': KommentList,
        'NoKomments': NoKomments,
    },
    fields: {
        'komments': KommentsView,
        'kommentsPending': KommentsPending
    },
});