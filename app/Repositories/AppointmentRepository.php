<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class AppointmentRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT appointments.*, patients.full_name AS patient_name
            FROM appointments
            LEFT JOIN patients ON appointments.patient_id = patients.id
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE appointments.appointment_code LIKE :keyword1
                   OR patients.full_name LIKE :keyword2
                   OR appointments.appointment_status LIKE :keyword3
            ";
        }

        $allowedSorts = [
            'id' => 'appointments.id',
            'appointment_code' => 'appointments.appointment_code',
            'fee' => 'appointments.fee',
            'appointment_status' => 'appointments.appointment_status',
            'created_at' => 'appointments.created_at',
        ];

        $sort = $_GET['sort'] ?? 'id';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        $sortColumn = $allowedSorts[$sort] ?? 'appointments.id';

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        $sql .= "
            ORDER BY $sortColumn $direction
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $search = '%' . $keyword . '%';
        
            $stmt->bindValue(':keyword1', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword2', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword3', $search, PDO::PARAM_STR);
        }
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function count(string $keyword = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            LEFT JOIN patients ON appointments.patient_id = patients.id
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE appointments.appointment_code LIKE :keyword1
                   OR patients.full_name LIKE :keyword2
                   OR appointments.appointment_status LIKE :keyword3
            ";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $search = '%' . $keyword . '%';
        
            $stmt->bindValue(':keyword1', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword2', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword3', $search, PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM appointments
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO appointments
                (
                    appointment_code,
                    patient_id,
                    appointment_date,
                    department,
                    fee,
                    appointment_status
                )
                VALUES
                (
                    :appointment_code,
                    :patient_id,
                    :appointment_date,
                    :department,
                    :fee,
                    :appointment_status
                )
            ");

            $stmt->execute([
                'appointment_code' => $data['appointment_code'],
                'patient_id' => $data['patient_id'],
                'appointment_date' => $data['appointment_date'],
                'department' => $data['department'],
                'fee' => $data['fee'],
                'appointment_status' => $data['appointment_status'],
            ]);

        } catch (PDOException $e) {
            $mysqlCode = $e->errorInfo[1] ?? null;
        
            if ($mysqlCode === 1062) {
                throw new DuplicateRecordException(
                    'Appointment code already exists.'
                );
            }
        
            if ($mysqlCode === 1452) {
                throw new DuplicateRecordException(
                    'Selected patient does not exist.'
                );
            }
        
            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE appointments
                SET
                    appointment_code = :appointment_code,
                    patient_id = :patient_id,
                    appointment_date = :appointment_date,
                    department = :department,
                    fee = :fee,
                    appointment_status = :appointment_status
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'appointment_code' => $data['appointment_code'],
                'patient_id' => $data['patient_id'],
                'appointment_date' => $data['appointment_date'],
                'department' => $data['department'],
                'fee' => $data['fee'],
                'appointment_status' => $data['appointment_status'],
            ]);
        } catch (PDOException $e) {
            $mysqlCode = $e->errorInfo[1] ?? null;
        
            if ($mysqlCode === 1062) {
                throw new DuplicateRecordException(
                    'Appointment code already exists.'
                );
            }
        
            if ($mysqlCode === 1452) {
                throw new DuplicateRecordException(
                    'Selected patient does not exist.'
                );
            }
        
            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM appointments
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}