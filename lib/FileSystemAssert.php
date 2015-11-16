<?php

/**
 * This file is part of sci/assert.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sci\Assert;

class FileSystemAssert extends Assert
{
    public function exists()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(file_exists($value), 'Failed assertion that file %s exists', $value);
        });

        return $this;
    }

    public function isFile()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_file($value), 'Failed assertion that %s is a regular file', $value);
        });

        return $this;
    }

    public function isDir()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_dir($value), 'Failed assertion that %s is a directory', $value);
        });

        return $this;
    }

    public function isLink()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_link($value), 'Failed assertion that %s is a symbolic link', $value);
        });

        return $this;
    }
}
