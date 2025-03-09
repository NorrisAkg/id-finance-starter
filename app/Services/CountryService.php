<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Collection;

final class CountryService
{
    public function getAll(): Collection
    {
        return Country::all();
    }

    public function getById(int $id): Country
    {
        return Country::findOrFail($id);
    }
}
