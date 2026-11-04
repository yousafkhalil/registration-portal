<?php

namespace App\Repositories;

use App\Models\StudentRegistration;

class StudentRegistrationRepository
{
    public function findByUserId($userId): ?StudentRegistration
    {
        return StudentRegistration::where('user_id', $userId)->first();
    }

    public function findByRollNo(string $rollNo): ?StudentRegistration
    {
        return StudentRegistration::where('roll_no', $rollNo)->first();
    }

    public function save(array $data): StudentRegistration
    {
        return StudentRegistration::create($data);
    }

    public function updateOrCreateByUserId($userId, array $data): StudentRegistration
    {
        return StudentRegistration::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}

