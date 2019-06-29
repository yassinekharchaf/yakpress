# CLI commande

Les commandes étendent la commande `Scaffold_Command`.
Elles permettent de construire très vite notre plugin/theme en micro framework.

La commande de base est `wp <commande> <name> [--option] [--flag]`

Pour en savoir plus sur les commandes il est possible d'utiliser `wp <commande> --help`.
Pour plus de simplicité encore il est possible d'utiliser `wp <commande> --prompt`. Ceci lancera alors un prompt qui permettra de remplir les informations au fur et à mesure.

| plugin                                  | theme                                 | autre                 |
| --------------------------------------- | ------------------------------------- | --------------------- |
| [plugin:new](#plugin-new)               | [theme:new](#theme-new)               | [morphing](#morphing) |
| [plugin:posttype](#plugin-posttype)     | [theme:posttype](#theme-posttype)     | [add:twig](#add-twig) |
| [plugin:taxonomy](#plugin-taxonomy)     | [theme:taxonomy](#theme-taxonomy)     |                       |
| [plugin:metabox](#plugin-metabox)       | [theme:metabox](#theme-metabox)       |                       |
| [plugin:widget](#plugin-widget)         | [theme:widget](#theme-widget)         |                       |
| [plugin:section](#plugin-section)       | [theme:section](#theme-section)       |                       |
| [plugin:page](#plugin-page)             | [theme:page](#theme-page)             |                       |
| [plugin:model](#plugin-model)           | [theme:model](#theme-model)           |                       |
| [plugin:controller](#plugin-controller) | [theme:controller](#theme-controller) |                       |
| [plugin:middleware](#plugin-middleware) | [theme:middleware](#theme-middleware) |                       |
| [plugin:provider](#plugin-provider)     | [theme:provider](#theme-provider)     |                       |
| [plugin:seed](#plugin-seed)             | [theme:seed](#theme-seed)             |                       |
| [plugin:block](#plugin-block)           | [theme:block](#theme-block)           |                       |
| [plugin:migration](#plugin-migration)   | [theme:customizer](#theme-customizer) |                       |

## plugin

### plugin:new

`wp plugin:new <name> [--nohelpers]`

| Propriété | Obligatoire | Description                                                                                                                                                                                              |
| --------- | :---------: | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| name      |     oui     | nom du plugin en valeur slug. Donc en miniscule sans espace ni caractère spéciaux                                                                                                                        |
| nohelpers |     non     | Ce flag permet de dire au cli qu'il ne faut pas créer de fichier helper. Cela est utile lorsque l'on créer plusieurs plugin dans une même application pour ne pas ce retrouver avec des helpers doublons |

### plugin:posttype

`wp plugin:posttype <name> [--plugin=plugin-name]`

Lorsque l'on créer le post type, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du post type.                                            |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:taxonomy

`wp plugin:taxonomy <name> [--plugin=plugin-name]`

Lorsque l'on créer la taxonomie, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la taxonomy.                                          |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:metabox

`wp plugin:metabox <name> [--plugin=plugin-name]`

Lorsque l'on créer la metabox, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la metabox.                                           |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:widget

`wp plugin:widget <name> [--plugin=plugin-name]`

Lorsque l'on créer le widget, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la widget.                                            |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:section

`wp plugin:section <name> [--plugin=plugin-name]`

Lorsque l'on créer la section, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la section.                                           |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:page

`wp plugin:page <name> [--plugin=plugin-name] [--controller] ]--model]`

Lorsque l'on créer la page, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété  | Obligatoire | Description                                                                    |
| ---------- | :---------: | :----------------------------------------------------------------------------- |
| name       |     oui     | slug de la page.                                                               |
| plugin     |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin                  |
| controller |     non     | slug du controller qui sera alors directement associé à la page                |
| model      |     non     | slug du model qui sera directement associé au controller s'il y en a un choisi |

### plugin:model

`wp plugin:model <name> --plugin=plugin-name [--controller]`

| Propriété  | Obligatoire | Description                                                   |
| ---------- | :---------: | :------------------------------------------------------------ |
| name       |     oui     | slug du model.                                                |
| plugin     |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |
| controller |     non     | un controller sera alors créer et associé au model            |

### plugin:controller

`wp plugin:controller <name> [--plugin=plugin-name] [--model]`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du controller.                                           |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |
| model     |     non     | un model sera alors créer et le controller y sera associé     |

### plugin:middleware

`wp plugin:middleware <name> [--plugin=plugin-name]`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du middleware.                                           |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:provider

`wp plugin:provider <name> [--plugin=plugin-name]`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du provider.                                             |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:seed

`wp plugin:seed <seed-name> [--plugin=plugin-name]`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| seed-name |     oui     | slug du seed.                                                 |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

### plugin:block

`wp plugin:block <block-name> [--plugin=plugin-name]`

| Propriété  | Obligatoire | Description                                                   |
| ---------- | :---------: | :------------------------------------------------------------ |
| block-name |     oui     | slug du block.                                                |
| plugin     |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

:::warning
Pour compiler votre block gutenberg en es5, `cd resources/src/`
`./node_modules/.bin/wp-scripts start|build blocks/blockname.js -o ../assets/blocks/blockname.js`
:::warning

### plugin-migration

`wp theme:migration <name> [--theme=theme-name]`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du migration.                                            |
| plugin    |     non     | Pas obligatoire si on se trouve à la racine du dossier plugin |

## Theme

### theme:new

`wp theme:new <name> [--nohelpers]`

| Propriété | Obligatoire | Description                                                                                                                                                                                             |
| --------- | :---------: | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| name      |     oui     | nom du theme en valeur slug. Donc en miniscule sans espace ni caractère spéciaux                                                                                                                        |
| nohelpers |     non     | Ce flag permet de dire au cli qu'il ne faut pas créer de fichier helper. Cela est utile lorsque l'on créer plusieurs theme dans une même application pour ne pas ce retrouver avec des helpers doublons |

### theme:posttype

`wp theme:posttype <name> [--theme=theme-name]`

Lorsque l'on créer le post type, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug du post type.                                           |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:taxonomy

`wp theme:taxonomy <name> [--theme=theme-name]`

Lorsque l'on créer la taxonomie, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug de la taxonomy.                                         |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:metabox

`wp theme:metabox <name> [--theme=theme-name]`

Lorsque l'on créer la metabox, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug de la metabox.                                          |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:widget

`wp theme:widget <name> [--theme=theme-name]`

Lorsque l'on créer le widget, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug de la widget.                                           |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:section

`wp theme:section <name> [--theme=theme-name]`

Lorsque l'on créer la section, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug de la section.                                          |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:page

`wp theme:page <name> [--theme=theme-name] [--controller] ]--model]`

Lorsque l'on créer la page, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété  | Obligatoire | Description                                                                    |
| ---------- | :---------: | :----------------------------------------------------------------------------- |
| name       |     oui     | slug de la page.                                                               |
| theme      |     non     | Pas obligatoire si on se trouve à la racine du dossier theme                   |
| controller |     non     | slug du controller qui sera alors directement associé à la page                |
| model      |     non     | slug du model qui sera directement associé au controller s'il y en a un choisi |

### theme:model

`wp theme:model <name> --theme=theme-name [--controller]`

| Propriété  | Obligatoire | Description                                                  |
| ---------- | :---------: | :----------------------------------------------------------- |
| name       |     oui     | slug du model.                                               |
| theme      |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |
| controller |     non     | un controller sera alors créer et associé au model           |

### theme:controller

`wp theme:controller <name> [--theme=theme-name] [--model]`

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug du controller.                                          |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |
| model     |     non     | un model sera alors créer et le controller y sera associé    |

### theme:middleware

`wp theme:middleware <name> [--theme=theme-name]`

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug du middleware.                                          |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:provider

`wp theme:provider <name> [--theme=theme-name]`

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug du provider.                                            |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:seed

`wp theme:seed <seed-name> [--theme=theme-name]`

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| seed-name |     oui     | slug du seeder.                                              |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

:::warning
Pour compiler votre block gutenberg en es5, `cd resources/src/`
`./node_modules/.bin/wp-scripts start|build blocks/blockname.js -o ../assets/blocks/blockname.js`
:::warning

### theme:block

`wp theme:block <block-name> [--theme=theme-name]`

| Propriété  | Obligatoire | Description                                                  |
| ---------- | :---------: | :----------------------------------------------------------- |
| block-name |     oui     | slug du blocker.                                             |
| theme      |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

### theme:customizer

`wp theme:provider <customizer-name> [--theme=theme-name]`

| Propriété | Obligatoire | Description                                                  |
| --------- | :---------: | :----------------------------------------------------------- |
| name      |     oui     | slug du customizer.                                          |
| theme     |     non     | Pas obligatoire si on se trouve à la racine du dossier theme |

## Autres

### morphing

`wp yakpress morphing --wp-content=<new-content-name> --plugins=<new-plugin-name> --uploads=<new-uploads-name>`

| Propriété  | Obligatoire | Description                          |
| ---------- | :---------: | :----------------------------------- |
| wp-content |     oui     | le nouveau nom du dossier wp-content |
| plugins    |     oui     | le nouveau nom du dossier plugins    |
| uploads    |     oui     | le nouveau nom du dossier uploads    |

### add:twig

`wp add:twig`

Aucune config supplémentaire n'est requises.
