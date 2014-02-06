# FSiAdminTreeBundle

This bundle provides way to move up and down node in tree.

`FSiAdminTreeBundle` works with conjunction with [Tree - Nestedset behavior extension for Doctrine 2](https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/tree.md).

## Usage

Add to `AppKernel.php`:

```php
new FSi\Bundle\AdminTreeBundle\FSiAdminTreeBundle(),
```

Add routes to /app/config/routing.yml:

```yaml
_fsi_tree_bundle:
    resource: "@FSiAdminTreeBundle/Resources/config/routing.xml"
    prefix: /
```

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
