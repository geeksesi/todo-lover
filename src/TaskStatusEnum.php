<?php
namespace Geeksesi\TodoLover;

class TaskStatusEnum
{
    public const OPEN = 1;
    public const TODO = 2;
    public const INPROGRESS = 3;
    public const DONE = 4;
    public const CLOSE = 5;

    public const ALL = [self::OPEN, self::TODO, self::INPROGRESS, self::DONE, self::CLOSE];

    private const STRINGIFY = [
        self::OPEN => "open",
        self::TODO => "todo",
        self::INPROGRESS => "inprogress",
        self::DONE => "done",
        self::CLOSE => "close",
    ];

    public static function toString(int $enum)
    {
        if (!in_array($enum, self::ALL)) {
            return null;
        }
        return self::STRINGIFY[$enum];
    }
}
