<template>
	<div>
		<h1>Welcome, {{ getString() }}</h1>
	</div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
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
