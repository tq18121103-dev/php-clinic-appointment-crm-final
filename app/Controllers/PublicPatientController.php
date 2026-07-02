<?php

namespace App\Controllers;

use App\Services\PatientService;

class PublicPatientController
{
    private PatientService $service;

    public function __construct()
    {
        $this->service = new PatientService();
    }

    public function create(): void
    {
        render('patients/public_create', [
            'title' => 'Public Patient Registration',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        verify_csrf();

        // 1. Kiểm tra Honeypot (Trường ẩn chống spam)
        $honeypot = $_POST['website_url'] ?? '';
        if ($honeypot !== '') {
            http_response_code(400);
            echo "Spam detected (Honeypot).";
            exit;
        }

        // 2. Kiểm tra Rate limit bằng Session (Chặn gửi liên tục dưới 10 giây)
        $currentTime = time();
        $limitSeconds = 10;
        if (isset($_SESSION['last_public_submit'])) {
            $timePassed = $currentTime - $_SESSION['last_public_submit'];
            if ($timePassed < $limitSeconds) {
                $_SESSION['errors'] = [
                    'general' => 'Bạn đang gửi yêu cầu quá nhanh. Vui lòng đợi ' . ($limitSeconds - $timePassed) . ' giây nữa.'
                ];
                $_SESSION['old'] = [
                    'patient_code' => trim($_POST['patient_code'] ?? ''),
                    'full_name'    => trim($_POST['full_name'] ?? ''),
                    'email'        => trim($_POST['email'] ?? ''),
                    'phone'        => trim($_POST['phone'] ?? ''),
                    'symptom'      => trim($_POST['symptom'] ?? ''),
                    'status'       => trim($_POST['status'] ?? ''),
                ];
                redirect('/public-patients/create');
            }
        }

        // Đọc dữ liệu đầu vào
        $data = [
            'patient_code' => trim($_POST['patient_code'] ?? ''),
            'full_name'    => trim($_POST['full_name'] ?? ''),
            'email'        => trim($_POST['email'] ?? ''),
            'phone'        => trim($_POST['phone'] ?? ''),
            'symptom'      => trim($_POST['symptom'] ?? ''),
            'status'       => trim($_POST['status'] ?? ''),
        ];

        // Thực hiện validate và lưu thông tin
        $result = $this->service->create($data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;
            redirect('/public-patients/create');
        }

        // Cập nhật thời điểm submit thành công sau cùng
        $_SESSION['last_public_submit'] = $currentTime;

        flash('success', 'Đăng ký thông tin bệnh nhân thành công.');

        // Theo mô hình PRG (Post-Redirect-Get)
        redirect('/public-patients/create');
    }
}
