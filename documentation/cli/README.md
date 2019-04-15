# CLI commande

La commande principal `yakpress` étant la commande `Scaffold_Command`.
Elle donne accès à des sous commande qui permette de construire très vite notre plugin en micro framework.

La commande de base est `wp yakpress <subcommande> <value> [--option] [--flag]`

Pour en savoir plus sur une commande il est possible d'utiliser `wp yakpress <subcommande> --help`.
Pour plus de simplicité encore il est possible d'utiliser `wp yakpress <subcommande> --prompt`. Ceci lancera alors un prompt qui permettra de remplir les informations au fur et à mesure.

- [plugin](#plugin)
- [post_type](#post-type)
- [taxonomy](#taxonomy)
- [metabox](#metabox)
- [widget](#widget)
- [section](#section)
- [page](#page)
- [model](#model)
- [controller](#controller)
- [middleware](#middleware)
- [provider](#provider)
- [migration](#migration)

## plugin

`wp yakpress plugin <name> [--nohelpers]`

| Propriété | Obligatoire | Description                                                                                                                                                                                              |
| --------- | :---------: | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| name      |     oui     | nom du plugin en valeur slug. Donc en miniscule sans espace ni caractère spéciaux                                                                                                                        |
| nohelpers |     non     | Ce flag permet de dire au cli qu'il ne faut pas créer de fichier helper. Cela est utile lorsque l'on créer plusieurs plugin dans une même application pour ne pas ce retrouver avec des helpers doublons |

## post_type

`wp yakpress post_type <name> --plugin=plugin-name`

Lorsque l'on créer le post type, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du post type.                                            |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## taxonomy

`wp yakpress taxonomy <name> --plugin=plugin-name`

Lorsque l'on créer la taxonomie, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la taxonomy.                                          |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## metabox

`wp yakpress metabox <name> --plugin=plugin-name`

Lorsque l'on créer la metabox, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la metabox.                                           |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## widget

`wp yakpress widget <name> --plugin=plugin-name`

Lorsque l'on créer le widget, celui-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargé.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la widget.                                            |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## section

`wp yakpress section <name> --plugin=plugin-name`

Lorsque l'on créer la section, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug de la section.                                           |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## page

`wp yakpress page <name> --plugin=plugin-name --controller --model`

Lorsque l'on créer la page, celle-ci est automatiquement ajouter au fichier de configuration `config/features.php` pour être automatiquement chargée.

| Propriété  | Obligatoire | Description                                                                    |
| ---------- | :---------: | :----------------------------------------------------------------------------- |
| name       |     oui     | slug de la page.                                                               |
| plugin     |     oui     | le nom du dossier plugin auquel le post type doit être ajouté                  |
| controller |     non     | slug du controller qui sera alors directement associé à la page                |
| model      |     non     | slug du model qui sera directement associé au controller s'il y en a un choisi |

## model

`wp yakpress model <name> --plugin=plugin-name --controller`

| Propriété  | Obligatoire | Description                                                   |
| ---------- | :---------: | :------------------------------------------------------------ |
| name       |     oui     | slug du model.                                                |
| plugin     |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |
| controller |     non     | un controller sera alors créer et associé au model            |

## controller

`wp yakpress controller <name> --plugin=plugin-name --model`

| Propriété  | Obligatoire | Description                                                   |
| ---------- | :---------: | :------------------------------------------------------------ |
| name       |     oui     | slug du controller.                                           |
| plugin     |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |
| controller |     non     | un model sera alors créer et le controller y sera associé     |

## middleware

`wp yakpress middleware <name> --plugin=plugin-name`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du middleware.                                           |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## provider

`wp yakpress provider <name> --plugin=plugin-name`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du provider.                                             |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |

## migration

`wp yakpress migration <name> --plugin=plugin-name`

| Propriété | Obligatoire | Description                                                   |
| --------- | :---------: | :------------------------------------------------------------ |
| name      |     oui     | slug du migration.                                            |
| plugin    |     oui     | le nom du dossier plugin auquel le post type doit être ajouté |
