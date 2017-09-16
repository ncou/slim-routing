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

namespace Jgut\Slim\Routing\Mapping\Driver;

/**
 * Mapping driver interface.
 */
interface DriverInterface
{
    /**
     * Get routing metadata.
     *
     * @param string[] $loadingPaths
     *
     * @return \Jgut\Slim\Routing\Mapping\RouteMetadata[]
     */
    public function getRoutingMetadata(array $loadingPaths): array;
}
