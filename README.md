# WordPress Options

A WordPress helper class for managing plugin options.

## Installation

```shell
composer require wp-forge/wp-options
```

## Usage

### Setting Options

```php
<?php

use WP_Forge\Options\Options;

$options = new Options('my_plugin_options');

// Pass the option name and option value as parameters.
$options->set('name', 'value');
```

### Getting Options

```php
<?php

use WP_Forge\Options\Options;

$options = new Options('my_plugin_options');

// Pass the option name and a default value as parameters.
// If a default value is not provided, `null` will be the default return value.
$options->get('name', 'default');
```

### Deleting Options

```php
<?php

use WP_Forge\Options\Options;

$options = new Options('my_plugin_options');

// Pass the option name to be deleted as a parameter.
$options->delete('name');
```

### Checking if an Option Exists

```php
<?php

use WP_Forge\Options\Options;

$options = new Options('my_plugin_options');

// Pass the option name as a parameter.
$options->has('name');
```

### Saving Options

By default, options will save automatically on the `shutdown` hook.

However, if you'd like to force a save, you can do it like this:

```php
<?php

use WP_Forge\Options\Options;

$options = new Options('my_plugin_options');

// Pass the option name and option value as parameters
$options->save();
```
