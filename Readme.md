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