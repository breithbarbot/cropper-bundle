Usage instructions
==================

1. Configure the bundle
2. Configure the translation
3. Add form field in a form builder
4. Add modal
5. Add form field

<br>

### Step 1: Configure the bundle
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

> A example of use for the following 2 routes (`app_cropper_avatar_add` and `app_cropper_avatar_delete`): [CropperController.php](examples/src/Controller/CropperController.php)

### Step 2: Configure the translation

```yaml
# config\packages\translation.yaml
framework:
    default_locale: fr
    # ...
```

> Languages available: `de`, `en`, `es`, `fr`, `it`, `ru`.

<br>

### Step 3: Add form field in a form builder
Example in a form builder:

```php
<?php
// src\Form\UserType.php

// [...]
use Breithbarbot\CropperBundle\Form\Type\BreithbarbotCropperType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Mapped = "true" if avatar exist
        $edit = (null !== $builder->getData()->getAvatar());
        $builder
            // [...]
            ->add('avatar', BreithbarbotCropperType::class, [
                'required' => false,
                'mapped' => $edit,
                'mapping' => 'user_avatar', // From: config/packages/breithbarbot_cropper.yaml
                'additional_data' => [
                    'entity_id' => $builder->getData()->getId(), // Get current ID
                    // [...]
                ],
                'label' => false
            ])
            // [...]
        ;
    }

    // [...]
}
```

> For multiple cropping on the same page : [Multiple Usage Instructions](usage_multiple.md)

<br>

### Step 4: Add modal
Include modal with params:

```twig
{% include '@BreithbarbotCropper/Form/cropper_modal.html.twig' with {'mapping': 'user_avatar'} %}
```

> For multiple cropping on the same page : [Multiple Usage Instructions](usage_multiple.md)

<br>

### Step 5: Add form field

```twig
{{ form_row(form.avatar) }}
```

<br>

## Next ?
- [Usage in Twig instructions](usage_twig.md)
- [Homepage documentation](index.md)
