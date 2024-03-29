<?php

declare(strict_types=1);

namespace AsyncAws\CodeGenerator\Definition;

/**
 * @internal
 */
class WaiterAcceptor
{
    public const MATCHER_STATUS = 'status';
    public const MATCHER_PATH = 'path';
    public const MATCHER_ERROR = 'error';

    public const STATE_SUCCESS = 'success';
    public const STATE_RETRY = 'retry';
    public const STATE_FAILURE = 'failure';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var \Closure(string, Member|null=, array<string, mixed>=): Shape
     */
    protected $shapeLocator;

    private function __construct()
    {
    }

    /**
     * @param \Closure(string, Member|null=, array<string, mixed>=): Shape $shapeLocator
     */
    public static function create(array $data, \Closure $shapeLocator): self
    {
        switch ($data['matcher']) {
            case 'error':
                $waiter = new ErrorWaiterAcceptor();

                break;
            default:
                $waiter = new self();

                break;
        }

        $waiter->data = $data;
        $waiter->shapeLocator = $shapeLocator;

        return $waiter;
    }

    public function getMatcher(): string
    {
        return $this->data['matcher'];
    }

    public function getExpected(): string
    {
        return (string) $this->data['expected'];
    }

    public function getArgument(): string
    {
        return (string) $this->data['argument'];
    }

    public function getState(): string
    {
        return $this->data['state'];
    }
}
