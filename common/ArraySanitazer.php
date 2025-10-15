<?php

namespace common;

use ArrayIterator;
use Exception;

/** @implements SanitazerInterface<array> */
final class ArraySanitazer implements SanitazerInterface
{
    private array $sanitazers = [];
    private SanitazerInterface $currentSanitazer;

    public function __construct(SanitazerInterface $typeOfArrayValues, int $count)
    {
        for ($i = 0; $i < $count; ++$i) {
            $this->sanitazers[] = new $typeOfArrayValues();
        }
    }

    public function sanitaze(array|string|int $value): array
    {
        $result = [];

        $iterator = new ArrayIterator($this->sanitazers);
        $this->currentSanitazer = $iterator->current();

        foreach ($value as $key => $elementOfValue) {
            try {
                $result[$key] = $this->currentSanitazer->sanitaze($elementOfValue);
            } catch (Exception $e) {
                $result[$key] = $e->getMessage();
            }

            $iterator->next();

            if (!$iterator->valid()) {
                break;
            }

            $this->currentSanitazer = $iterator->current();
        }

        return $result;
    }
}

