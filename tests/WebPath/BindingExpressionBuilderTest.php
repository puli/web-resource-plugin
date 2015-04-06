<?php

/*
 * This file is part of the puli/asset-plugin package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\AssetPlugin\Tests\WebPath;

use PHPUnit_Framework_TestCase;
use Puli\AssetPlugin\Api\AssetPlugin;
use Puli\AssetPlugin\Api\WebPath\WebPathMapping;
use Puli\AssetPlugin\WebPath\BindingExpressionBuilder;
use Puli\Manager\Api\Discovery\BindingDescriptor;
use Puli\Manager\Api\Discovery\BindingState;
use Webmozart\Expression\Expr;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class BindingExpressionBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BindingExpressionBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->builder = new BindingExpressionBuilder();
    }

    public function testBuildDefaultExpression()
    {
        $expr = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}');

        $this->assertEquals($expr, $this->builder->buildExpression());
    }

    public function testBuildExpressionWithCustomCriteria()
    {
        $expr1 = Expr::startsWith(WebPathMapping::UUID, 'abcd')
            ->orSame(WebPathMapping::TARGET_NAME, 'local')
            ->orX(
                Expr::same(WebPathMapping::GLOB, '/path')
                    ->andSame(WebPathMapping::WEB_PATH, 'css')
            );

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andX(
                Expr::startsWith(BindingDescriptor::UUID, 'abcd')
                    ->orKeySame(BindingDescriptor::PARAMETER_VALUES, AssetPlugin::TARGET_PARAMETER, 'local')
                    ->orX(
                        Expr::same(BindingDescriptor::QUERY, '/path{,/**}')
                            ->andKeySame(BindingDescriptor::PARAMETER_VALUES, AssetPlugin::PATH_PARAMETER, 'css')
                    )
            );

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }

    public function testAppendDefaultQuerySuffixForSame()
    {
        $expr1 = Expr::same(WebPathMapping::GLOB, '/path');

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andSame(BindingDescriptor::QUERY, '/path{,/**}');

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }

    public function testAppendDefaultQuerySuffixForEquals()
    {
        $expr1 = Expr::equals(WebPathMapping::GLOB, '/path');

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andEquals(BindingDescriptor::QUERY, '/path{,/**}');

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }

    public function testAppendDefaultQuerySuffixForNotSame()
    {
        $expr1 = Expr::notSame(WebPathMapping::GLOB, '/path');

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andNotSame(BindingDescriptor::QUERY, '/path{,/**}');

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }

    public function testAppendDefaultQuerySuffixForNotEquals()
    {
        $expr1 = Expr::notEquals(WebPathMapping::GLOB, '/path');

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andNotEquals(BindingDescriptor::QUERY, '/path{,/**}');

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }

    public function testAppendDefaultQuerySuffixForEndsWith()
    {
        $expr1 = Expr::endsWith(WebPathMapping::GLOB, '.css');

        $expr2 = Expr::same(BindingDescriptor::STATE, BindingState::ENABLED)
            ->andSame(BindingDescriptor::TYPE_NAME, AssetPlugin::BINDING_TYPE)
            ->andEndsWith(BindingDescriptor::QUERY, '{,/**}')
            ->andEndsWith(BindingDescriptor::QUERY, '.css{,/**}');

        $this->assertEquals($expr2, $this->builder->buildExpression($expr1));
    }
}
