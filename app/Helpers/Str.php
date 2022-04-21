<?php


namespace App\Helpers;


use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Str
{
    public static function image(string $concatenate, string $dirName, string $imgName): string
    {
        return $concatenate . "public/" . $dirName . "/" . $imgName;
    }

    public static function csrf_token(): string
    {
        try {

            return bin2hex(random_bytes(30));

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public static function humanDate(string $date): string
    {
        return Carbon::create($date)->format('d M, Y');
    }


    public static function capitalize(string $string): string
    {
        return ucfirst($string);
    }

    public static function uuid(): UuidInterface
    {
        try {
            return Uuid::uuid4();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

    }

    public static function token(): string
    {
        try {
            return bin2hex(random_bytes(100));
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}