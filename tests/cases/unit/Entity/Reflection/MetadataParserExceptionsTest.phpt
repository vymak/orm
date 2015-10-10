<?php

/**
 * @testCase
 */

namespace NextrasTests\Orm\Entity\Reflection;

use Mockery;
use Nextras\Orm\Entity\Reflection\MetadataParser;
use Nextras\Orm\InvalidArgumentException;
use Nextras\Orm\InvalidModifierDefinitionException;
use NextrasTests\Orm\TestCase;
use Tester\Assert;


$dic = require_once __DIR__ . '/../../../../bootstrap.php';


/**
 * @author Foo
 * @property
 */
class EdgeCasesMetadataParserEntity1
{}
/**
 * @property Type
 */
class EdgeCasesMetadataParserEntity2
{}
/**
 * @property Type nameWithoutDollarSign
 */
class EdgeCasesMetadataParserEntity3
{}
/**
 * @property string $var {m:1 ]}
 */
class EdgeCasesMetadataParserEntity4
{}
/**
 * @property string $var {unknown}
 */
class EdgeCasesMetadataParserEntity5
{}
/**
 * @property foo $var {1:n}
 */
class EdgeCasesMetadataParserEntity6
{}
/**
 * @property foo $var {1:n Entity}
 */
class EdgeCasesMetadataParserEntity7
{}
/**
 * @property foo $var {1:n Entity::$bar}
 */
class EdgeCasesMetadataParserEntity8
{}


class MetadataParserExceptionsTest extends TestCase
{
	public function testOneHasMany()
	{
		$parser = new MetadataParser([]);

		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity1::class, $dep);
		}, InvalidArgumentException::class);
		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity2::class, $dep);
		}, InvalidArgumentException::class);
		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity3::class, $dep);
		}, InvalidArgumentException::class);

		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity4::class, $dep);
		}, InvalidModifierDefinitionException::class, 'Invalid modifier definition for NextrasTests\Orm\Entity\Reflection\EdgeCasesMetadataParserEntity4::$var property.');

		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity5::class, $dep);
		}, InvalidModifierDefinitionException::class, 'Unknown modifier \'unknown\' type for NextrasTests\Orm\Entity\Reflection\EdgeCasesMetadataParserEntity5::$var property.');

		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity6::class, $dep);
		}, InvalidModifierDefinitionException::class, 'Relationship {1:m} in NextrasTests\Orm\Entity\Reflection\EdgeCasesMetadataParserEntity6::$var has not defined target entity and its property name.');
		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity7::class, $dep);
		}, InvalidModifierDefinitionException::class, 'Relationship {1:m} in NextrasTests\Orm\Entity\Reflection\EdgeCasesMetadataParserEntity7::$var has not defined target property name.');
		Assert::throws(function () use ($parser) {
			$parser->parseMetadata(EdgeCasesMetadataParserEntity8::class, $dep);
		}, InvalidModifierDefinitionException::class, 'Relationship {1:m} in NextrasTests\Orm\Entity\Reflection\EdgeCasesMetadataParserEntity8::$var points to uknown \'NextrasTests\Orm\Entity\Reflection\Entity\' entity.');
	}
}


$test = new MetadataParserExceptionsTest($dic);
$test->run();
