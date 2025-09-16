<?php

namespace App\Enums;

interface LabelledEnum
{
    /**
     * Memberikan representasi label yang mudah dibaca untuk setiap kasus enum.
     */
    public function label(): string;
}
