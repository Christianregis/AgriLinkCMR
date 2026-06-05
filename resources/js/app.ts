import { createInertiaApp } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { configureEcho } from '@laravel/echo-vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { isLoading } from './Composables/useGlobalLoader';

configureEcho({
    broadcaster: 'reverb',
});


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
router.on('start', () => {
    isLoading.value = true
})

router.on('finish', () => {
    isLoading.value = false
})

router.on('error', () => {
    isLoading.value = false
})

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) })
            .use(createPinia())
            .mount(el);
    },
    progress: {
        color: 'green',
    },
});
