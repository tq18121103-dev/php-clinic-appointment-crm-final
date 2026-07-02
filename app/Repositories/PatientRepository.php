<?php
namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class PatientRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT *
            FROM patients
        ";

        if ($keyword !== '') {
            $sql .= "
            WHERE patient_code LIKE :keyword1
            OR full_name LIKE :keyword2
            OR phone LIKE :keyword3
            OR email LIKE :keyword4
            OR symptom LIKE :keyword5
            OR status LIKE :keyword6
            ";
        }

        $allowedSorts = [
            'id' => 'id',
            'patient_code' => 'patient_code',
            'full_name' => 'full_name',
            'phone' => 'phone',
            'email' => 'email',
            'symptom' => 'symptom',
            'status' => 'status',
            'created_at' => 'created_at',
        ];

        $sort = $_GET['sort'] ?? 'id';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        $sortColumn = $allowedSorts[$sort] ?? 'id';

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
            $stmt->bindValue(':keyword4', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword5', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword6', $search, PDO::PARAM_STR);
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
            FROM patients
        ";

        if ($keyword !== '') {
            $sql .= "
            WHERE patient_code LIKE :keyword1
            OR full_name LIKE :keyword2
            OR phone LIKE :keyword3
            OR email LIKE :keyword4
            OR symptom LIKE :keyword5
            OR status LIKE :keyword6
            ";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $search = '%' . $keyword . '%';

            $stmt->bindValue(':keyword1', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword2', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword3', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword4', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword5', $search, PDO::PARAM_STR);
            $stmt->bindValue(':keyword6', $search, PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM patients
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO patients
                (
                    patient_code,
                    full_name,
                    email,
                    phone,
                    symptom,
                    status
                )
                VALUES
                (
                    :patient_code,
                    :full_name,
                    :email,
                    :phone,
                    :symptom,
                    :status
                )
            ");

            $stmt->execute(
                [
                    'patient_code' => $data['patient_code'],
                    'full_name'    => $data['full_name'],
                    'email'        => $data['email'],
                    'phone'        => $data['phone'],
                    'symptom'      => $data['symptom'],
                    'status'       => $data['status'],
                ]
            );
        } catch (PDOException $e) {
            $mysqlCode = $e->errorInfo[1] ?? null;

            if ($mysqlCode === 1062) {
                throw new DuplicateRecordException(
                    'Patient code already exists.'
                );
            }

            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
            UPDATE patients
            SET
                patient_code = :patient_code,
                full_name = :full_name,
                email = :email,
                phone = :phone,
                symptom = :symptom,
                status = :status
            WHERE id = :id
            ");

            $stmt->execute(
                [
                    'id'           => $id,
                    'patient_code' => $data['patient_code'],
                    'full_name'    => $data['full_name'],
                    'email'        => $data['email'],
                    'phone'        => $data['phone'],
                    'symptom'      => $data['symptom'],
                    'status'       => $data['status'],
                ]
            );
        } catch (PDOException $e) {
            $mysqlCode = $e->errorInfo[1] ?? null;

            if ($mysqlCode === 1062) {
                throw new DuplicateRecordException(
                    'Patient code already exists.'
                );
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM patients
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}