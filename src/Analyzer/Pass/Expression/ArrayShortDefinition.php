<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace PHPSA\Analyzer\Pass\Expression;

use PhpParser\Node\Expr;
use PHPSA\Analyzer\Pass\AnalyzerPassInterface;
use PHPSA\Compiler\Event\ExpressionAfterCompile;
use PHPSA\Context;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ArrayShortDefinition implements AnalyzerPassInterface
{
    /**
     * @param Expr\Array_ $expr
     * @param Context $context
     * @return bool
     */
    public function pass(Expr\Array_ $expr, Context $context)
    {
        if ($expr->getAttribute('kind') == Expr\Array_::KIND_LONG) {
            $context->notice(
                'array.short-syntax',
                'Please use [] (short syntax) for array definition.',
                $expr
            );

            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRegister()
    {
        return [
            [Expr\Array_::class, ExpressionAfterCompile::EVENT_NAME]
        ];
    }
}
