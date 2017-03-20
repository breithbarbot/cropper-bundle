# Cropper
> Simple cropping tool for symfony 3

Bundle based on the javascript plugin [Cropper](https://github.com/fengyuanchen/cropper) adapted for use under symfony 3

[![Latest Stable Version](https://poser.pugx.org/breithbarbot/cropper/v/stable?format=flat-square)](https://packagist.org/packages/breithbarbot/cropper)
[![Total Downloads](https://poser.pugx.org/breithbarbot/cropper/downloads?format=flat-square)](https://packagist.org/packages/breithbarbot/cropper)
[![Latest Unstable Version](https://poser.pugx.org/breithbarbot/cropper/v/unstable?format=flat-square)](https://packagist.org/packages/breithbarbot/cropper)
[![License](https://poser.pugx.org/breithbarbot/cropper/license?format=flat-square)](https://packagist.org/packages/breithbarbot/cropper)

<br>

## Installation
1. Download Cropper Bundle
2. Enable the bundle
3. Configure the BreithbarbotCropperBundle
4. Import BreithbarbotCropperBundle routing files

<br>

#### Step 1: Download Cropper Bundle
Require the bundle with composer:
```bash
composer require breithbarbot/cropper
```

<br>

#### Step 2: Enable the bundle
Enable the bundle in the kernel (app/AppKernel.php):
```php
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

#### Step 3: Configure the BreithbarbotCropperBundle
Configure the bundle in the config.yml:
```yaml
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

<br>

#### Step 4: Import BreithbarbotCropperBundle routing files
Import the routing:
```yaml
# BreithbarbotCropperBundle
breithbarbot_cropper:
    resource: "@BreithbarbotCropperBundle/Resources/config/routing.yml"
    prefix:   /cropper
```

<br>

## Usage Instructions
1. Add form field in form builder
2. Add form field
3. Add modal
4. Add script
5. Add Association Mapping

<br>

#### Step 1: Add form field in form builder
```php
<?php

// ...

use Breithbarbot\CropperBundle\Form\Type\CropperType;

// ...

$builder
    // ...
    ->add('your_field_name', CropperType::class)
    // ...
;
```

<br>

#### Step 2: Add form field
```twig
{{ form_row(form.your_field_name, { 'label':'Visual of the news' }) }}
```

<br>

#### Step 3: Add modal
Include modal with params
```twig
{% include 'BreithbarbotCropperBundle:Form:cropper_modal.html.twig' with {'path_image': 'files/actus/', 'width': '400', 'height': '225'} %}
```
Parameter :
* path_image : Image Directory
* width : Width of cropped image
* height : Height of cropped image

<br>

#### Step 4: Add script
Add the call function for init plugin JS
```js
// Crooper JS
new Crop($('#crop'), 16/9);
```
Two params :
1. The form ID
2. Aspect ratio of cropped image

<br>

#### Step 5: Add Association Mapping
Add your Association Mapping with your File entity
```php
// ...

/**
 * @ORM\OneToOne(targetEntity="YourBundle\Entity\File", cascade={"persist"}, orphanRemoval=true)
 * @ORM\JoinColumn(referencedColumnName="id")
 */
private $visuel;

// ...
```
Then, run the following commands :
* ```php bin/console doctrine:generate:entities --entity=YourBundle:File```
* ```php bin/console doctrine:schema:update --force```

<br>


## Version

1.0.1 - Project in development...

1.0.0 - Start of the project ! 🎉🎊

<br>
 
## Coming soon...
* Auto preview
* More options
* Auto-detect image format (jpg, gif or png)
* Implementation of a translation system
* Ability to delete images
* ...

<br>
 
## License

MIT License

Copyright (c) 2017 Breith Barbot | [Breithbarbot.name](https://breithbarbot.name)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
