<?php

namespace Tadcka\ObjectRatingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tadcka\ObjectRatingBundle\DependencyInjection\Compiler\FormPass;

class TadckaObjectRatingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }
}
