<?php

namespace common;

use ArrayIterator;

/** @implements SanitazerInterface<array> */
final class ArraySanitazer implements SanitazerInterface, CompositeInterface
{
    private array $sanitazers = [];
    private SanitazerInterface $currentSanitazer;


    /**
    * @param SanitazerInterface[] $sanitazers
    */
    public function __construct(array $sanitazers)
    {
        $this->sanitazers = $sanitazers;
    }

    /**
       * {@inheritDoc}
       */
    public function sanitaze(array|string $value): array
    {
        $result = [];

        $iterator = new ArrayIterator($this->sanitazers);
        $this->currentSanitazer = $iterator->current();

        foreach ($value as $key => $elementOfValue) {
            $result[$key] = $this->currentSanitazer->sanitaze($elementOfValue);

            $iterator->next();

            if (!$iterator->valid()) {
                break;
            }

            $this->currentSanitazer = $iterator->current();
        }

        return $result;
    }

    public function addChild(SanitazerInterface $sanitazer): void
    {
        $this->sanitazers[] = $sanitazer;
    }
}
