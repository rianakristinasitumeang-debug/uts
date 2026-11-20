<?php

declare(strict_types=1);

function e(string|int|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function rupiah(int|string $amount): string
{
    return 'Rp ' . number_format((int) $amount, 0, ',', '.');
}
