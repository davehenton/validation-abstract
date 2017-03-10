<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Dhii\Validation\Exception\ValidationFailedExceptionInterface;

/**
 * Tests {@see Dhii\Validation\AbstractValidator}.
 *
 * @since [*next-version*]
 */
class AbstractValidatorTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Validation\\AbstractValidator';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return AbstractValidator
     */
    public function createInstance()
    {
        $me = $this;
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->_validate(function ($value) use (&$me) {
                    if ($value !== true) {
                        throw $me->createValidationFailedException();
                    }
                })
                ->_createValidationException()
                ->_createValidationFailedException()
                ->new();

        return $mock;
    }

    /**
     * Creates a new validation failed exception.
     *
     * @since [*next-version*]
     *
     * @return ValidationFailedExceptionInterface
     */
    public function createValidationFailedException()
    {
        $mock = $this->mock('Dhii\\Validation\\TestStub\\AbstractValidationFailedException')
                ->getValidationErrors()
                ->getSubject()
                ->new();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(static::TEST_SUBJECT_CLASSNAME, $subject, 'Could not create a valid instance');
    }

    /**
     * Tests whether validity is correctly determined.
     *
     * @since [*next-version*]
     */
    public function testIsValid()
    {
        $subject = $this->createInstance();
        $me = $this;

        $reflection = $this->reflect($subject);
        $this->assertTrue($reflection->_isValid(true), 'Valid value not validated correctly');
        $this->assertFalse($reflection->_isValid(false), 'Invalid value not validated correctly');
    }
}