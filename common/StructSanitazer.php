<?php

declare(strict_types=1);

namespace common;

use ArrayIterator;
use Exception;

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

    public function clone(): StructSanitazer
    {
        return new StructSanitazer($this->sanitazers);
    }

    /**
     * {@inheritDoc}
     */
    public function sanitaze(array|string|int|float $value): array
    {
        $result = [];

        $iterator = new ArrayIterator($this->sanitazers);
        $this->currentSanitazer = $iterator->current();

        $wasErrorOccured = false;

        foreach ($value as $key => $elementOfValue) {
            try {
                $result[$key] = $this->currentSanitazer->sanitaze($elementOfValue);
            } catch (Exception $e) {
                $result[$key] = $e->getMessage();
                $wasErrorOccured = true;
            }

            $iterator->next();

            if (!$iterator->valid()) {
                break;
            }

            $this->currentSanitazer = $iterator->current();
        }

        if ($wasErrorOccured) {
            throw new Exception(sprintf('An error occured when sanitaze struct: %s', json_encode($result)));
        }

        return $result;
    }
}
