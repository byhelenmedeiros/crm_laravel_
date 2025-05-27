import "./bootstrap";
import "../css/app.css";

import { createApp, h, watch } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createPinia } from "pinia";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { useAuthStore } from "@/stores/authstore";

const appName = import.meta.env.VITE_APP_NAME || "UIN SPORTS";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        const pinia = createPinia();
        app.use(pinia); 
        app.use(plugin);
        app.use(ZiggyVue);
        app.component("FontAwesomeIcon", FontAwesomeIcon);
        app.use(Toast, {
            position: "top-right",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
        });

        const authStore = useAuthStore();

        // Sincroniza o store auth com os dados do usuário enviados pelo Inertia
        watch(
            () => props.auth?.user,
            (newUser) => {
                if (newUser) {
                    authStore.setUser(newUser);
                }
            },
            { immediate: true } 
        );
        

        app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
