<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace PHPSA;

use PHPSA\Definition\ClassDefinition;
use PHPSA\Definition\FunctionDefinition;

class Compiler
{
    /**
     * @var ClassDefinition[]
     */
    protected $classes = array();

    /**
     * @var FunctionDefinition[]
     */
    protected $functions = array();

    /**
     * @param ClassDefinition $class
     */
    public function addClass(ClassDefinition $class)
    {
        $this->classes[$class->getName()] = $class;
    }

    /**
     * @param FunctionDefinition $function
     */
    public function addFunction(FunctionDefinition $function)
    {
        $this->functions[] = $function;
    }

    /**
     * @param Context $context
     */
    public function compile(Context $context)
    {
        $context->scopePointer = null;

        /**
         * @todo Implement class map...
         */
        for ($i = 0; $i < 100; $i++) {
            foreach ($this->classes as $class) {
                $extends = $class->getExtendsClass();
                if ($extends) {
                    $parentClassDefinition = $this->classes[$class->getName()];
                    if ($parentClassDefinition) {
                        $class->setExtendsClassDefinition($parentClassDefinition);
                    }
                }
            }
        }

        foreach ($this->functions as $function) {
            $function->compile($context);
        }

        foreach ($this->classes as $class) {
            $class->compile($context);
        }
    }

    /**
     * Try to find function with $namespace from pre-compiled function(s)
     *
     * @param $name
     * @param string|null $namespace
     * @return bool|FunctionDefinition
     */
    public function getFunctionNS($name, $namespace = null)
    {
        foreach ($this->functions as $function) {
            if ($function->getName() == $name && $function->getNamespace() == $namespace) {
                return $function;
            }
        }

        return false;
    }

    /**
     * Try to find function from pre-compiled function(s)
     *
     * @param $name
     * @return bool|FunctionDefinition
     */
    public function getFunction($name)
    {
        foreach ($this->functions as $function) {
            if ($function->getName() == $name) {
                return $function;
            }
        }

        return false;
    }
}
