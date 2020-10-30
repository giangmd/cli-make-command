# CodeIgniter4 CLI Make Command

[![Latest Stable Version](https://poser.pugx.org/ewci/cli-make-command/v)](//packagist.org/packages/ewci/cli-make-command) [![Total Downloads](https://poser.pugx.org/ewci/cli-make-command/downloads)](//packagist.org/packages/ewci/cli-make-command) [![License](https://poser.pugx.org/ewci/cli-make-command/license)](//packagist.org/packages/ewci/cli-make-command)

CLI-Make-Command is based on CodeIgniter4. It will help you generate template files (Command line, Controller, Filter, Entity, Model) more quickly when developing projects with CodeIgniter4.

This is an idea got from Laravel Framework as well.

## Install

### Prerequisites
1. CodeIgniter Framework 4.*
2. Composer

### Composer Install

```
composer require ewci/cli-make-command
```
### Use Library

Open Terminal in Mac/Linux or go to Run > “cmd” in Windows and navigate to CodeIgniter4 project’s root:

```
php spark list
```

Now, if you see the following message, the installation is successful.

```
make
  make:command       Create a new command class.
  make:controller    Create a new controller class.
  make:entity        Create a new entity class.
  make:filter        Create a new filter class.
  make:model         Create a new model class.
```

# Guide

## make:command

Create a new command file.

* Use
    ```
    php spark make:command [class_name] [options]
    ```

* Description:
    ```
    Create a new command file.
    ```

* Arguments:
    1. class_name : The command name.

* Options:
    ```
    --command   The command name to run in spark. Defaults to command:name.
    --group     The group/namespace of the command. Defaults to CodeIgniter for basic commands, and Generators for generator commands.
    --type      The type of command, whether a basic command or a generator command. Defaults to basic
    -n          Set controller namespace
    --force     Set this flag to overwrite existing files on destination.
    ```


## make:controller

Create a new controller file.

* Use
    ```
    php spark make:controller [class_name] [options]
    ```

* Description:
    ```
    Create a new controller file.
    ```

* Arguments:
    1. class_name : The controller name.

* Options:
    ```
    --restful   Extends from a RESTful resource.
    -n          Set controller namespace
    --force     Set this flag to overwrite existing files on destination.
    ```

## make:entity

Create a new entity file.

* Use
    ```
    php spark make:entity [class_name] [options]
    ```

* Description:
    ```
    Create a new entity file.
    ```

* Arguments:
    1. class_name : The entity name

* Options:
    ```
    -n          Set entity namespace
    --force     Set this flag to overwrite existing files on destination.
    ```
  
## make:model

Create a new model file.

* Use
    ```
    php spark make:model [class_name] [options]
    ```

* Description:
    ```
    Create a new model file.
    ```

* Arguments:
    1. class_name : The model name

* Options:
    ```
    --dbgroup   Database group to use. Defaults to default.
    --entity    Set this flag to use an entity class as the return type.'
    --table     Supply a different table name. Defaults to the pluralized class name.'
    -n          Set model namespace
    --force     Set this flag to overwrite existing files on destination.
    ```

## make:filter

Create a new filter file.

* Use
    ```
    php spark make:filter [class_name] [options]
    ```

* Description:
    ```
    Create a new filter file.
    ```

* Arguments:
    1. class_name : The filter name

* Options:
    ```
    -n          Set filter namespace
    --force     Set this flag to overwrite existing files on destination.
    ```

### Enjoy!