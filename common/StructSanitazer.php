<?php

namespace common;

use ArrayIterator;

/** @implements SanitazerInterface<array> */
final class StructSanitazer implements SanitazerInterface
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
    public function sanitaze(array|string|int $value): array
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
}
