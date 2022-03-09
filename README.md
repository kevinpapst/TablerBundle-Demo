
# Tabler-Bundle Demo

This repository contains an example Symfony application for the [Tabler-Bundle](https://github.com/kevinpapst/TablerBundle).

It serves as a living documentation for first time users and easier testing of theme features.

Please read the [theme documentation](https://github.com/kevinpapst/TablerBundle/blob/main/docs/) for more information on how to use this theme.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
    + [Symfony binary](#symfony-binary)
    + [Docker-compose](#docker-compose)
- [Testing different languages](#testing-different-languages)
- [Real world examples](#real-world-examples)

# Installation

Simple as that:

```bash
composer create-project kevinpapst/tabler-bundle-demo
```

# Usage
### Symfony binary
Use the [Symfony binary](https://symfony.com/download) to quickly start up a development server:

```bash
cd tabler-bundle-demo
symfony serve
```

### Docker-compose
```bash
cd tabler-bundle-demo
docker-compose up -d
docker-compose exec apache bash
composer install
```

Go to your docker url (`localhost` for default config) at the port `80`.
e.g : `localhost:80`

> NO SUPPORT FOR DOCKER GIVEN


# Testing different languages

**Be aware that ONLY the theme translations will change (like login screen and toolbar dropdowns), the demo itself is not translated!** 

- Simple solution: This demo supports locales via URLs, use the dropdown in the pages head navigation.
- Permanent solution: Edit the file `config/services.yaml` and change from `locale: 'en'` to something like `locale: 'ar'`.

# Real world examples

If you want to see the theme in action (in a real world application), 
checkout my [time-tracking application Kimai](https://github.com/kevinpapst/kimai2) 
(currently in preparation for the next major release in only in branch `v2`).
