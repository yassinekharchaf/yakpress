module.exports = {
	title: "Yakpress ",
	description: "A micro framework to build wordpress plugin",
	dest: "../docs/",
	base: "/yakpress/",
	markdown: {
		lineNumbers: true
	},
	themeConfig: {
		sidebar: "auto",
		nav: [

			{
				text: "Home",
				link: "/"
			},
			{
				text: "Get started",
				link: "/guide/"
			},
			{
				text: "CLI",
				link: "/cli/"
			},
			{
				text: "Framework",
				link: "/framework/"
			},
			{
				text: "Github",
				link: "https://github.com/yassinekharchaf/yakpress"
			}
		],
		sidebar: [
			"/",
			"/guide/",
			"/cli/",
			["/framework/", "Framework"],
		]
	},

}
