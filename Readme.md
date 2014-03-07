# JSVars

A PyroCMS Plugin to get your PHP variables to JavaScript cleanly.

## Installation

Drop the `jsvars.php` file into one of your `plugins` folders (e.g. `addons/.../plugins`).

## Usage

Anywhere on your page, preferably inside of the `<head>` tag, place `{{ jsvars:dump }}`.

You can then fill the tag up with attributes, for example:

`{{ jsvars:dump my_cool_variable="My cool value!" }}`

This will generate:

```html
<script>
    var myCoolVariable = "My cool value!";
</script>
```

### Namespaceing

As we all know, global namespace pollution is punishable by death, so you can namespace your vars with the `namespace="whatever"` attribute:

`{{ jsvars:dump namespace="whatever" my_cool_variable="My cool value!" }}`

This will generate:

```html
<script>
    var whatever = {
        myCoolVariable: "My cool value!"
    }
</script>
```

## Default Values

By default, the plugin adds `themePath` and `themeUrl` to the generated variables, with the respective values, of course. I plan to add options to turn these off.

## Events

This plugin triggers the `jvars_dump` event while compiling the key/value pairs, it expects a simple array consisting of key/value pairs.

I have not yet added validation/sanatization, because I'm lazy, but here's how you can pass you own values into the whole thing in a sample Events class:

```php
class Events_Sample
{

    public function __construct()
    {
        Events::register('jvars_dump', array($this, 'onJvarsDump'));
    }

    public function onJvarsDump($data) 
    {
        return array(
            'this was added' => 'by some module'
        );
    }

}
```

1. Register your function call on the `jvars_dump` event
2. Return a simple two-dimensional array of primitive data types (no arrays/objects or something fancy)
3. That's it! If you now put

```html
{{ jsvars:dump namespace="whatever" some_attribute_key="and its value" }}
```

somewhere in your theme, you'll get

```
Object {someAttributeKey: "and its value", thisWasAdded: "by some module", themePath: "...", themeUrl: "..."}
```

in your console by typing `whatever`.