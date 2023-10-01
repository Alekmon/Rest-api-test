<?php
namespace App\Enum;

enum Status: string
{
    case NEW = 'новая';
    case IN_WORK = 'в работе';
    case SOLVED = 'решено';
}