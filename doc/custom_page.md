# Creating a custom page

This documentation explains how to add "Club" page to a clubhouse website.

## Creating the controller

Create a controller `controller/club.php` with the following content:

```php
<?php

include_once 'controller.php';

class ClubController extends Controller
{
    public function index()
    {
        return $this->render('club/index.php', array(
            
        ));
    }
}
```

Note that the controller classname should match the filename. The filename should be in snake_case while the controller classname is in UpperCamelCase.

## Creating a route

Add a route to the `config/routes.php` file:

```php
<?php

return array(
    ...
    
    ////////////////////////////////////
    // Custom routes should go here > //
    ////////////////////////////////////
    'club' => 'club/index',
    ////////////////////////////////////
    // < Custom routes should go here //
    ////////////////////////////////////
    
    
    ...
);
```
The key is the URL path, the value refers to the controller and method.

## Creating the template

Your controller renders the `club/index.php` (though it could be any file inside the `templates` directory), so let's create `templates/club/index.php`:

```php
<div class="card">
    <div class="card-header">Our club</div>
</div>

<p>This is a page about our club!</p>
```

You're all set! Just navigate to https://yourclubhousesite.com/club and there is your page!

## Adding interesting stuff to your page

Of course, you may want to add some dynamic values to your page. Let's say you want to display your member count. There are two steps here:

1. Pass the value to the template in your controller
2. Display the value in the template.

### The controller side

In your controller, you may access the database and its `users` table this way:

```php
    public function index()
    {
        $members = $this->querySingleScalar('SELECT COUNT(*) FROM users');
        
        return $this->render('club/index.php', array(
            'members' => $members,
        ));
    }
```

### The template side

```php
<div class="card">
    <div class="card-header">Our club</div>
</div>

<p>This is a page about our club! As of today, we have <?= $members ?> members!</p>
```

## More

To make your pages more dynamic, you could:

* Define new configuration to change the content of the page directly from the admin section
* Define new permissions to change the content of the page dependending on user permissions
* Create new tables entirely, to create completely custom functions.
