# Installation procedure

1. Download Cropper Bundle
2. Enable the bundle
3. Configure the bundle

<br>

### Step 1: Download Cropper Bundle
Require the bundle with composer:

```bash
composer req breithbarbot/cropper
```

<br>

### Step 2: Enable the bundle

#### For user using Symfony Flex

```php
// config/bundles.php

return [
    // [...]
    Breithbarbot\CropperBundle\BreithbarbotCropperBundle::class => ['all' => true],
    // [...]
];
```

#### For user not using Symfony Flex

```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return array(
            // ...
            new Breithbarbot\CropperBundle\BreithbarbotCropperBundle(),
        );
    }
}
```

<br>

### Step 3: Configure the bundle
Example configure the bundle:

```yaml
# config/packages/breithbarbot_cropper.yaml
breithbarbot_cropper:
    mappings:
        # An example of a custom mapping name
        user_avatar:
            routes:
                # A custom route which will take care of saving the image
                path_add: 'app_cropper_avatar_add'

                # Your custom route that will delete the image + Show the delete button in the modal. (Optional parameter)
                path_delete: 'app_cropper_avatar_delete'

            # Definition of cropped image properties (width, height and ratio)
            width:  400
            height: 400
            ratio:  1

        # Another example...
        note_image:
            routes:
                path_add: 'app_cropper_note_add'
            width:  400
            height: 225
            ratio:  '16/9'
```

A example of use for the following 2 routes (`app_cropper_avatar_add` and `app_cropper_avatar_delete`): [CropperController.php](examples/Controller/CropperController.php)

<br>

#### Next ?
[Go to usage Instructions](usage.md)

[Back to documentation index](index.md)
