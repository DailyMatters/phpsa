<?php

namespace PHPSA\Analyzer\Pass\Expression;

use PhpParser\Node\Expr;
use PHPSA\Analyzer\Pass\AnalyzerPassInterface;
use PHPSA\Compiler\Event\ExpressionAfterCompile;
use PHPSA\Context;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ErrorSuppression implements AnalyzerPassInterface
{
    /**
     * @param Expr\ErrorSuppress $expr
     * @param Context $context
     * @return bool
     */
    public function pass(Expr\ErrorSuppress $expr, Context $context)
    {
        $context->notice(
            'error.suppression',
            'Please don\'t suppress errors with the @ operator.',
            $expr
        );

        return true;
    }

    /**
     * @return array
     */
    public function getRegister()
    {
        return [
            [Expr\ErrorSuppress::class, ExpressionAfterCompile::EVENT_NAME]
        ];
    }
}
