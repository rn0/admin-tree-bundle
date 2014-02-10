# FSiAdminTreeBundle

This bundle provides way to move up and down node in **NestedSet Tree**.

`FSiAdminTreeBundle` works with conjunction with [Tree - Nestedset behavior extension for Doctrine 2](https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/tree.md).
The best method to use `DoctrineExtensions - Tree` in Symfony2 application is [StofDoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle)

## Installation

Add to `composer.json`:

```yaml
"require": {
    "stof/doctrine-extensions-bundle": "~1.1@dev",
}
```

and run `composer update`.

Add to `app/AppKernel.php`:

```php
public function registerBundles()
{
    return array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new FSi\Bundle\AdminTreeBundle\FSiAdminTreeBundle(),
        // ...
    );
}

```
Add to `app/config/config.yml`

```yml
stof_doctrine_extensions:
    default_locale: pl_PL
    orm:
        default:
            tree: true
```

Add routes to `app/config/routing.yml`:

```yaml
_fsi_tree_bundle:
    resource: "@FSiAdminTreeBundle/Resources/config/routing.xml"
    prefix: /
```

## Usage

Sample datagrid definition:

```yaml
columns:
  title:
    type: text
    options:
      label: "backend.categories.datagrid.title.label"
  actions:
    type: action
    options:
      display_order: 2
      label: "backend.categories.datagrid.actions.label"
      field_mapping: [ id ]
      actions:
        move_up:
          route_name: "fsi_tree_node_move_up"
          additional_parameters: { element: "category" }
          parameters_field_mapping: { id: id }
          content: <span class="glyphicon glyphicon-arrow-up icon-white"></span>
          url_attr: { class: "btn btn-warning btn-sm" }
        move_down:
          route_name: "fsi_tree_node_move_down"
          additional_parameters: { element: "category" }
          parameters_field_mapping: { id: id }
          content: <span class="glyphicon glyphicon-arrow-down icon-white"></span>
          url_attr: { class: "btn btn-warning btn-sm" }
```
