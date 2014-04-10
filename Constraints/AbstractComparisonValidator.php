<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Provides a base class for the validation of property comparisons.
 *
 * @author Daniel Holmes <daniel@danielholmes.org>
 */
abstract class AbstractComparisonValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$this->compareValues($value, $constraint->value)) {
            $this->context->addViolation($constraint->message, array(
                '{{ value }}' => $this->valueToString($value),
                '{{ compared_value }}' => $this->valueToString($constraint->value),
                '{{ compared_value_type }}' => $this->valueToType($constraint->value)
            ));
        }
    }

    /**
     * Compares the two given values to find if their relationship is valid
     *
     * @param mixed      $value1     The first value to compare
     * @param mixed      $value2     The second value to compare
     *
     * @return Boolean true if the relationship is valid, false otherwise
     */
    abstract protected function compareValues($value1, $value2);
}
