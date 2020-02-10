Documentation
=============

Here you will find information on installation procedure and usage instructions.

- **Installation procedure** in 1 step / 2 steps
- **Usage Instructions** in 5 steps

<br>

## Requirements
- [PHP 7.4](https://www.php.net/) (Minimum version required)
- [jQuery](https://jquery.com/) (Optional)
- [Bootstrap](https://getbootstrap.com/)

<br>

## Installation
- [Installation procedure](installation.md)

<br>

## Usages
- [Usage Instructions](usage.md)
    - [Multiple usage instructions](usage_multiple.md)
- [Usage in Twig Instructions](usage_twig.md)

<br>

## Code example
- [Example directory](examples)

```
├───config
│   └───packages
│           breithbarbot_cropper.yaml
│
├───src
│   ├───Controller
│   │       CropperController.php
│   │       ExampleController.php
│   │
│   ├───Entity
│   │       File.php
│   │       User.php
│   │
│   ├───Form
│   │       UserType.php
│   │
│   ├───Migrations
│   │       Version20200209213559.php
│   │
│   └───Repository
│           FileRepository.php
│           UserRepository.php
│
└───templates
    │   base.html.twig
    │
    └───example
            index.html.twig
```

If you want use example files, follow instructions:
1. Execute: `composer require sensio/framework-extra-bundle`
1. Execute: `composer require symfony/security-core`
1. Execute: `composer require symfony/orm-pack` and config `.env`
1. Copy all files in your project
1. Execute: `php bin/console doctrine:database:create`
1. Execute: `php bin/console doctrine:migrations:migrate`
1. Run your server and go to: `/example`
