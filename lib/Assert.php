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
    use BaseAssertionTrait;
    use ComparisonAsserionTrait;
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
     * @return Assert
     */
    final public static function that($value)
    {
        return new self($value);
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
     * @throws InvalidArgumentException
     */
    protected function throwException()
    {
        $args = func_get_args();
        $args = array_map([$this, 'stringify'], $args);

        $message = call_user_func_array('sprintf', $args);

        throw new InvalidArgumentException($message);
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
        }

        if (is_scalar($value)) {
            $val = (string) $value;

            if (strlen($val) > 100) {
                $val = substr($val, 0, 97).'...';
            }

            return $val;
        }

        if (is_array($value)) {
            return '<ARRAY>';
        }

        if (is_object($value)) {
            return sprintf('%s [%s]', get_class($value), spl_object_hash($value));
        }

        if (is_resource($value)) {
            return '<RESOURCE>';
        }

        if (is_null($value)) {
            return '<NULL>';
        }

        return 'unknown';
    }
}
