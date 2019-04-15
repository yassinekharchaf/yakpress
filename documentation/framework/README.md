# Le micro framework

### Sommaire

- [La structure](#la-structure)
- [Le cycle de vie de l'application](#le-cycle-de-vie-de-l-application)
- [Les constantes d'environnement](#les-constantes-d-environnement)
- [Les helpers](#les-helpers)
- [Les services providers](#les-services-providers)
- [La database](#la-database)
- [Les Features](#les-features)
- [Http](#http)
- [Les resources](#les-resources)

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
Si vous créer des features avec le [CLI](/cli/#provider), le [CLI](/cli/#provider) entrera automatiquement les données dans le tableau de manière structurer.

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

Le dossier `Database/Migrations` va lui contenir toutes les migrations pour les tables. Si les migrations sont créées à l'aide du [CLI](/cli/#migration) `wp yakpress migration`, elles seront alors directement ajouter au fichier `Database/Database.php` dans les méthodes `Database::create()` et `Database::drop()`.
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

## Les Features

Cette partie du Framework est dédiée aux composant de base que wordpress nous permet de rajouter facilement. Le framework Yakpress permet de créer ses composant facilement et de les chargers automatiquement lors de la création avec le [CLI](/cli/).

- [PostTypes](#postyptes)
- [Taxonomies](#taxonomies)
- [MetaBoxes](#metaboxes)
- [Widgets](#widgets)
- [Sections](#sections)
- [Pages](#pages)

### PostTypes

Il est possible de créer facilement un type de contenu personnalisé avec le [CLI](/cli/#post-type) et de le charger automatiquement `wp yakpress post_type`

Cela créer alors un fichier préfait avec tout les labels et options possible à mettre. Il suffit de décommenter ceux dont on a besoin pour les personnaliser et de supprimer le reste. Comme pout la plupart des autre Features, le **slug** du composant est en propriété de la class afin de pouvoir être facilement référencé depuis une autre feature.

```php
<?php

namespace Pluginname\Features\PostTypes;

class CustomPostType
{
  public static $slug = 'custom';
  /**
   * Enregistrement du type de contenu recipe
   *
   * @return void
   */
  public static function register()
  {
    // label pour le type de contenu
    $labels = array(
      //'name' => __('Post'),
      //'singular_name' => __('Post'),
      //'add_new' => __('Add new post'),
      // 'add_new_item' => array(__('Add New Post'), __('Add New Page')),
      // 'edit_item' => array(__('Edit Post'), __('Edit Page')),
      // 'new_item' => array(__('New Post'), __('New Page')),
      // 'view_item' => array(__('View Post'), __('View Page')),
      // 'view_items' => array(__('View Posts'), __('View Pages')),
      // 'search_items' => array(__('Search Posts'), __('Search Pages')),
      // 'not_found' => array(__('No posts found.'), __('No pages found.')),
      // 'not_found_in_trash' => array(__('No posts found in Trash.'), __('No pages found in Trash.')),
      // 'parent_item_colon' => array(null, __('Parent Page:')),
      // 'all_items' => array(__('All Posts'), __('All Pages')),
      // 'archives' => array(__('Post Archives'), __('Page Archives')),
      // 'attributes' => array(__('Post Attributes'), __('Page Attributes')),
      // 'insert_into_item' => array(__('Insert into post'), __('Insert into page')),
      // 'uploaded_to_this_item' => array(__('Uploaded to this post'), __('Uploaded to this page')),
      // 'featured_image' => array(_x('Featured Image', 'post'), _x('Featured Image', 'page')),
      // 'set_featured_image' => array(_x('Set featured image', 'post'), _x('Set featured image', 'page')),
      // 'remove_featured_image' => array(_x('Remove featured image', 'post'), _x('Remove featured image', 'page')),
      // 'use_featured_image' => array(_x('Use as featured image', 'post'), _x('Use as featured image', 'page')),
      // 'filter_items_list' => array(__('Filter posts list'), __('Filter pages list')),
      // 'items_list_navigation' => array(__('Posts list navigation'), __('Pages list navigation')),
      // 'items_list' => array(__('Posts list'), __('Pages list')),
      // 'item_published' => array(__('Post published.'), __('Page published.')),
      // 'item_published_privately' => array(__('Post published privately.'), __('Page published privately.')),
      // 'item_reverted_to_draft' => array(__('Post reverted to draft.'), __('Page reverted to draft.')),
      // 'item_scheduled' => array(__('Post scheduled.'), __('Page scheduled.')),
      // 'item_updated' => array(__('Post updated.'), __('Page updated.')),

    );

    $options = array(
      // 'labels' => $labels,
      // 'description' => '',
      // 'public' => true,
      // 'hierarchical' => false,
      // 'exclude_from_search' => null,
      // 'publicly_queryable' => null,
      // 'show_ui' => null,
      // 'show_in_menu' => null,
      // 'show_in_nav_menus' => null,
      // 'show_in_admin_bar' => null,
      // 'menu_position' => null,
      // 'menu_icon' => null,
      // 'capability_type' => 'post',
      // 'capabilities' => array(),
      // 'map_meta_cap' => null,
      // 'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
      // 'register_meta_box_cb' => null,
      // 'taxonomies' => array(),
      // 'has_archive' => false,
      // 'rewrite' => true,
      // 'query_var' => true,
      // 'can_export' => true,
      // 'delete_with_user' => null,
      // 'show_in_rest' => false,// mettre à true si on veut utiliser gutenberg
      // 'rest_base' => false,
      // 'rest_controller_class' => false,
      // '_builtin' => false,
      // '_edit_link' => 'post.php?post=%d',
    );

    register_post_type(
      self::$slug,
      $options
    );

  }
}
```

### Taxonomies

Il est possible de créer facilement une taxonomie personnalisé avec le [CLI](/cli/#taxonomy) et de le charger automatiquement `wp yakpress taxonomy`

Cela créer alors un fichier préfait avec tout les labels et arguments possible à mettre. Il suffit de décommenter ceux dont on a besoin pour les personnaliser et de supprimer le reste. Comme pout la plupart des autre Features, le **slug** du composant est en propriété de la class afin de pouvoir être facilement référencé depuis une autre feature.

```php
<?php

namespace Pluginname\Features\Taxonomies;



class CustomTaxonomy
{
  public static $slug = 'custom';
  /**
   * Enregistrement de la Taxonomie
   * @return void
   */
  public static function register()
  {

    $labels = [// les labels pour la taxonomie
      'name' => __(''),
      'singular_name' => __(''),
      'search_items' => __(''),
      'all_items' => __(''),
      'parent_item' => __(''),
      'parent_item_colon' => __(''),
      'edit_item' => __(''),
      'update_item' => __(''),
      'add_new_item' => __(''),
      'new_item_name' => __(''),
      'menu_name' => __(''),
    ];
    $args = [
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => ['slug' => self::$slug],
    ];
    // ajout de la taxonomie pour le type de contenu recipe
    register_taxonomy(self::$slug, [CustomPostType::$slug], $args);

  }
}
```

### MetaBoxes

Il est possible de créer facilement une metabox personnalisé avec le [CLI](/cli/#metabox) et de la charger automatiquement `wp yakpress metabox`

Cela créer alors un fichier préfait avec 3 méthodes. `CustomMetabox::add_meta_box()` pour associer la metabox avec différent **screen**, `CustomMetabox::render()` pour récuperer des datas et les renvoyer vers une vue qui sera charger d'afficher le contenu de la metabox et `CustomMetabox::save()` pour gérer la sauvegarde des datas de la metabox.

Comme pout la plupart des autre Features, le **slug** du composant est en propriété de la class afin de pouvoir être facilement référencé depuis une autre feature.

```php
<?php

namespace Pluginname\Features\MetaBoxes;


class CustomMetabox
{

  public static $slug = 'custom';

  /**
   * Ajout d'une méta box au type de contenu qui sont passer dans le tableau $screens
   *
   * @return void
   */
  public static function add_meta_box()
  {
    $screens = [];

    foreach ($screens as $screen) {
      add_meta_box(
        self::$slug,
        __("Titre de la metabox"),
        [self::class, 'render'],
        $screen
      );
    }
  }

  /**
   * Fonction pour rendre le code html dans la metabox
   *
   * @return void
   */
  public static function render()
  {

  }

  /**
   * sauvegarde des donners de la métabox
   *
   * @param int $post_id reçu par le do_action
   * @return void
   */
  public static function save(int $post_id)
  {

  }
}
```

### Widgets

Il est possible de créer facilement un widget personnalisé avec le [CLI](/cli/#widget) et de la charger automatiquement `wp yakpress widget`.

Ce fichier contient une class qui étant la class WP_Widget et les méthodes indiqué par les conventions wordpress.

Comme pout la plupart des autre Features, le **slug** du composant est en propriété de la class afin de pouvoir être facilement référencé depuis une autre feature.

```php
<?php

namespace {{plugin_namespace}}\Features\Widgets;

class {{widget_class}} extends \WP_Widget
{
  public static $slug = "{{widget}}";

  //ici on peut définir des arguments en plus que l'on pourrait passer à la vue qui s'affiche sur le front office
  public $args = array(
    'before_title' => '',
    'after_title' => '',
    'before_widget' => '',
    'after_widget' => '',
    'self' => self::class
  );

  /**
   * le construct est lancé lorsque l'on instentie la class on passe à la class parent le slug et le titre
   */
  function __construct()
  {

    parent::__construct(
      self::$slug,
      __("Titre du widget")
    );



  }
  /**
   * enregistrement du widget
   *
   * @return void
   */
  public static function register()
  {
    register_widget(self::class);
  }

  /**
   * methode pour arricher le widget sur le front
   *
   * @param [type] $arg argument de la class defini dans la propriété public
   * @param [type] $instance l'instance du widget sachant qu'il peut y avoir plusieurs widget utilisé
   * @return void
   */
  public function widget($args, $instance)
  {

    //view('viewpath', compact('args', 'instance'));

  }

  /**
   * methode pour afficher le fomulaire dans le backoffire
   *
   * @param [type] $instance l'instance du widget sachant qu'il peut y avoir plusieurs widget utilisé
   * @return void
   */
  public function form($instance)
  {
    //les widgets génere des name specifique pour les inputs, il faut donc utiliser la methode get_field_name pour cela

    //view('viewpath', compact('data'));

  }

  /**
   * Methode pour updater les informations du widget
   *
   * @param [type] $new_instance
   * @param [type] $old_instance
   * @return void
   */
  public function update($new_instance, $old_instance)
  {

  }


}
```

### Sections

Il est possible de créer facilement une section personnalisés avec le [CLI](/cli/#section) et de la charger automatiquement `wp yakpress section`.

La class contient 3 méthodes. `CustomSection::init()` pour associer une section avec une page, `CustomSection::register_settings()` pour enregistrer les settings de la section afin qu'ils puissent être sauvegarder en même temps que le reste de la page et `CustomSection::render()` qui charge la vue pour le rendu de la section.

Comme pout la plupart des autre Features, le **slug** du composant est en propriété de la class afin de pouvoir être facilement référencé depuis une autre feature.

```php
<?php

namespace Pluginname\Features\Sections;

class CustomSection
{
  public static $slug = 'custom';
  /**
   * Enregistrement de la section
   *
   * @return void
   */
  public static function init()
  {
    add_settings_section(
      self::$slug,
      __('Titre de la section'),
      [self::class, 'render'],
      'page_id'
    );
    self::register_settings();
  }

  /**
   * Cette fonction enregistre les settings qui apparaîtrons dans
   * la section afin qu'ils puissent être pris en compte lors de la sauvegarde de la page
   *
   * @return void
   */
  public static function register_settings()
  {
    register_setting(
      'page_id',
      self::$slug
    );
  }

  /**
   * fonction pour render le contenu de la section
   */
  public static function render()
  {
    //view('viewpath', compact('data'));
  }
}
```

### Pages

Il est possible de créer facilement une page personnalisés avec le [CLI](/cli/#page) et de la charger automatiquement `wp yakpress page`.

La class CustomPage se compose de 2 méthodes. `CustomPage::init()` pour initialiser la page et `CustomPage::render()` qui se charge de rendre le contenu de la page.

:::tip conseil
Il est préférable de créer un controller associé avec la page qui pourra alors faire office de resource pour cette page `index, show, create, edit, update, delete`. Si vous créer le formulaire associé via le [CLI](/cli/#page) vous aurez alors un bout de code qui permettra à la fonction render de renvoyer vers la bonne méthode du controller en fonction de la variable `$_GET['action']`.
:::

```php
<?php

namespace Pluginname\Features\Pages;

use Pluginname\Http\Controllers\CustomController;



class CustomPage
{
  /**
   * Initialisation de la page.
   *
   * @return void
   */
  public static function init()
  {
    add_menu_page(
      __('Titre de la page'),
      __('Texte dans menu'),
      'capability',
      'menu-slug',
      [self::class, 'render'],
      'dashicons-myicon',
      10 // position dans le menu
    );
  }

  /**
   * Fonction qui redirige vers la bonne méthode
   *
   * @return void
   */
  public static function render()
  {
    /**
     * on fait un refactoring afin que la méthode render renvoi vers la bonne méthode en fonction de l'action
     */
    // on défini une valeur par défaut pour $action qui est index et qui correspondra à la méthode à utiliser
    $action = isset($_GET["action"]) ? $_GET["action"] : "index";
    call_user_func([CustomController::class, $action]);
  }
}
```

## Http

Comme dans la plupart des framwork, ce dossier contient les class qui interviennent lors d'une requête http.

- [Controllers](#controllers)
- [Models](#models)
- [Middlewares](#middlewares)
- [Requests](#requests)

### Controllers

Les controllers sont la partie du framework ou la logique va être orchestrée. Il est possible de créer un controller via le [CLI](/cli/#controller) `wp yakpress controller`. Il est également possible de rajouter directement le model associé et de les lié grâce au flag `--model`.

De base le controller dispose de méthode ressource.

:::warning
il est possible que dans les prochaines version on permette de définir un controller comme ressource via un flag `--resource`.
:::

### Models

Les models sont la partie du framework qui communique avec la base de donnée. Il est possible de créer un model via le [CLI](/cli/#model) `wp yakpress model`. Il est également possible de rajouter directement le controller associé grâce au flag --controller.

De base tout les Models extends la class `Pluginname\Http\Model\Model::class` afin de ne pas répeter les fonctions de base commune à la plupart des models.

### Middlewares

Les middlewares sont la partie du framework qui permet d'executer une action avant le que controller ne soit lancé. Pour exemple, vérifier si une personne est connecter et rediriger vers une page si ça n'est pas le cas.

Il est possibile de créer des middlewares via le [CLI](/cli/#middleware) `wp yakpress middleware`

### Requests

Les Requests sont la partie du framework qui vérifie les données d'une transmise par une requête http. Il existe de base une class qui permet de faire certain type de validation et qui redirige avec une erreur si les données ne correspondent pas à l'attente.

## Les Resources

Le dossier resources contient le dossier assets, pour les fichiers qui doivent être accessible pour le front, ainsi que le dossier views dans le quelle on place les fichiers qui vont générer des vues.
