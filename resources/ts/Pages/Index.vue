<template lang="pug">
AppLayout
    h2 Welcome, {{ getString() }}
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

export default defineComponent({
	components: {
		AppLayout,
	},
	mounted() {
		this.names.push('Page - Index');
	},
	data() {
		return {
			names: [],
		};
	},
	methods: {
		getString(): string {
			return this.names[0];
		},
	},
});
</script>
