# Installation procedure

1. Download Cropper Bundle
2. Enable the bundle
3. Install the assets
4. Configure the BreithbarbotCropperBundle
5. Import BreithbarbotCropperBundle routing files
6. Clear caches

<br>

### Step 1: Download Cropper Bundle
Require the bundle with composer:
```bash
composer require breithbarbot/cropper
```

<br>

### Step 2: Enable the bundle
Enable the bundle in the kernel :
```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // [...]
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Breithbarbot\CropperBundle\BreithbarbotCropperBundle(),
        // [...]
    );
}
```

<br>


### Step 3: Install the assets
Used to install multimedia files in the web/ folder
```bash
php bin/console assets:install --symlink
```

<br>

### Step 4: Configure the BreithbarbotCropperBundle
Configure the bundle :
```yaml
# app/config/config.yml

# Stof Doctrine Extensions Configuration
stof_doctrine_extensions:
    default_locale: "%locale%"
    orm:
        default:
            loggable:      true
            uploadable:    true

    # Only used if you activated the Uploadable extension
    uploadable:
        # Default file path: This is one of the three ways you can configure the path for the Uploadable extension
        default_file_path:       "%kernel.root_dir%/../web/uploads/files"

        # Mime type guesser class: Optional. By default, we provide an adapter for the one present in the HttpFoundation component of Symfony
        mime_type_guesser_class: Stof\DoctrineExtensionsBundle\Uploadable\MimeTypeGuesserAdapter

        # Default file info class implementing FileInfoInterface: Optional. By default we provide a class which is prepared to receive an UploadedFile instance.
        default_file_info_class: Stof\DoctrineExtensionsBundle\Uploadable\UploadedFileInfo

# BreithbarbotCropperBundle Configuration
breithbarbot_cropper:
    config:
        default_folder: 'uploads'
        data_class: 'YourBundle\Entity\File'
    mappings:
        name_entity_custom:
            path: files/test/
        # ...
```

Option `data_class` refers to your Entity `File` with at least the following fields:

* full_path
* path
* name
* mime_type

[More info for exemple `File entity`](exemples/entities/file.md)

<br>

### Step 5: Import BreithbarbotCropperBundle routing files
Import the routing:
```yaml
# app/config/routing.yml

# BreithbarbotCropperBundle
breithbarbot_cropper:
    resource: "@BreithbarbotCropperBundle/Resources/config/routing.yml"
    prefix:   /cropper
```

<br>

### Step 6: Clear caches
Clear dev and prod caches
```bash
php bin/console cache:clear
php bin/console cache:clear --env=prod --no-debug
```

<br>

#### Back to index
[Back to documentation index](index.md)
