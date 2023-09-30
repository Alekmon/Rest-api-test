<?php
namespace App\Enum;

enum Status: string
{
    case NEW = 'новая';
    case AT_WORK = 'в работе';
    case DESIDED = 'решено';
}