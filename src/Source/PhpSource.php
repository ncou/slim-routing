<?php

/*
 * slim-routing (https://github.com/juliangut/slim-routing).
 * Slim framework routing.
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/slim-routing
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Jgut\Slim\Routing\Source;

use Jgut\Slim\Routing\Compiler\ArrayCompiler;
use Jgut\Slim\Routing\Loader\PhpLoader;

/**
 * PHP files Routing source.
 */
class PhpSource extends AbstractSource
{
    /**
     * {@inheritdoc}
     */
    public function getLoaderClass(): string
    {
        return PhpLoader::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompilerClass(): string
    {
        return ArrayCompiler::class;
    }
}