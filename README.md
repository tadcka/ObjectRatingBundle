ObjectRatingBundle
==================

## Installation

### Step 1: Download TadckaAddressBundle using composer

Add TadckaAddressBundle in your composer.json:

```js
{
    "require": {
        "tadcka/object-rating-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update tadcka/object-rating-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tadcka\ObjectRatingBundle\TadckaObjectRatingBundle(),
    );
}
```

### Step 3: Update doctrine schema

``` bash
$ php app/console doctrine:schema:update --dump-sql
```

### Step 4: Include javascript and css

```twig
    @TadckaObjectRatingBundle/Resources/public/css/jquery.rating.css

    @TadckaObjectRatingBundle/Resources/public/js/star-rating/jquery.rating.js
    @TadckaObjectRatingBundle/Resources/public/js/object-rating.js
```

### Step 5: Create object rating info

Build object raiting info and include to template:


``` php
    /**
     * @return \Tadcka\ObjectRatingBundle\Manager\ObjectRatingManager
     */
    private function getObjectRatingManager()
    {
        return $this->get('tadcka_object_rating.manager');
    }
    
    
    public function exampleAction()
    {
        $example = new \Tadcka\ExampleBundle\Entity\Example();
        
        return $this->render('TadckaExampleBundle:Example:example.html.twig', array(
            'object_rating_info' => $this->getObjectRatingManager()
                    ->getObjectRatingInfo(Example::OBJECT_TYPE, $example->getId()),
        ));
    }
```

or list:

``` php
    public function examplesAction()
    {
        $ids = array(1, 2);
        
        return $this->render('TadckaExampleBundle:Example:examples.html.twig', array(
            'objects_rating_info' => $this->getObjectRatingManager()
                    ->getObjectsRatingInfo(Example::OBJECT_TYPE, $ids);,
        ));
    }
```

### Step 6: Render object rating in twig template

```twig
    {% include 'TadckaObjectRatingBundle::show_object_rating.html.twig'
        with {
            url: url("exmaple"),
            objectRatingInfo: object_rating_info
        }
    %}
```

or list:

```twig
    {% if objects_rating_info[example.getId()] is defined %}
        {% include 'TadckaObjectRatingBundle::show_object_rating.html.twig'
            with {
                url: url("exmaple"),
                objectRatingInfo: objects_rating_info[example.getId()]
            }
        %}
    {% endif %}
```

### Step 7: Object rating form in twig template

```twig
    {% render  url('tadcka_object_rating', {objectType: 'example', objectId: example.getId() }) %}
```



