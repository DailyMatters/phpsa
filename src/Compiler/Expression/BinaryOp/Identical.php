<?php

namespace PHPSA\Compiler\Expression\BinaryOp;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PHPSA\Compiler\Expression;
use PHPSA\Compiler\Expression\AbstractExpressionCompiler;

class Identical extends AbstractExpressionCompiler
{
    protected $name = 'PhpParser\Node\Expr\BinaryOp\Identical';

    /**
     * It's used in conditions
     * {left-expr} === {right-expr}
     *
     * @param \PhpParser\Node\Expr\BinaryOp\Identical $expr
     * @param Context $context
     * @return CompiledExpression
     */
    protected function compile($expr, Context $context)
    {
        $left = $context->getExpressionCompiler()->compile($expr->left);
        $right = $context->getExpressionCompiler()->compile($expr->right);

        switch ($left->getType()) {
            case CompiledExpression::INTEGER:
            case CompiledExpression::DOUBLE:
            case CompiledExpression::BOOLEAN:
            case CompiledExpression::ARR:
            case CompiledExpression::OBJECT:
            case CompiledExpression::STRING:
            case CompiledExpression::NUMBER:
            case CompiledExpression::RESOURCE:
            case CompiledExpression::CALLABLE_TYPE:
            case CompiledExpression::NULL:
                switch ($right->getType()) {
                    case CompiledExpression::INTEGER:
                    case CompiledExpression::DOUBLE:
                    case CompiledExpression::BOOLEAN:
                    case CompiledExpression::ARR:
                    case CompiledExpression::OBJECT:
                    case CompiledExpression::STRING:
                    case CompiledExpression::NUMBER:
                    case CompiledExpression::RESOURCE:
                    case CompiledExpression::CALLABLE_TYPE:
                    case CompiledExpression::NULL:
                        return CompiledExpression::fromZvalValue(
                            $left->getValue() === $right->getValue()
                        );
                }
        }

        return new CompiledExpression();
    }
}
