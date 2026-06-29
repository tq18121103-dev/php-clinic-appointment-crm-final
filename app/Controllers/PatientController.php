<?php

namespace App\Controllers;

use App\Services\PatientService;

class PatientController
{
    private PatientService $service;

    public function __construct()
    {
        $this->service = new PatientService();
    }

    public function index(): void
    {
        require_login();

        $keyword = trim($_GET['keyword'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 5;

        $result = $this->service->list($keyword, $page, $limit);

        render('patients/index', [
            'title' => 'Patients',
            'patients' => $result['patients'],
            'keyword' => $keyword,
            'page' => $result['page'],
            'totalPages' => $result['totalPages'],
        ]);
    }

    public function create(): void
    {
        require_login();
        require_admin();

        render('patients/create', [
            'title' => 'Create Patients',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        require_login();
        require_admin();

        verify_csrf();

        $data = $this->input();

        $result = $this->service->create($data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/patients/create');
        }

        flash('success', 'Patient created successfully.');

        redirect('/patients');
    }

    public function edit(): void
    {
        require_login();
        require_admin();

        $id = (int) ($_GET['id'] ?? 0);

        $patient = $this->service->find($id);

        if (!$patient) {
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found']);
            return;
        }

        render('patients/edit', [
            'title' => 'Edit Patients',
            'patients' => $patient,
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function update(): void
    {
        require_login();
        require_admin();

        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->input();

        $result = $this->service->update($id, $data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/patients/edit?id=' . $id);
        }

        flash('success', 'Patient updated successfully.');

        redirect('/patients');
    }

    public function delete(): void
    {
        require_login();
        require_admin();
        
        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);

        $this->service->delete($id);

        flash('success', 'Patient deleted successfully.');

        redirect('/patients');
    }

    private function input(): array
    {
        return [
            'patient_code' => trim($_POST['patient_code'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'gender' => trim($_POST['gender'] ?? ''),
            'birth_date' => trim($_POST['birth_date'] ?? ''),
        ];
    }
}