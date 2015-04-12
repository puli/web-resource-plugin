<?php

/*
 * This file is part of the puli/asset-plugin package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\AssetPlugin\Api\Installer;

use Webmozart\Expression\Expression;

/**
 * Manages the installers used to install resources on install targets.
 *
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface InstallerManager
{
    /**
     * Adds an installer descriptor.
     *
     * @param InstallerDescriptor $descriptor The installer descriptor.
     */
    public function addInstallerDescriptor(InstallerDescriptor $descriptor);

    /**
     * Removes the installer descriptor with the given name.
     *
     * If the installer descriptor does not exist, this method does nothing.
     *
     * @param string $name The installer name.
     */
    public function removeInstallerDescriptor($name);

    /**
     * Removes all installer descriptors matching the given expression.
     *
     * @param Expression $expr The search criteria.
     */
    public function removeInstallerDescriptors(Expression $expr);

    /**
     * Removes all installer descriptors.
     */
    public function clearInstallerDescriptors();

    /**
     * Returns the installer descriptor with the given name.
     *
     * @param string $name The installer name.
     *
     * @return InstallerDescriptor The installer descriptor.
     */
    public function getInstallerDescriptor($name);

    /**
     * Returns all registered installer descriptors.
     *
     * @return InstallerDescriptor[] The installer descriptors.
     */
    public function getInstallerDescriptors();

    /**
     * Returns whether the installer descriptor with the given name exists.
     *
     * @param string $name The installer name.
     *
     * @return boolean Returns `true` if the installer with the given name
     *                 exists and `false` otherwise.
     */
    public function hasInstallerDescriptor($name);

    /**
     * Returns whether the manager contains any installer descriptors.
     *
     * You can optionally pass an expression to check whether the manager has
     * installers matching that expression.
     *
     * @param Expression $expr The search criteria.
     *
     * @return boolean Returns `true` if the manager contains installers and
     *                 `false` otherwise.
     */
    public function hasInstallerDescriptors(Expression $expr = null);
}
