import Vue from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Plugin } from "vue-fragment";
import Buefy from "buefy";
import { ZiggyVue } from '@ziggy';
import { momentPlugin } from "./plugins";
import 'vue-cal/dist/vuecal.css'
import VCalendar from 'v-calendar';

if(import.meta.hot) {
    import.meta.hot.on("vite:beforeUpdate",
    /* eslint-disable-next-line no-console */
    () => console.clear()
    );
}

Vue.config.productionTip = false;

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin);
        Vue.use(Buefy, {
            defaultIconPack: "bi",
            customIconPacks: {
                "bi": {
                    iconPrefix: "bi-",
                    internalIcons: {
                        'minus': "dash",
                        'alert-circle': "exclamation-circle-fill"
                    }
                }
            }
        });
        Vue.use(VCalendar, {
            componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
                     // ...other defaults
        });
        Vue.use(Plugin);
        Vue.use(ZiggyVue, Ziggy);
        Vue.use(momentPlugin);
        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});

InertiaProgress.init();
