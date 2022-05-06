module.exports = {
	root: true,
	env: {
		node: true
	},
	extends: [
		"eslint:recommended",
		"plugin:@typescript-eslint/recommended",
		"plugin:prettier/recommended",
		"plugin:vue/vue3-essential",
		"prettier"
	],
	parser: "vue-eslint-parser",
	parserOptions: {
		ecmaVersion: 2022,
		parser: "@typescript-eslint/parser",
		sourceType: "module"
	},
	plugins: ["prettier", "@typescript-eslint"],
	rules: {
		"eol-last": "error",
		"no-cond-assign": "error",
		"no-console": process.env.NODE_ENV === "production" ? "error" : "warn",
		"no-const-assign": "error",
		"no-debugger": process.env.NODE_ENV === "production" ? "error" : "warn",
		"quotes": ["warn", "single", { avoidEscape: true }],
		"vue/multi-word-component-names": "off"
	},
	noInlineConfig: true,
	overrides: [
		{
			files: ["**/__tests__/*.{j,t}s?(x)", "**/tests/unit/**/*.spec.{j,t}s?(x)"],
			env: {
				jest: true
			}
		}
	]
};
