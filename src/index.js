import View from "./components/View.vue";

panel.plugin("mauricerenck/komments", {
    views: {
        queuedKommments: {
            component: View,
            icon: "chat",
            label: "Komments"
        }
    }
});