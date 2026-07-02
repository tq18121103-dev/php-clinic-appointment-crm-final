<?php

namespace App\Controllers;
use App\Services\AppointmentService;

class AppointmentController
{
    private AppointmentService $service;

    public function __construct()
    {
        $this->service = new AppointmentService();
    }

    public function index(): void
    {
        require_login();

        $keyword = trim($_GET['keyword'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 5;

        $result = $this->service->list($keyword, $page, $limit);

        render('appointments/index', [
            'title' => 'Appointments',
            'appointments' => $result['appointments'],
            'keyword' => $keyword,
            'page' => $result['page'],
            'totalPages' => $result['totalPages'],
        ]);
    }

    public function create(): void
    {
        require_login();
        require_admin();

        render('appointments/create', [
            'title' => 'Create Appointment',
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

            redirect('/appointments/create');
        }

        flash('success', 'Appointment created successfully.');

        redirect('/appointments');
    }

    public function edit(): void
    {
        require_login();
        require_admin();

        $id = (int) ($_GET['id'] ?? 0);

        $appointment = $this->service->find($id);

        if (!$appointment) {
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found']);
            return;
        }

        render('appointments/edit', [
            'title' => 'Edit Appointment',
            'appointment' => $appointment,
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

            redirect('/appointments/edit?id=' . $id);
        }

        flash('success', 'Appointment updated successfully.');

        redirect('/appointments');
    }

    public function delete(): void
    {
        require_login();
        require_admin();
        
        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);

        $this->service->delete($id);

        flash('success', 'Appointment deleted successfully.');

        redirect('/appointments');
    }

   private function input(): array
    {
        return [
            'appointment_code' => trim($_POST['appointment_code'] ?? ''),
            'patient_id' => trim($_POST['patient_id'] ?? ''),
            'appointment_date' => trim($_POST['appointment_date'] ?? ''),
            'department' => trim($_POST['department'] ?? ''),
            'fee' => trim($_POST['fee'] ?? ''),
            'appointment_status' => trim($_POST['appointment_status'] ?? ''),
        ];
    }
}