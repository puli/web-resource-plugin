<?php

/*
 * This file is part of the puli/asset-plugin package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\AssetPlugin\Api\Asset;

use Puli\AssetPlugin\Api\Target\NoSuchTargetException;
use Rhumsaa\Uuid\Uuid;
use Webmozart\Expression\Expression;

/**
 * Manages asset mappings.
 *
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface AssetManager
{
    /**
     * Adds an asset mapping to the repository.
     *
     * @param AssetMapping $mapping The asset mapping.
     *
     * @throws NoSuchTargetException If the target referred to by the mapping
     *                               does not exist.
     */
    public function addAssetMapping(AssetMapping $mapping);

    /**
     * Removes an asset mapping from the repository.
     *
     * @param Uuid $uuid The UUID of the mapping.
     */
    public function removeAssetMapping(Uuid $uuid);

    /**
     * Returns the asset mapping for a web path.
     *
     * @param Uuid $uuid The UUID of the mapping.
     *
     * @return AssetMapping The corresponding asset mapping.
     *
     * @throws NoSuchAssetMappingException If the web path is not mapped.
     */
    public function getAssetMapping(Uuid $uuid);

    /**
     * Returns all asset mappings.
     *
     * @return AssetMapping[] The asset mappings.
     */
    public function getAssetMappings();

    /**
     * Returns all asset mappings matching the given expression.
     *
     * @param Expression $expr The search criteria.
     *
     * @return AssetMapping[] The asset mappings matching the expression.
     */
    public function findAssetMappings(Expression $expr);

    /**
     * Returns whether a web path is mapped.
     *
     * @param Uuid $uuid The UUID of the mapping.
     *
     * @return bool Returns `true` if the web path is mapped.
     */
    public function hasAssetMapping(Uuid $uuid);

    /**
     * Returns whether a web path is mapped.
     *
     * You can optionally pass ane expression to check whether the manager has
     * bindings matching that expression.
     *
     * @param Expression $expr The search criteria.
     *
     * @return bool Returns `true` if the web path is mapped.
     */
    public function hasAssetMappings(Expression $expr = null);

}