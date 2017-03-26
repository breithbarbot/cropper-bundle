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
        // ...
        new Breithbarbot\CropperBundle\BreithbarbotCropperBundle(),
        // ...
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

# BreithbarbotCropperBundle Configuration
breithbarbot_cropper:
    config:
        default_folder: 'uploads'
        data_class: 'YourBundle\Entity\File'
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
