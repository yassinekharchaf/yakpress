# Le micro framework

### Sommaire

- [La structure](#la-structure)
- [Le cycle de vie de l'application](#le-cycle-de-vie-de-l-application)
- [Les constantes d'environnement](#les-constantes-d-environnement)
- [Les helpers](#les-helpers)
- [Les services providers](#les-services-providers)
- [La database](#la-database)
- Les Features
- Http
- Les resources

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

## Les helpers

Les helpers sont les fonctions charger en début du cycle de vie que l'on peut utiliser partout et qui nous facilite la vie. Elles se trouvent dans fichier `helpers.php`. Il en existe déjà quelques une.

:::tip conseil
C'est également dans le fichier `helpers.php` que vous rajouterez vos helpers. Actuellement il n'y a pas beaucoup de helpers car il existe déjà plusieurs helpers de wp. D'autres helpers de base viendrons s'ajouter en fonction des feedback des contributeurs.
:::

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

### HooksProvider

Ce provider charger le fichier `config/hooks.php` et associer les hooks (action et filtre) avec une méthode pour les executer en temps voulu.

:::tip conseil
Dans la plupart des cas il est conseiller d'utiliser un controller pour prendre en charge l'execution d'un hook
:::

`Providers/HooksProvider.php`

```php
<?php

namespace {{plugin_name}}\Providers;

class HooksProvider
{

  public static function boot()
  {
    $hooks  = config('hooks');

    $actions = $hooks['actions'];
    $filters = $hooks['filters'];

    // Ajout des actions et filtres
    foreach ($actions as $action) {
      add_action(...$action);
    }

    foreach ($filters as $filter) {
      add_filter(...$filter);
    }
  }
}
```

:::warning attention
Contrairement au fichier `features.php`, le fichier `hooks.php` ne peut pas encore être gérer par le CLI. Peut-être faut-il ouvrir une issue pour cela ;-)
:::
`config/hooks.php`

```php
<?php

/**
 * Dans ce fichier nous mettons tout les hooks (action et filter) qui pourrait-être utiliser dans l'application
 * exemple ['hook_name',[ClassName::class,'methode']]
 */

return [
  /**
   * Ajout des hooks action
   */
  'actions' => [

  ],

  /**
   * Ajout des hooks filtre
   */
  'filters' => [

	]
];
```

### RoutesProvider

Ce service charge le fichier `routes/action.php`. Dans ce fichier action on retrouvera les hooks du type `admin_action_{$action}`, `admin_post_nopriv_{$action}`, `admin_post_{$action}`, `wp_ajax_{$action}` et `wp_ajax_nopriv_{$action}`.
Ces actions sont alors lier a la méthode d'un controller qui sera executer le moment voulu.

```php
<?php

namespace Pluginname\Providers;

class RoutesProvider
{

  public static function boot()
  {
    $routes  = include(PREFIX_PLUGIN_DIR . 'routes/action.php');

    //On charge les différentes types de routes d'action
    foreach ($routes as $key => $actions) {
      foreach ($actions as $action) {
        $action[0] = $key . '_' . $action[0];
        add_action(...$action);
      }
    }
  }
}
```

`routes/action.php`

```php
<?php

/**
 * Ce fichier renvoi un tableau trier sur les actions utiliser pour l'admin, le front et le front en mode connecter
 */
return [
  // Tableau des actions poster dans l'admin
  'admin_action' => [
    //['action-name', [ClassName::class, 'method']],

  ],
  // Tableau des actions post sur le front en étant connecté
  'admin_post' => [],
  // Tableau des actions post sur le front sans être connecté
  'admin_post_nopriv' => [],
  // Tableau des actions ajax en étant connecté
  'wp_ajax' => [],
  // Tableau des action ajax sans être connecté
  'wp_ajax_nopriv' => []
];
```

## La database

- [La class Database](#la-class-database)
- [Les migrations](#les-migrations)

### La class Database

Le dossier `Database` contient le fichier `Database/Database.php` et le dossier `Database/Migrations`.
La class `Database` possède deux méthodes, `Database::create()` et `Database::drop()`. La première méthode est lancé par la la méthode `Setup::activation()` lors de l'activation du plugin et la deuxième par `Setup::uninstall()`.

:::tip conseil
Il est de bonne pratique de supprimer les tables créer par le plugin lors de la suppression de celui-ci. Cependant vous pouvez désactiver cela, vous avez le contrôle total.
:::

```php
<?php

namespace {{plugin_namespace}}\Database;



class Database
{

  /**
   * Méthode qui lance les migrations afin que chacune créé sa table dans la base de donnée.
   *
   * @return void
   */
  public static function create()
  {
		### CREATE TABLE ###

  }

	/**
   * Méthode qui lance les migrations afin que chacune supprime sa table dans la base de donnée.
   *
   * @return void
   */
  public static function drop()
  {
		### DROP TABLE ###

  }

}
```

### Les migrations

Le dossier `Database/Migrations` va lui contenir toutes les migrations pour les tables. Si les migrations sont créées à l'aide du CLI `wp yakpress migration`, elles seront alors directement ajouter au fichier `Database/Database.php` dans les méthodes `Database::create()` et `Database::drop()`.
Les class de migration possèdent deux méthode `CustomTable::up()` et `CustomTable::down()` pour supprimer une table. Cela est fait à l'aide de requête **sql** pure.

```php
<?php

namespace Pluginname\Database\Migrations;

class CustomTable
{

  /**
   * Création de la table
   *
   * @return void
   */
  public static function up()
  {
    // Nous récupérons l'objet $wpdb qui est global afin de pouvoir intéragir avec la base de donnée.
    global $wpdb;
    $table_name = $wpdb->prefix . "custom";
		// Requête sql pour créer une table
    $wpdb->query("");
	}

  /**
   * Création de la table
   *
   * @return void
   */
  public static function down()
  {
    // Nous récupérons l'objet $wpdb qui est global afin de pouvoir intéragir avec la base de donnée.
    global $wpdb;
    $table_name = $wpdb->prefix . "custom";
		// Requête sql pour supprimer une table
    $wpdb->query("");
	}
}
```
