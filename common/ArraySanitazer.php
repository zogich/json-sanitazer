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
            $this->sanitazers[] = $typeOfArrayValues->clone();
        }
    }

    public function clone(): ArraySanitazer
    {
        return new ArraySanitazer(new $this->sanitazers[0](), count($this->sanitazers));
    }

    public function sanitaze(array|string|int|float $value): array
    {
        $result = [];

        $iterator = new ArrayIterator($this->sanitazers);
        $this->currentSanitazer = $iterator->current();

        $wasErrorsOccuredInSanitazeLoop = false;

        foreach ($value as $key => $elementOfValue) {
            try {
                $result[$key] = $this->currentSanitazer->sanitaze($elementOfValue);
            } catch (Exception $e) {
                // оставляем санитайзеру верхнего увррованя заполнять ошибки, так как сами санитайзеры должны завершаться либо успешно, либо
                // выбрасывать исключение - будем перехватывать внутри санитайзеров, не увидим ошибки, то есть мы предоставляем верхнему уровню обработать ошибки
                // В данном случае - верхний уровень - санитайзер массивов/структур, и мы на этом уровне выбираем, как реагировать на ошибку санитайзера.
                $result[$key] = $e->getMessage();
                $wasErrorsOccuredInSanitazeLoop = true;
            }
            // ToDo подумать как лучше - чтобы массивы и структуры бросали исключение или нет. Дальше пишем тесты.

            $iterator->next();

            if (!$iterator->valid()) {
                break;
            }

            $this->currentSanitazer = $iterator->current();
        }

        if ($wasErrorsOccuredInSanitazeLoop) {
            throw new Exception(sprintf('Error occured when sanitaze array: %s', json_encode($result)));
        }

        return $result;
    }
}
