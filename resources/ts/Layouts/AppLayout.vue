<template>
    <div>
        <h2>Hi, banana.</h2>

        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
	data() {
		return {
			showingNavigationDropdown: false,
		};
	},

	methods: {
		switchToTeam(team) {
			this.$inertia.put(
				route('current-team.update'),
				{
					team_id: team.id,
				},
				{
					preserveState: false,
				},
			);
		},

		logout() {
			this.$inertia.post(route('logout'));
		},
	},
});
</script>
