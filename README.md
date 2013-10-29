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

### Step 4: Create form

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
    
    or list:
    
    public function examplesAction()
    {
        $ids = array(1, 2);
    
        $objectsRatingInfo = $this->getObjectRatingManager()->getObjectsRatingInfo(Example::OBJECT_TYPE, $ids);
        
        return $this->render('TadckaExampleBundle:Example:examples.html.twig', array(
            'objects_rating_info' => $objectsRatingInfo,
        ));
    }
```

