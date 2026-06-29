<?php

namespace App\Services;

use App\Core\DuplicateRecordException;
use App\Repositories\PatientRepository;

class PatientService
{
    private PatientRepository $repository;

    public function __construct()
    {
        $this->repository = new PatientRepository();
    }

    public function list(string $keyword, int $page, int $limit): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $patients = $this->repository->paginate($keyword, $limit, $offset);
        $total = $this->repository->count($keyword);
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
            $patients = $this->repository->paginate($keyword, $limit, $offset);
        }

        return [
            'patients' => $patients,
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
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        try {
            $this->repository->create($data);

            return [
                'success' => true,
                'errors' => [],
            ];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => [
                    'general' => $e->getMessage(),
                ],
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        try {
            $this->repository->update($id, $data);

            return [
                'success' => true,
                'errors' => [],
            ];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => [
                    'general' => $e->getMessage(),
                ],
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

        if ($data['patient_code'] === '') {
            $errors['patient_code'] = 'Patient code is required.';
        }

        if ($data['full_name'] === '') {
            $errors['full_name'] = 'Full name is required.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email.';
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Phone is required.';
        }

        if ($data['symptom'] === '') {
            $errors['symptom'] = 'Symptom is required.';
        }

        $allowedStatuses = [
            'new',
            'contacted',
            'scheduled',
            'cancelled',
            'treated',
        ];

        if ($data['status'] === '') {
            $errors['status'] = 'Status is required.';
        } elseif (!in_array($data['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Invalid status.';
        }

        return $errors;
    }
}