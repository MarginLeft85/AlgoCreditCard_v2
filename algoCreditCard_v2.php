<?php

class CardValidator {
    private $cardNumber;
    private $patterns = [
        'Visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
        'Mastercard' => '/^5[1-5][0-9]{14}$/',
        'Maestro' => '/^(5018|5020|5038|5893|6304|6759|6761|6762|6763)[0-9]{8,15}$/',
        'Doron' => '/^(14|81|99)[0-9]{12}$/'
    ];

    public function __construct($cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    public function valideteCard() {
        foreach ($this->patterns as $cardtype => $pattern) {
            if (preg_match($pattern, $this->cardNumber)) {
                return $cardtype;
            }
        }
        return false;
    }

    public function luhnAlgorithm() {
        $number = strrev(preg_replace('/[^0-9]/', '', $this->cardNumber));
        $sum = 0;

        for ($i = 0, $length = strlen($number); $i < $length; $i++) {
            $digit = intval($number[$i]);

            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }
}

$cardNumber = '5018015112830366';

$cardValidator = new CardValidator($cardNumber);

if ($cardValidator->luhnAlgorithm()) {
    echo 'Номер карты валиден.'.' ';
} else {
    echo 'Номер карты невалиден.';
}

if ($cardType = $cardValidator->valideteCard()) {
    echo 'Это карта: ' . $cardType;
} else {
    echo 'Такой карты не существует';
}
