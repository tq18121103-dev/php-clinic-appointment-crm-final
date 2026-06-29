USE clinic_appointment_crm;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE appointments;
TRUNCATE TABLE patients;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO users(username,password,role)
VALUES
('admin', '$2y$10$kY5W7OC9eBzT6bDwopob5eAhJnThP2fs9ixyi2Fe.i1NczGtc.fv2', 'admin'),
('staff1', '$2y$10$kY5W7OC9eBzT6bDwopob5eAhJnThP2fs9ixyi2Fe.i1NczGtc.fv2', 'staff');

INSERT INTO patients
(patient_code, full_name, email, phone, symptom, status)
VALUES
('PT001','Nguyen Van An','an.patient@gmail.com','0901000001','Headache','new'),
('PT002','Tran Thi Bich','bich.patient@gmail.com','0901000002','Fever','contacted'),
('PT003','Le Minh Chau','chau.patient@gmail.com','0901000003','Toothache','scheduled'),
('PT004','Pham Hoang Duy','duy.patient@gmail.com','0901000004','Back pain','treated'),
('PT005','Vo Thi Em','em.patient@gmail.com','0901000005','Cough','cancelled'),
('PT006','Hoang Gia Huy','huy.patient@gmail.com','0901000006','Skin rash','new'),
('PT007','Dang Thu Ha','ha.patient@gmail.com','0901000007','Stomach pain','contacted'),
('PT008','Bui Quoc Khanh','khanh.patient@gmail.com','0901000008','Eye pain','scheduled'),
('PT009','Do Nhat Linh','linh.patient@gmail.com','0901000009','Sore throat','treated'),
('PT010','Mai Phuong Nhi','nhi.patient@gmail.com','0901000010','Dizziness','new'),
('PT011','Nguyen Bao Nam','nam.patient@gmail.com','0901000011','Chest pain','scheduled'),
('PT012','Tran Thanh Nga','nga.patient@gmail.com','0901000012','Allergy','contacted'),
('PT013','Le Quang Phuc','phuc.patient@gmail.com','0901000013','Joint pain','treated'),
('PT014','Pham Thuy Tien','tien.patient@gmail.com','0901000014','Fever','new'),
('PT015','Vo Minh Quan','quan.patient@gmail.com','0901000015','Headache','scheduled'),
('PT016','Dang Anh Thu','thu.patient@gmail.com','0901000016','Cough','contacted'),
('PT017','Bui Gia Bao','bao.patient@gmail.com','0901000017','Toothache','new'),
('PT018','Do Khanh Vy','vy.patient@gmail.com','0901000018','Eye pain','scheduled'),
('PT019','Mai Hoai My','my.patient@gmail.com','0901000019','Back pain','treated'),
('PT020','Nguyen Thanh Long','long.patient@gmail.com','0901000020','Stomach pain','new');

INSERT INTO appointments
(appointment_code, patient_id, appointment_date, department, fee, appointment_status)
VALUES
('AP001',1,'2026-07-01','General Medicine',200000,'confirmed'),
('AP002',2,'2026-07-02','Pediatrics',250000,'pending'),
('AP003',3,'2026-07-03','Dentistry',300000,'completed'),
('AP004',4,'2026-07-04','Orthopedics',350000,'confirmed'),
('AP005',5,'2026-07-05','Respiratory',220000,'cancelled'),
('AP006',6,'2026-07-06','Dermatology',280000,'pending'),
('AP007',7,'2026-07-07','Gastroenterology',400000,'confirmed'),
('AP008',8,'2026-07-08','Ophthalmology',320000,'completed'),
('AP009',9,'2026-07-09','ENT',260000,'confirmed'),
('AP010',10,'2026-07-10','General Medicine',200000,'pending'),
('AP011',11,'2026-07-11','Cardiology',500000,'confirmed'),
('AP012',12,'2026-07-12','Dermatology',280000,'pending'),
('AP013',13,'2026-07-13','Orthopedics',350000,'completed'),
('AP014',14,'2026-07-14','Pediatrics',250000,'pending'),
('AP015',15,'2026-07-15','General Medicine',200000,'confirmed'),
('AP016',16,'2026-07-16','Respiratory',220000,'pending'),
('AP017',17,'2026-07-17','Dentistry',300000,'confirmed'),
('AP018',18,'2026-07-18','Ophthalmology',320000,'completed'),
('AP019',19,'2026-07-19','Orthopedics',350000,'confirmed'),
('AP020',20,'2026-07-20','Gastroenterology',400000,'pending');