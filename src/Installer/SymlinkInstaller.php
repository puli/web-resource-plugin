<?php

/*
 * This file is part of the puli/web-resource-plugin package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\WebResourcePlugin\Installer;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class SymlinkInstaller extends CopyInstaller
{
    public function __construct()
    {
        parent::__construct(true);
    }
}