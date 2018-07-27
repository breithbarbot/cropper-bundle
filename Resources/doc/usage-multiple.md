# Multiple Usage Instructions

1. Add form field in a form builder
2. Add modal

<br>

**To summarize**: In order to add several crop on a single page, it is necessary to declare / define a unique identifier.

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
        $builder->add('avatar', CropperType::class, ['required' => false, 'mapping' => 'user_avatar', 'additional_data' => ['user_id' => 12345, 'foo' => 'bar'], 'identifier' => 'crop3', 'label' => false]);
        // [...]
    }
}
```

Parameters :
* mapping : `'user_avatar'`
* additional_data (optional) : `['user_id' => 12345, 'foo' => 'bar']`
* identifier : `'crop3'`
* label (optional) : `false`

<br>

### Step 2: Add modal
Include modal with params:

```twig
{% include 'BreithbarbotCropperBundle:Form:cropper_modal.html.twig' with {'mapping': 'user_avatar', 'id': 'crop3'} %}
```

Parameters :
* mapping : `'user_avatar'`
* id : `'crop3'`

<br>

#### Back to index
[Back to documentation index](index.md)
