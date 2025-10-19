<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use ArrayIterator;
use Exception;
use src\interfaces\sanitizers\SanitizerInterface;

/** @implements SanitazerInterface<array> */
final class StructSanitizer implements SanitizerInterface
{
    private array $sanitazers = [];
    private SanitizerInterface $currentSanitazer;

    /**
     * @param SanitazerInterface[] $sanitazers
     */
    public function __construct(array $sanitazers)
    {
        $this->sanitazers = $sanitazers;
    }

    public function clone(): StructSanitizer
    {
        return new StructSanitizer($this->sanitazers);
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
