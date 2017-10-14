<?php

/**
 * This file is part of the sci/assert package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sci\Assert;

class Assert
{
    const CLASS_NAME = __CLASS__;

    use BaseAssertionTrait;
    use ComparisonAssertionTrait;
    use StringAssertionTrait;

    /** @var mixed */
    private $value;

    /** @var bool */
    private $plural;

    /** @var bool */
    private $alwaysValid;

    /**
     * @param mixed $value
     */
    final private function __construct($value)
    {
        $this->value = $value;

        $this->plural = false;
        $this->alwaysValid = false;
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    final public static function that($value)
    {
        return new static($value);
    }

    /**
     * @return Assert
     */
    public function all()
    {
        $this->isTraversable();

        $this->plural = true;

        return $this;
    }

    /**
     * @return Assert
     */
    public function nullOr()
    {
        if ($this->value === null) {
            $this->alwaysValid = true;
        }

        return $this;
    }

    protected function doCheck(callable $check)
    {
        if (!$this->alwaysValid) {
            $values = $this->plural ? $this->value : [$this->value];

            foreach ($values as $value) {
                call_user_func($check, $value);
            }
        }

        return $this;
    }

    /**
     * Throws an InvalidArgumentException, if $condition doesn't hold.
     *
     * @param bool   $condition
     * @param string $messageFormatString
     * @param mixed  $...
     *
     * @throws InvalidArgumentException
     */
    protected function throwExceptionIfFalse()
    {
        $args = func_get_args();

        $condition = array_shift($args);

        if (!$condition) {
            $args = array_map([$this, 'stringify'], $args);

            $message = call_user_func_array('sprintf', $args);

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function stringify($value)
    {
        if (is_bool($value)) {
            return $value ? '<TRUE>' : '<FALSE>';
        } elseif (is_scalar($value)) {
            $val = (string) $value;

            if (strlen($val) > 100) {
                $val = substr($val, 0, 97).'...';
            }

            return $val;
        } elseif (is_array($value)) {
            return '<ARRAY>';
        } elseif (is_object($value)) {
            return sprintf('%s [%s]', get_class($value), spl_object_hash($value));
        } elseif (is_resource($value)) {
            return '<RESOURCE>';
        } elseif (is_null($value)) {
            return '<NULL>';
        } else {
            return 'unknown';
        }
    }
}
