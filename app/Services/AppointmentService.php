<?php

namespace App\Services;

use App\Core\DuplicateRecordException;
use App\Repositories\AppointmentRepository;

class AppointmentService
{
    private AppointmentRepository $repository;

    public function __construct()
    {
        $this->repository = new AppointmentRepository();
    }

    public function list(string $keyword, int $page, int $limit): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $appointments = $this->repository->paginate($keyword, $limit, $offset);
        $total = $this->repository->count($keyword);
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
            $appointments = $this->repository->paginate($keyword, $limit, $offset);
        }

        return [
            'appointments' => $appointments,
            'page' => $page,
            'totalPages' => $totalPages,
        ];
    }

    public function find(int $id): ?array
    {
        return $this->repository->find($id);
    }

    public function create(array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $this->repository->create($data);

            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => ['general' => $e->getMessage()],
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $this->repository->update($id, $data);

            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => ['general' => $e->getMessage()],
            ];
        }
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['appointment_code'] === '') {
            $errors['appointment_code'] = 'Appointment code is required.';
        }

        if ($data['patient_id'] === '') {
            $errors['patient_id'] = 'Patient is required.';
        }

        if ($data['appointment_date'] === '') {
            $errors['appointment_date'] = 'Appointment date is required.';
        }

        if ($data['department'] === '') {
            $errors['department'] = 'Department is required.';
        }

        if (
            $data['fee'] === ''
            || !is_numeric($data['fee'])
            || (float)$data['fee'] < 0
        ) {
            $errors['fee'] = 'Fee must be a positive number.';
        }

        $allowedStatuses = [
            'pending',
            'confirmed',
            'completed',
            'cancelled',
        ];

        if (
            !in_array(
                $data['appointment_status'],
                $allowedStatuses,
                true
            )
        ) {
            $errors['appointment_status'] = 'Invalid appointment status.';
        }

        return $errors;
    }
}
