<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, withHeadingRow
{
    use Importable;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (User::where('email', $row['email'])->orWhere('username', $row['username'])->exists()) {
            return null;
        }
        $user = new User([
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        $user->save();
        $user->assignRole('student');

        return $user;
    }
}
