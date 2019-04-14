# Le micro framework

### Sommaire

- [La structure](#la-structure)
- [Le cycle de vie de l'application](#le-cycle-de-vie-de-l-application)
- [Le cycle de vie de l'application](#le-cycle-de-vie-de-l-application)

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

## Le dossier de l'application
