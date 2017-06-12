# Usage Instructions

1. Add Association Mapping
2. Add form field in form builder
3. Add modal
4. Add form field
5. Remove association if delete image OR is empty

<br>

### Step 1: Add Association Mapping
Add your Association Mapping with your File entity
```php
// [...]

/**
 * @ORM\OneToOne(targetEntity="YourBundle\Entity\File", cascade={"persist"}, orphanRemoval=true)
 * @ORM\JoinColumn(referencedColumnName="id")
 */
private $yourFieldName;

// [...]
```
Then, run the following commands :
* ```php bin/console doctrine:generate:entities YourBundle:YourEntity```
* ```php bin/console doctrine:schema:update --force```

<br>

### Step 2: Add form field in form builder
```php
<?php

// [...]
use Breithbarbot\CropperBundle\Form\Type\CropperType;

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // [...]
        ->add('your_field_name', CropperType::class, ['data' => $builder->getData()->getYourFieldName(), 'required' => false]) 
        // [...]
    ;
}
```

<br>

### Step 3: Add modal
Include modal with params
```twig
{% include 'BreithbarbotCropperBundle:Form:cropper_modal.html.twig' with {'mapping': 'name_custom_entity', 'width': '400', 'height': '225', 'ratio': '16/9'} %}
```
Parameter :
* mapping : name_custom_entity
* width   : Width of cropped image
* height  : Height of cropped image
* ratio   : Ratio of cropped image

<br>

### Step 4: Add form field
```twig
{{ form_row(form.your_field_name, { 'label':'Visual of the news' }) }}
```

<br>

### Step 5: Remove association if delete image OR is empty
Add script before the ```php $em->persist($entity); ``` :

```php
// YourBundle/Controller/CustomController.php

// If delete field is true
// OR
// is field is empty
$fai = $form_article['yourFieldName'];
if ((isset($fai['delete']) && !empty($fai['delete']->getData())) || empty($fai['path']->getData())) {
    $article->setYourFieldName(null);
}
```

<br>

#### Back to index
[Back to documentation index](index.md)
