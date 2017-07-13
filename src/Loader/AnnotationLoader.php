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

namespace Jgut\Slim\Routing\Loader;

/**
 * Classes routing loader.
 */
class AnnotationLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function load(array $loadingPaths): array
    {
        $rotingFiles = [];

        foreach ($loadingPaths as $path) {
            if (is_dir($path)) {
                $rotingFiles = array_merge($rotingFiles, $this->loadFromDirectory($path));
            } elseif (is_file($path)) {
                $rotingFiles[] = $this->loadFromFile($path);
            } else {
                throw new \RuntimeException(sprintf('Path "%s" does not exist', $path));
            }
        }

        return array_filter(array_unique($rotingFiles));
    }

    /**
     * Load files from directory.
     *
     * @param string $directory
     *
     * @return string[]
     */
    protected function loadFromDirectory(string $directory): array
    {
        $rotingFiles = [];

        foreach (glob($directory . '/{**/*,*}.php', GLOB_BRACE | GLOB_ERR) as $file) {
            if (is_file($file)) {
                $rotingFiles[] = $this->loadFromFile($file);
            }
        }

        return $rotingFiles;
    }

    /**
     * Load fully qualified class name from file.
     *
     * @param string $file
     *
     * @return string
     *
     * @SuppressWarnings(PMD.CyclomaticComplexity)
     * @SuppressWarnings(PMD.NPathComplexity)
     */
    protected function loadFromFile(string $file): string
    {
        $tokens = token_get_all(file_get_contents($file));
        $class = false;
        $namespace = false;

        for ($i = 0, $length = count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            if (!is_array($token)) {
                continue;
            }

            if ($class && $token[0] === T_STRING) {
                $class = $namespace . '\\' . $token[1];

                break;
            }

            if ($namespace === true && $token[0] === T_STRING) {
                $namespace = '';

                do {
                    $namespace .= $token[1];

                    $token = $tokens[++$i];
                } while ($i < $length && is_array($token) && in_array($token[0], [T_NS_SEPARATOR, T_STRING]));
            }

            if ($token[0] == T_CLASS) {
                $class = true;
            }
            if ($token[0] === T_NAMESPACE) {
                $namespace = true;
            }
        }

        return $class ?: '';
    }
}