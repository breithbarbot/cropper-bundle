# Usage Instructions

1. Add form field in a form builder
2. Add modal
3. Add form field
4. Lite example of a controller

<br>

### Step 1: Add form field in a form builder
Example in a form builder:

```php
<?php

// [...]
use Breithbarbot\CropperBundle\Form\Type\CropperType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // [...]
        // Mapped = "true" if avatar exist
        $edit = (null !== $builder->getData()->getAvatar());
        $builder->add('avatar', CropperType::class, [
            'required' => false,
            'mapped' => $edit,
            'mapping' => 'user_avatar', // From: config/packages/breithbarbot_cropper.yaml
            'additional_data' => [
                'entity_id' => $builder->getData()->getId(), // Get current ID
                // [...]
            ],
            'label' => false
            ]);
        // [...]
    }
}
```

<br>

> For multiple cropping on the same page : [Multiple Usage Instructions](usage_multiple.md)

<br>

### Step 2: Add modal
Include modal with params:

```twig
{% include 'BreithbarbotCropperBundle:Form:cropper_modal.html.twig' with {'mapping': 'user_avatar'} %}
```

<br>

> For multiple cropping on the same page : [Multiple Usage Instructions](usage_multiple.md)

<br>

### Step 3: Add form field

```twig
{{ form_row(form.avatar) }}
```

<br>

### Step 4: Lite example of a controller

- [CropperController.php](examples/Controller/CropperController.php)
- [UserController.php](examples/Controller/UserController.php)

<br>

#### Back to index
[Back to documentation index](index.md)
