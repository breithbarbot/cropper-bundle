# Installation procedure

1. Download Cropper Bundle
2. Enable the bundle
3. Configure the BreithbarbotCropperBundle
4. Install the assets
5. Clear cache

<br>

### Step 1: Download Cropper Bundle
Require the bundle with composer:

```bash
composer require breithbarbot/cropper
```

<br>

### Step 2: Enable the bundle
Enable the bundle in the bundles.php:

```php
// config/bundles.php

return [
    // [...]
    Breithbarbot\CropperBundle\BreithbarbotCropperBundle::class => ['all' => true],
    // [...]
];
```

<br>

### Step 3: Configure the BreithbarbotCropperBundle
Configure the bundle:

```yaml
# config/packages/breithbarbot_cropper.yaml

breithbarbot_cropper:
    mappings:
        user_avatar:
            routes:
                add_path:    'app_user_avatar_add'
                delete_path: 'app_user_avatar_delete' # optional
            width:  400
            height: 400
            ratio:  1
        note_image:
            routes:
                add_path:    'app_note_image_add'
            width:  400
            height: 225
            ratio:  '16/9'
```

<br>

### Step 4: Install the assets
Used to install multimedia files in the web/ folder:

```bash
php bin/console assets:install --symlink
```

<br>

### Step 5: Clear cache
Clear cache:

```bash
php bin/console cache:clear
```

<br>

#### Next ?
[Go to usage Instructions](usage.md)

[Back to documentation index](index.md)
