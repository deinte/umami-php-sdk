<?php

arch('debug functions are not used')
    ->expect(['dd', 'dump', 'var_dump', 'print_r', 'var_export', 'die', 'exit'])
    ->not->toBeUsed();

arch('Enums')
    ->expect('Deinte\UmamiSdk\Enums')
    ->toBeEnums();

arch('Exceptions')
    ->expect('Deinte\UmamiSdk\Exceptions')
    ->toExtend(Exception::class)
    ->toHaveSuffix('Exception');

arch('Requests')
    ->expect('Deinte\UmamiSdk\Requests')
    ->toExtend('Saloon\Http\Request');

arch('Concerns')
    ->expect('Deinte\UmamiSdk\Concerns')
    ->toBeTraits()
    ->toHavePrefix('Supports');
