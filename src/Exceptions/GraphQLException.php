<?php

declare(strict_types=1);

namespace App\Exceptions;

use Overblog\GraphQLBundle\Error\UserErrors;
use Symfony\Component\Form\FormInterface;

class GraphQLException extends UserErrors
{
    /**
     * @param string $message
     */
    public static function fromString($message)
    {
        return new self([$message]);
    }

    /**
     * @param FormInterface $form
     */
    public static function fromFormErrors(FormInterface $form)
    {
        return new self(self::getPlainErrors($form));
    }

    /**
     * @param FormInterface $form
     */
    public static function getPlainErrors($form)
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[] =static::getPlainErrors($child);
            }
        }

        return $errors;
    }
}
