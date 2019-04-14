# Le micro framework

### Sommaire

- [La structure](#la-structure)
- [Le cycle de vie de l'application](#le-cycle-de-vie-de-l-application)
- [les constantes d'environnement](#les-constantes-d-environnement)
- [Les services providers](#les-services-providers)

## La structure

```sh
Plugin
├── Pluginname
│   ├── Database
│   │   ├── Database.php
│   │   └── Migrations
│   ├── Features
│   │   ├── MetaBoxes
│   │   ├── Pages
│   │   ├── PostTypes
│   │   ├── Sections
│   │   ├── Taxonomies
│   │   └── Widgets
│   ├── Http
│   │   ├── Controllers
│   │   ├── Middlewares
│   │   ├── Models
│   │   │   └── Mail.php
│   │   └── Requests
│   │       └── Request.php
│   ├── Providers
│   │   ├── FeaturesProvider.php
│   │   ├── HooksProvider.php
│   │   ├── RoutesProvider.php
│   │   └── ServicesProvider.php
│   └── Setup.php
├── autoload.php
├── bootstrap.php
├── config
│   ├── features.php
│   ├── hooks.php
│   └── providers.php
├── env.php
├── helpers.php
├── plugin-name.php
├── resources
│   ├── assets
│   │   ├── css
│   │   └── js
│   └── views
└── routes
    └── action.php
```

## Le cycle de vie de l'application

> Nous n'allons pas expliquer le cycle de vie de l'application wordpress mais uniquement celui de notre plugin lors de son chargement

### Étape 1

Wordpress commence tout d'abord par charger le fichier qui comporte ne nom du plugin `plugin-name.php`. Ce fichier n'a pour rôle que de charger le fichier `autoload.php` et de lancer l'application via le fichier `bootstrap.php`

```php
<?php
/**
 * Plugin Name:     Plugin Name
 * ...
 */


require_once('autoload.php');

require_once('bootstrap.php');
```

### Étape 2

Le fichier `autoload.php` va nous facilité la vie et charger automatiquement toutes les classes qui se trouve au sein du dossier `Pluginname`.

Le fichier `bootstrap.php` va lui charger les variables d'environnement, les helpers, faire le setup de l'application et enregistrer les services providers.

```php
<?php

use Pluginname\Providers\ServicesProvider;
use Pluginname\Setup;

// Chargement des variables d'environnement
require_once('env.php');

// Ajout du fichier helpers.php pour disposé des fonctions helper
require_once('helpers.php');

// Setup de l'application
Setup::init();

//Chargement des services providers
ServicesProvider::register();
```

### Étape 3

La Class Setup va elle se charger des événements particulier lié à l'activation du plugin, sa désactivation et sa suppression. Trois méthode sont prévu à cette effet pour effectuer vos actions.
Pour exemple, c'est à l'activation de l'applicatioin que l'on va lancer les fichiers de migration pour créer des tables supplémentaires dans notre base de donnée et lors de la suppression on lancera l'action pour les supprimer.

```php
<?php

namespace Pluginname


class Setup
{

  public static function init()
  {
    $plugin = PLU_PLUGIN_DIR . '/pluginname.php';
    register_activation_hook($plugin, [self::class, 'activation']);
    register_deactivation_hook($plugin, [self::class, 'deactivation']);
    register_uninstall_hook($plugin, [self::class, 'uninstall']);
  }

  /**
   * Fonction lancé lors de l'activation du plugin
   *
   * @return void
   */
  public static function activation()
  { }

  /**
   * Fonction appelé lors de la désactivation du plugin
   *
   * @return void
   */
  public static function deactivation()
  { }

  /**
   * Fonction appelé lors de la désinstallation du plugin
   *
   * @return void
   */
  public static function uninstall()
  { }

}
```

### Étape 4

La classe `ServicesProvider` va charger les services providers principaux.

- `FeaturesProvider` pour les éléments propres à wordpress.
- `HooksProvider` va charger tout les hooks et associer une méthode callback.
- `RoutesProvider` va associer une méthode callback à request personnalisé que l'on aura créé.

> Les services providers `Features` et `Hooks` charge le tout grâce aux fichiers de configuration que ce trouve dans le dossier `config`. Pour le service `Routes` il charge le fichier `action.php` qui se trouve dans le dossier `routes`.

## Les constantes d'environnement

Le fichier `env.php` a pour but de stocker les constantes d'environnement d'on vous pourriez avoir besoin pour votre application. il en existe déjà quelques une de base.

- `PREFIX_PLUGIN_URL` renvoi le chemin url pour le plugin
- `PREFIX_PLUGIN_DIR` renvoi le chemin serveur pour le plugin
- `PREFIX_VIEW_DIR` renvoi le chemin serveur pour le dossier `views`
- `PREFIX_CONFIG_DIR` renvoi le chemin serveur pour le dossier `conf`

## Les services providers

> Il existe 4 services providers de base mais il est possible d'en rajouter d'autre grâce à la commande
> `wp yakpress provider`

- [ServicesProvider](#servicesprovider)
- [FeaturesProvider](#featuresprovider)
- [HooksProvider](#hooksprovider)
- [RoutesProvider](#routesprovider)

### ServicesProvider

Ce service charge de charger tout les services. Il charge le fichier `config/providers.php` et lance le méthode `boot` des différentes class.

```php
<?php

namespace Pluginname\Providers;

class ServicesProvider
{
	/**
	 * Enregistrement des providers.
	 * Nous chargeons tout les providers du fichier config providers.php
	 * et nous lançons leur méthode 'boot' pour le démarrage.
	 *
	 * @return void
	 */
	public static function register()
	{
		$providers = config('providers');

		foreach ($providers as $provider) {
			call_user_func([$provider, 'boot']);
		}
	}
}
```

le fichier chargé est le suivant `config/providers.php`

```php
<?php

/**
 * ce fichier renvoi un tableau avec tout les providers que l'on souhaite charger
 */

return [
  \Pluginname\Providers\FeaturesProvider::class,
  \Pluginname\Providers\RoutesProvider::class,
  \Pluginname\Providers\HooksProvider::class,
];
```

### FeaturesProvider

Ce provider charge le fichier `config/features.php` et associe un hook avec une méthode pour créer un feature personnalisé de wordpress.

```php
<?php

namespace Pluginname\Providers;

class FeaturesProvider
{
	/**
	 * Ajout d'un add action pour chaque feature
	 *
	 * @return void
	 */
	public static function boot()
	{
		$features = config('features');
		foreach ($features as $feature) {
			add_action(...$feature);
		}
	}
}
```

Le fichier charger est le fichier de config config/features.php. Ce fichier renvoie un tableau avec les données pour associé le hook au à la méthode qui va se charger de créer le feature.

:::warning Attention
il faut bien respecter le format de donner de chaque entrer du tableau.
:::

:::tip info
le fichier `config/features.php` est commenter pour être bien organisé.
Si vous créer des features avec le cli, le cli entrera automatiquement les données dans le tableau de manière structurer.

exemple : `wp yakpress post_type evenement --plugin=plugin-name`
:::

`config/features.php`

```php
<?php

/**
 * Ce fichier renvoi un tableau avec tout les features (éléments propre à wordpress).
 * Ce tableau est constituer de tableaux qui contienne les paramêtres qui seront passé à une fonction 'add_action'.
 * exemple ['hook_name',[ClassName::class,'methode']]
 */

return [

	### POST TYPES ###

	### METABOXES ###

	### TAXONOMIES ###

	### WIDGETS ###

	### SECTIONS ###

	### PAGES ###

];
```
