# Usage in Twig Instructions

<br>

### Use `breithbarbot_cropper_asset` function
```twig
{{ breithbarbot_cropper_asset(your_entity.your_field_name) }}
# Or
<img class="img-responsive" src="{{ breithbarbot_cropper_asset(your_entity.your_field_name) }}" alt="{{ your_entity.your_field_name }}">
```

<br>

### Or use `asset` function
```twig
{{ asset(your_entity.your_field_name.path) }}
# Or
<img class="img-responsive" src="{{ asset(your_entity.your_field_name.path) }}" alt="{{ your_entity.your_field_name }}">
```

<br>

#### Back to index
[Back to documentation index](index.md)
