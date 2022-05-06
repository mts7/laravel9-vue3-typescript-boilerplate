import { shallowMount } from "@vue/test-utils";
import Index from "../Index.vue";

describe('Index.vue', () => {
	let wrapper;

	beforeEach(() => {
		wrapper = shallowMount(Index);
	});

	it('adds a name to the names array', () => {
		expect(wrapper.vm.names).toEqual(['Page - Index']);
	});

	it('gets the first name from names', () => {
		expect(wrapper.vm.getString()).toEqual('Page - Index');
	});
});
