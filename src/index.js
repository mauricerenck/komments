import KommentsDeprecated from "./components/k35/KommentsView.vue";
import KommentsView from "./components/views/Komments.vue";
import KommentDetails from "./components/KommentDetails.vue";
import KommentList from "./components/KommentList.vue";
import KommentVersion from "./components/KommentVersion.vue";
import KommentsPending from "./components/fields/KommentsPending.vue";
import NoKomments from "./components/NoKomments.vue";


panel.plugin("mauricerenck/komments", {
    components: {
        'k-komments-view': KommentsView,
        'KommentDetails': KommentDetails,
        'KommentList': KommentList,
        'KommentVersion': KommentVersion,
        'NoKomments': NoKomments,
    },
    fields: {
        'komments': KommentsView,
        'kommentsPending': KommentsPending
    },
    // Kirby 3.5 backward compatibility
    views: {
        queuedKommments: {
            component: KommentsDeprecated,
            icon: "chat",
            label: "Komments"
        }
    }
});