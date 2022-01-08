# Tabler-Bundle Demo

This repository contains an example Symfony application for the [Tabler-Bundle](https://github.com/kevinpapst/TablerBundle).

It serves as a living documentation for first time users and easier testing of theme features.

Please read the [theme documentation](https://github.com/kevinpapst/TablerBundle/blob/main/docs/) for more information on how to use this theme.


# Installation

Simple as that:

```bash
composer create-project kevinpapst/tabler-bundle-demo
```

Use the [Symfony binary](https://symfony.com/download) to quickly start up a development server:

```bash
cd tabler-bundle-demo
symfony serve
```

## Testing different languages

**Be aware that ONLY the theme translations will change (like login screen and toolbar dropdowns), the demo itself is not translated!** 

- Simple solution: This demo supports locales via URLs, use the dropdown in the pages head navigation.
- Permanent solution: Edit the file `config/services.yaml` and change from `locale: 'en'` to something like `locale: 'ar'`.

## Real world examples

If you want to see the theme in action (in a real world application), 
checkout my [time-tracking application Kimai](https://github.com/kevinpapst/kimai2) 
(currently in preparation for the next major release in only in branch `v2`).
