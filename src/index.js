import KommentsView from "./components/Views/Komments.vue";
import KommentDetails from "./components/KommentDetails.vue";
import KommentList from "./components/KommentList.vue";
import KommentVersion from "./components/KommentVersion.vue";
import KommentsPending from "./components/fields/KommentsPending.vue";


panel.plugin("mauricerenck/komments", {
    components: {
        'k-komments-view': KommentsView,
        'KommentDetails': KommentDetails,
        'KommentList': KommentList,
        'KommentVersion': KommentVersion,
    },
    fields: {
        'komments': KommentsView,
        'kommentsPending': KommentsPending
    }
});