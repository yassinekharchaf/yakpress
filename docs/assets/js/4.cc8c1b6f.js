(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{171:function(t,e,a){"use strict";a.r(e);var i=a(0),l=Object(i.a)({},function(){this.$createElement;this._self._c;return this._m(0)},[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content"},[a("h1",{attrs:{id:"cli-commande"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#cli-commande","aria-hidden":"true"}},[t._v("#")]),t._v(" CLI commande")]),t._v(" "),a("p",[t._v("La commande principal "),a("code",[t._v("yakpress")]),t._v(" étant la commande "),a("code",[t._v("Scaffold_Command")]),t._v(".\nElle donne accès à des sous commande qui permette de construire très vite notre plugin en micro framework.")]),t._v(" "),a("p",[t._v("La commande de base est "),a("code",[t._v("wp yakpress <subcommande> <value> [--option] [--flag]")])]),t._v(" "),a("p",[t._v("Pour en savoir plus sur une commande il est possible d'utiliser "),a("code",[t._v("wp yakpress <subcommande> --help")]),t._v(".\nPour plus de simplicité encore il est possible d'utiliser "),a("code",[t._v("wp yakpress <subcommande> --prompt")]),t._v(". Ceci lancera alors un prompt qui permettra de remplir les informations au fur et à mesure.")]),t._v(" "),a("ul",[a("li",[a("a",{attrs:{href:"#plugin"}},[t._v("plugin")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#post-type"}},[t._v("post_type")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#taxonomy"}},[t._v("taxonomy")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#metabox"}},[t._v("metabox")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#widget"}},[t._v("widget")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#section"}},[t._v("section")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#page"}},[t._v("page")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#model"}},[t._v("model")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#controller"}},[t._v("controller")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#middleware"}},[t._v("middleware")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#provider"}},[t._v("provider")])]),t._v(" "),a("li",[a("a",{attrs:{href:"#migration"}},[t._v("migration")])])]),t._v(" "),a("h2",{attrs:{id:"plugin"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#plugin","aria-hidden":"true"}},[t._v("#")]),t._v(" plugin")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress plugin <name> [--nohelpers]")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("nom du plugin en valeur slug. Donc en miniscule sans espace ni caractère spéciaux")])]),t._v(" "),a("tr",[a("td",[t._v("nohelpers")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("non")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("Ce flag permet de dire au cli qu'il ne faut pas créer de fichier helper. Cela est utile lorsque l'on créer plusieurs plugin dans une même application pour ne pas ce retrouver avec des helpers doublons")])])])]),t._v(" "),a("h2",{attrs:{id:"post-type"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#post-type","aria-hidden":"true"}},[t._v("#")]),t._v(" post_type")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress post_type <name> --plugin=plugin-name")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer le post type, celui-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargé.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du post type.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"taxonomy"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#taxonomy","aria-hidden":"true"}},[t._v("#")]),t._v(" taxonomy")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress taxonomy <name> --plugin=plugin-name")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer la taxonomie, celle-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargée.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug de la taxonomy.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"metabox"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#metabox","aria-hidden":"true"}},[t._v("#")]),t._v(" metabox")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress metabox <name> --plugin=plugin-name")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer la metabox, celle-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargée.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug de la metabox.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"widget"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#widget","aria-hidden":"true"}},[t._v("#")]),t._v(" widget")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress widget <name> --plugin=plugin-name")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer le widget, celui-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargé.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug de la widget.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"section"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#section","aria-hidden":"true"}},[t._v("#")]),t._v(" section")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress section <name> --plugin=plugin-name")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer la section, celle-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargée.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug de la section.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"page"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#page","aria-hidden":"true"}},[t._v("#")]),t._v(" page")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress page <name> --plugin=plugin-name --controller --model")])]),t._v(" "),a("p",[t._v("Lorsque l'on créer la page, celle-ci est automatiquement ajouter au fichier de configuration "),a("code",[t._v("config/features.php")]),t._v(" pour être automatiquement chargée.")]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug de la page.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])]),t._v(" "),a("tr",[a("td",[t._v("controller")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("non")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du controller qui sera alors directement associé à la page")])]),t._v(" "),a("tr",[a("td",[t._v("model")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("non")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du model qui sera directement associé au controller s'il y en a un choisi")])])])]),t._v(" "),a("h2",{attrs:{id:"model"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#model","aria-hidden":"true"}},[t._v("#")]),t._v(" model")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress model <name> --plugin=plugin-name --controller")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du model.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])]),t._v(" "),a("tr",[a("td",[t._v("controller")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("non")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("un controller sera alors créer et associé au model")])])])]),t._v(" "),a("h2",{attrs:{id:"controller"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#controller","aria-hidden":"true"}},[t._v("#")]),t._v(" controller")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress controller <name> --plugin=plugin-name --model")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du controller.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])]),t._v(" "),a("tr",[a("td",[t._v("controller")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("non")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("un model sera alors créer et le controller y sera associé")])])])]),t._v(" "),a("h2",{attrs:{id:"middleware"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#middleware","aria-hidden":"true"}},[t._v("#")]),t._v(" middleware")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress middleware <name> --plugin=plugin-name")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du middleware.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"provider"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#provider","aria-hidden":"true"}},[t._v("#")]),t._v(" provider")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress provider <name> --plugin=plugin-name")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du provider.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])]),t._v(" "),a("h2",{attrs:{id:"migration"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#migration","aria-hidden":"true"}},[t._v("#")]),t._v(" migration")]),t._v(" "),a("p",[a("code",[t._v("wp yakpress migration <name> --plugin=plugin-name")])]),t._v(" "),a("table",[a("thead",[a("tr",[a("th",[t._v("Propriété")]),t._v(" "),a("th",{staticStyle:{"text-align":"center"}},[t._v("Obligatoire")]),t._v(" "),a("th",{staticStyle:{"text-align":"left"}},[t._v("Description")])])]),t._v(" "),a("tbody",[a("tr",[a("td",[t._v("name")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("slug du migration.")])]),t._v(" "),a("tr",[a("td",[t._v("plugin")]),t._v(" "),a("td",{staticStyle:{"text-align":"center"}},[t._v("oui")]),t._v(" "),a("td",{staticStyle:{"text-align":"left"}},[t._v("le nom du dossier plugin auquel le post type doit être ajouté")])])])])])}],!1,null,null,null);e.default=l.exports}}]);