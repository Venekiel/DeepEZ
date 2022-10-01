<?php

namespace App\Services;

use Faker;
use App\Enum\PasswordTypesEnum;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class PasswordGeneratorService 
{
    /**
     * @var int $length of the password to be generated
    */
    private int $length = 10;

    /**
     * @var string $type of the password to be generated
    */
    private string $type = PasswordTypesEnum::WORD;

    public function setLength(int $length)
    {
        $this->length = $length;

        return $this;
    }

    public function setType(string $type)
    {
        if(!PasswordTypesEnum::isValidValue($type))
        {
            throw new InvalidArgument("Error: Invalid argument value $type.\n  Argument should be of type " . PasswordTypesEnum::class);
        }

        $this->type = $type;

        return $this;
    }

    public function generate(): string
    {
        $faker = Faker\Factory::create();
        //$password = $faker->
        $password = $faker->text($this->length);

        return $password;
    }
}