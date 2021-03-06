---
title: The persistence actions | Sirius ORM
---

# Architecture - The persistence actions

When persisting entity changes (insert/update/delete) Sirius ORM uses `Actions`. 

These are individual classes that responsible for:

1. executing the actual necessary queries
2. updating the entities after successful queries (eg: set the `id` from the `lastInsertId`)

There are actions for delete, insert, update and link entities together (for many-to-many relations).

One action can also execute other actions since entities are related and, usually, when you want to persist
an entity change you want to also persist the changes to the related entities.

If you were to save a new (as in "not already in DB") product entity that has a new category and a set of new tags the operations required would be

1. save category entity in the database
2. set the `category_id` attribute on the product entity
3. save the product entity in the database
4. set the `product_id` attribute on each image
5. save each tag entity in the database
6. create the links between the product and tags in the pivot table

The problems **Sirius\Orm** solves with Actions are:

1. All these operations are wrapped in a transaction.
2. These operations have to be performed in the proper order, dictated by the
relations between the objects.
3. Behaviours can add their own actions inside the actions tree.

To solve these problems the **Sirius\Orm** Actions are organized in a tree-like
structure that follow these rules:

1. Each action executes **only one** operation 
(eg: insert the a row in the products table)
2. Each action may execute other actions before its own operations
(eg: call the "insert new category" action before inserting the product)
3. Each action may execute other actions after its own operations
(eg: call the "insert new image" action after inserting the product)

The relation between entities determine what type of actions have to be appended or prepended inside each action and the mapper is does the "heavy lifting" of constructing the action tree.

DELETE actions cascade for relations that have this option set to true.
