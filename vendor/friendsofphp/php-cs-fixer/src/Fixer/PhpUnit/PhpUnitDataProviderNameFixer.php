<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Fixer\PhpUnit;

use PhpCsFixer\Fixer\AbstractPhpUnitFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\ConfigurableFixerTrait;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Analyzer\DataProviderAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

/**
 * @author Kuba Werłos <werlos@gmail.com>
 *
 * @implements ConfigurableFixerInterface<_AutogeneratedInputConfiguration, _AutogeneratedComputedConfiguration>
 *
 * @phpstan-type _AutogeneratedInputConfiguration array{
 *  prefix?: string,
 *  suffix?: string
 * }
 * @phpstan-type _AutogeneratedComputedConfiguration array{
 *  prefix: string,
 *  suffix: string
 * }
 */
final class PhpUnitDataProviderNameFixer extends AbstractPhpUnitFixer implements ConfigurableFixerInterface
{
    /** @use ConfigurableFixerTrait<_AutogeneratedInputConfiguration, _AutogeneratedComputedConfiguration> */
    use ConfigurableFixerTrait;

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Data provider names must match the name of the test.',
            [
                new CodeSample(
                    '<?php
class FooTest extends TestCase {
    /**
     * @dataProvider dataProvider
     */
    public function testSomething($expected, $actual) {}
    public function dataProvider() {}
}
',
                ),
                new CodeSample(
                    '<?php
class FooTest extends TestCase {
    /**
     * @dataProvider dt_prvdr_ftr
     */
    public function test_feature($expected, $actual) {}
    public function dt_prvdr_ftr() {}
}
',
                    [
                        'prefix' => 'data_',
                        'suffix' => '',
                    ]
                ),
                new CodeSample(
                    '<?php
class FooTest extends TestCase {
    /**
     * @dataProvider dataProviderUsedInMultipleTests
     */
    public function testA($expected, $actual) {}
    /**
     * @dataProvider dataProviderUsedInMultipleTests
     */
    public function testB($expected, $actual) {}
    /**
     * @dataProvider dataProviderUsedInSingleTest
     */
    public function testC($expected, $actual) {}
    /**
     * @dataProvider dataProviderUsedAsFirstInTest
     * @dataProvider dataProviderUsedAsSecondInTest
     */
    public function testD($expected, $actual) {}

    public function dataProviderUsedInMultipleTests() {}
    public function dataProviderUsedInSingleTest() {}
    public function dataProviderUsedAsFirstInTest() {}
    public function dataProviderUsedAsSecondInTest() {}
}
',
                    [
                        'prefix' => 'provides',
                        'suffix' => 'Data',
                    ]
                ),
            ],
            null,
            'Fixer could be risky if one is calling data provider by name as function.'
        );
    }

    /**
     * {@inheritdoc}
     *
     * Must run before PhpUnitAttributesFixer.
     */
    public function getPriority(): int
    {
        return 9;
    }

    public function isRisky(): bool
    {
        return true;
    }

    protected function createConfigurationDefinition(): FixerConfigurationResolverInterface
    {
        return new FixerConfigurationResolver([
            (new FixerOptionBuilder('prefix', 'Prefix that replaces "test".'))
                ->setAllowedTypes(['string'])
                ->setDefault('provide')
                ->getOption(),
            (new FixerOptionBuilder('suffix', 'Suffix to be present at the end.'))
                ->setAllowedTypes(['string'])
                ->setDefault('Cases')
                ->getOption(),
        ]);
    }

    protected function applyPhpUnitClassFix(Tokens $tokens, int $startIndex, int $endIndex): void
    {
        $dataProviderAnalyzer = new DataProviderAnalyzer();
        foreach ($dataProviderAnalyzer->getDataProviders($tokens, $startIndex, $endIndex) as $dataProviderAnalysis) {
            if (\count($dataProviderAnalysis->getUsageIndices()) > 1) {
                continue;
            }

            $usageIndex = $dataProviderAnalysis->getUsageIndices()[0][0];
            if (substr_count($tokens[$usageIndex]->getContent(), '@dataProvider') > 1) {
                continue;
            }

            $dataProviderNewName = $this->getDataProviderNameForUsageIndex($tokens, $usageIndex);
            if (null !== $tokens->findSequence([[T_FUNCTION], [T_STRING, $dataProviderNewName]], $startIndex, $endIndex)) {
                continue;
            }

            $tokens[$dataProviderAnalysis->getNameIndex()] = new Token([T_STRING, $dataProviderNewName]);

            $newCommentContent = Preg::replace(
                \sprintf('/(@dataProvider\s+)%s/', $dataProviderAnalysis->getName()),
                \sprintf('$1%s', $dataProviderNewName),
                $tokens[$usageIndex]->getContent(),
            );

            $tokens[$usageIndex] = new Token([T_DOC_COMMENT, $newCommentContent]);
        }
    }

    private function getDataProviderNameForUsageIndex(Tokens $tokens, int $index): string
    {
        do {
            if (\defined('T_ATTRIBUTE') && $tokens[$index]->isGivenKind(T_ATTRIBUTE)) {
                $index = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_ATTRIBUTE, $index);
            }
            $index = $tokens->getNextMeaningfulToken($index);
        } while (!$tokens[$index]->isGivenKind(T_STRING));

        $name = $tokens[$index]->getContent();

        $name = Preg::replace('/^test_*/i', '', $name);

        if ('' === $this->configuration['prefix']) {
            $name = lcfirst($name);
        } elseif ('_' !== substr($this->configuration['prefix'], -1)) {
            $name = ucfirst($name);
        }

        return $this->configuration['prefix'].$name.$this->configuration['suffix'];
    }
}