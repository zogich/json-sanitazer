<?php

namespace common;

use Exception;

/** @implements SanitazerInterface<array> */
final class ArraySanitazer implements SanitazerInterface
{
    private SanitazerInterface $sanitazerOfArrayElements;

    public function __construct(SanitazerInterface $typeOfArrayValues)
    {
        $this->sanitazerOfArrayElements = $typeOfArrayValues;
    }

    public function clone(): ArraySanitazer
    {
        return new ArraySanitazer(new $this->sanitazers[0](), count($this->sanitazers));
    }

    public function sanitaze(array|string|int|float $value): array
    {
        $result = [];

        $wasErrorsOccuredInSanitazeLoop = false;

        foreach ($value as $key => $elementOfValue) {
            try {
                $result[$key] = $this->sanitazerOfArrayElements->sanitaze($elementOfValue);
            } catch (Exception $e) {
                // оставляем санитайзеру верхнего увррованя заполнять ошибки, так как сами санитайзеры должны завершаться либо успешно, либо
                // выбрасывать исключение - будем перехватывать внутри санитайзеров, не увидим ошибки, то есть мы предоставляем верхнему уровню обработать ошибки
                // В данном случае - верхний уровень - санитайзер массивов/структур, и мы на этом уровне выбираем, как реагировать на ошибку санитайзера.
                $result[$key] = $e->getMessage();
                $wasErrorsOccuredInSanitazeLoop = true;
            }
            // ToDo подумать как лучше - чтобы массивы и структуры бросали исключение или нет. Дальше пишем тесты.
        }

        if ($wasErrorsOccuredInSanitazeLoop) {
            throw new Exception(sprintf('Error occured when sanitaze array: %s', json_encode($result)));
        }

        return $result;
    }
}
