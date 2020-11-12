import View from "./components/View.vue";
import Gravatar from "./components/fields/Gravatar.vue";
import KommentsPendingField from "./components/fields/KommentsPending.vue";

panel.plugin("mauricerenck/komments", {
    views: {
        queuedKommments: {
            component: View,
            icon: "chat",
            label: "Komments"
        }
    },
    fields: {
        gravatar: Gravatar,
        kommentsPending: KommentsPendingField
    }
});