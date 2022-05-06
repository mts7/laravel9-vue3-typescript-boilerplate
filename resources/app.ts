import { createApp, h } from 'vue';
import { App, plugin as inertiaPlugin } from '@inertiajs/inertia-vue3';

const el = document.getElementById('app')!;

createApp({
	render: () =>
		h(App, {
			initialPage: JSON.parse(el.dataset.page!),
			resolveComponent: async (name: string) => {
				return (await import(`./Pages/${name}.vue`)).default;
			},
		}),
})
	.use(inertiaPlugin)
	.mount(el);
