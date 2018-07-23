# Usage Instructions

1. Add form field in a form builder
2. Add modal
3. Add form field
4. Logic from controller

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
        $builder->add('avatar', CropperType::class, ['required' => false, 'mapping' => 'user_avatar', 'custom_data' => ['user_id' => 54652], 'label' => false]);
        // [...]
    }
}
```

<br>

### Step 2: Add modal
Include modal with params:

```twig
{% include 'BreithbarbotCropperBundle:Form:cropper_modal.html.twig' with {'mapping': 'user_avatar', 'id': crop3} %}
```
Parameters :
* mapping : user_avatar
* [optional] id : 'crop3'
    * If you have multiple cropping on the same page, it would be good to differentiate them

<br>

### Step 3: Add form field

```twig
{{ form_row(form.avatar, { 'label':'Avatar' }) }}
```

<br>

### Step 4: Logic from controller
Exemple script from controller:

=> [UserController.php](exemples/Controller/UserController.php)

<br>

#### Back to index
[Back to documentation index](index.md)
