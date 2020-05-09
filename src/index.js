import View from "./components/View.vue";
import Gravatar from "./components/fields/Gravatar.vue";

panel.plugin("mauricerenck/komments", {
    views: {
        queuedKommments: {
            component: View,
            icon: "chat",
            label: "Komments"
        }
    },
    fields: {
        gravatar: Gravatar
    }
});