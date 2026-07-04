# Clinic Appointment CRM - Dự án PHP MVC Final (Lab06)

Ứng dụng Clinic Appointment CRM là hệ thống quản lý hồ sơ bệnh nhân và lịch hẹn phòng khám được thiết kế theo mô hình kiến trúc **Pure MVC (Model-View-Controller)** trong PHP. Dự án tập trung vào tính bảo mật cao, tối ưu hóa hiệu năng cơ sở dữ liệu, chống spam form đăng ký và che giấu lỗi an toàn trong môi trường Production.

---

## 📂 1. Cấu Trúc Thư Mục (Folder Structure)

Dự án tuân thủ mô hình phân tách trách nhiệm rõ ràng với cấu trúc cây thư mục như sau:

```text
php-clinic-appointment-crm-final/
├── app/                        # Thư mục ứng dụng chính (MVC)
│   ├── Controllers/            # Điều hướng request, xử lý Input/Output và chuyển hướng
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── PatientController.php
│   │   ├── PublicPatientController.php
│   │   ├── AppointmentController.php
│   │   └── HealthController.php
│   ├── Services/               # Lớp Nghiệp vụ (Business Logic) và Validate dữ liệu
│   │   ├── AuthService.php
│   │   ├── PatientService.php
│   │   └── AppointmentService.php
│   ├── Repositories/           # Lớp Truy cập CSDL (SQL queries dùng Prepared Statements)
│   │   ├── UserRepository.php
│   │   ├── PatientRepository.php
│   │   └── AppointmentRepository.php
│   └── Core/                   # Chứa hạt nhân hệ thống
│       ├── Router.php          # Định tuyến URI & phương thức HTTP
│       ├── Database.php        # Kết nối CSDL (Singleton PDO pattern)
│       ├── helpers.php         # Các hàm helper toàn cục (XSS, Session, Redirect...)
│       └── DuplicateRecordException.php
│   └── Views/                  # Giao diện hiển thị (Templates)
│       ├── layouts/            # Layout chính (main.php)
│       ├── partials/           # Các phần giao diện dùng chung (nav, flash)
│       ├── auth/               # View đăng nhập
│       ├── dashboard/          # Giao diện trang thống kê
│       ├── patients/           # Giao diện quản lý bệnh nhân (index, create, edit...)
│       ├── appointments/       # Giao diện quản lý lịch hẹn (index, create, edit...)
│       └── errors/             # Các trang hiển thị lỗi tùy chỉnh (403, 404, 405, 500)
├── config/                     # Cấu hình hệ thống
│   ├── app.php                 # Cấu hình chế độ Debug, Tên ứng dụng
│   └── database.php            # Cấu hình kết nối MySQL
├── database/                   # Cơ sở dữ liệu
│   ├── schema.sql              # Cấu trúc bảng CSDL
│   └── seed.sql                # Dữ liệu mẫu (Seed Data)
├── public/                     # Thư mục chạy công khai (Document Root)
│   ├── index.php               # Front Controller (Điểm tiếp nhận mọi request)
│   └── assets/                 # Các file tĩnh CSS/JS
├── storage/                    # Thư mục lưu trữ nội bộ
│   └── logs/                   # Chứa log lỗi chi tiết (error.log)
├── composer.json               # Cấu hình Composer & PSR-4 Autoload
└── README.md                   # Hướng dẫn dự án
```

---

## 🗄️ 2. Hướng Dẫn Tạo Cơ Sở Dữ Liệu (Database Setup)

Hệ thống sử dụng hệ quản trị cơ sở dữ liệu MySQL. Thực hiện các bước sau để cài đặt:

### Bước 1: Kiểm tra cấu hình kết nối
Mở file [config/database.php](file:///config/database.php) và cấu hình lại thông số kết nối phù hợp với môi trường máy của bạn (Host, Username, Password, Database Name).
```php
return [
    'host' => '127.0.0.1',
    'database' => 'clinic_appointment_crm',
    'username' => 'root',
    'password' => '', // Điền mật khẩu MySQL của bạn ở đây
    'charset' => 'utf8mb4',
];
```

### Bước 2: Tạo database và import cấu trúc bảng
Chạy lệnh sau trên terminal để tạo cơ sở dữ liệu và các bảng (`users`, `patients`, `appointments`):
```bash
mysql -u root -p < database/schema.sql
```
*(Nếu MySQL của bạn không cài đặt mật khẩu, hãy bỏ tham số `-p`)*

### Bước 3: Nạp dữ liệu mẫu (Seed Data)
Nạp dữ liệu người dùng thử nghiệm, danh sách bệnh nhân và các lịch hẹn mẫu:
```bash
mysql -u root -p < database/seed.sql
```

---

## 🚀 3. Cách Chạy Server (Running Server)

Dự án quản lý các thư viện bằng Composer và chạy trực tiếp thông qua Built-in Web Server của PHP:

1.  **Cài đặt các thư viện phụ thuộc (Autoload):**
    Di chuyển vào thư mục dự án và chạy lệnh cài đặt composer:
    ```bash
    composer install
    ```
2.  **Khởi chạy server nội bộ:**
    Chạy PHP web server trỏ thẳng vào thư mục `public/` (nơi chứa file `index.php` đóng vai trò Front Controller):
    ```bash
    php -S localhost:8000 -t public
    ```
3.  **Truy cập ứng dụng:**
    Mở trình duyệt web của bạn và truy cập địa chỉ:
    [http://localhost:8000](http://localhost:8000)

---

## 🔑 4. Tài Khoản Demo (Demo Accounts)

Hệ thống phân quyền truy cập thông qua cột `role` trong bảng `users`:

*   **Tài khoản Quản trị viên (Admin - Toàn quyền CRUD Bệnh nhân & Lịch hẹn):**
    *   **Username:** `admin`
    *   **Password:** `123456`
*   **Tài khoản Nhân viên (Staff - Chỉ xem danh sách Bệnh nhân/Lịch hẹn, không được Thêm/Sửa/Xóa):**
    *   **Username:** `staff1`
    *   **Password:** `123456`

---

## 🗺️ 5. Danh Sách Route (Application Routes)

Mọi yêu cầu truy cập được điều phối tập trung bởi [Router.php](file:///app/Core/Router.php) khai báo tại [public/index.php](file:///public/index.php#L86-L109):

| Phương thức | Đường dẫn (Path) | Controller & Action | Yêu cầu đăng nhập | Chức năng chi tiết |
| :--- | :--- | :--- | :---: | :--- |
| **GET** | `/` | `HomeController@index` | Không | Điều hướng về Dashboard (nếu đã login) hoặc Login |
| **GET** | `/login` | `AuthController@login` | Không | Hiển thị giao diện đăng nhập |
| **POST** | `/login` | `AuthController@handleLogin` | Không | Xử lý đăng nhập, regenerate Session ID để chống Fixation |
| **POST** | `/logout` | `AuthController@logout` | Có | Đăng xuất an toàn, xóa cookie phiên trên Client & Server |
| **GET** | `/dashboard` | `DashboardController@index` | Có | Trang tổng quan báo cáo thống kê phòng khám |
| **GET** | `/health` | `HealthController@index` | Không | Kiểm tra trạng thái hoạt động kết nối CSDL |
| **GET** | `/public-patients/create`| `PublicPatientController@create`| Không | Giao diện đăng ký khám công khai dành cho bệnh nhân mới |
| **POST** | `/public-patients` | `PublicPatientController@store` | Không | Gửi đăng ký khám (Bảo vệ bằng Honeypot & Rate Limit) |
| **GET** | `/patients` | `PatientController@index` | Có | Danh sách bệnh nhân (Tìm kiếm, phân trang, sắp xếp an toàn) |
| **GET** | `/patients/create` | `PatientController@create` | Có (Admin) | Form thêm mới hồ sơ bệnh nhân |
| **POST** | `/patients` | `PatientController@store` | Có (Admin) | Xử lý lưu thông tin bệnh nhân |
| **GET** | `/patients/edit` | `PatientController@edit` | Có (Admin) | Form chỉnh sửa hồ sơ bệnh nhân |
| **POST** | `/patients/update` | `PatientController@update` | Có (Admin) | Xử lý cập nhật thông tin bệnh nhân |
| **POST** | `/patients/delete` | `PatientController@delete` | Có (Admin) | Xóa hồ sơ bệnh nhân (Yêu cầu POST + CSRF chống crawl) |
| **GET** | `/appointments` | `AppointmentController@index` | Có | Danh sách lịch hẹn khám của phòng khám |
| **GET** | `/appointments/create`| `AppointmentController@create`| Có (Admin) | Form tạo mới lịch hẹn khám |
| **POST** | `/appointments` | `AppointmentController@store` | Có (Admin) | Xử lý lưu thông tin lịch hẹn |
| **GET** | `/appointments/edit` | `AppointmentController@edit` | Có (Admin) | Form sửa đổi thông tin lịch hẹn |
| **POST** | `/appointments/update`| `AppointmentController@update`| Có (Admin) | Xử lý cập nhật lịch hẹn khám |
| **POST** | `/appointments/delete`| `AppointmentController@delete`| Có (Admin) | Xóa lịch hẹn khám (Yêu cầu POST + CSRF) |

---

## 🛠️ 6. Lưu Ý Chế Độ Debug & Production

Hệ thống tích hợp chế độ tự động chuyển đổi hiển thị thông tin lỗi giúp bảo mật tối đa khi triển khai thực tế. Cấu hình được đặt trong file [config/app.php](file:///config/app.php):
```php
return [
    'name' => 'Clinic Appointment CRM',
    'debug' => true, // Đặt true khi viết code (Dev), đặt false khi đưa lên mạng (Prod)
];
```

### 1. Khi ở chế độ Phát triển (Development - `debug => true`)
*   **Hiển thị lỗi:** Các lỗi cú pháp PHP, lỗi kết nối SQL, biệt lệ sẽ được in chi tiết ra màn hình kèm theo **Stack Trace** (đường đi của mã nguồn) để hỗ trợ lập trình viên sửa lỗi nhanh nhất.
*   **Log:** Mọi lỗi vẫn được ghi nhận đồng thời vào file log.

### 2. Khi ở chế độ Thực tế (Production - `debug => false`)
*   **Ẩn lỗi nhạy cảm:** Hệ thống chặn hoàn toàn việc hiển thị thông báo lỗi hệ thống, mã SQLSTATE hay cấu trúc bảng ra trình duyệt. Người dùng sẽ chỉ nhìn thấy trang báo lỗi sạch **errors/500 (Internal Server Error)** với nội dung thân thiện.
*   **Ghi log an toàn:** Toàn bộ thông tin lỗi chi tiết, stack trace được chuyển hướng ghi vào file ẩn tại đường dẫn [storage/logs/error.log](file:///storage/logs/). Lập trình viên có thể mở file này trên server để chẩn đoán lỗi mà không lo rò rỉ thông tin nhạy cảm cho khách truy cập.
*   **Yêu cầu Cookie an toàn:** Hệ thống tự động thiết lập các cờ cookie phiên như `httponly => true` (chống mã Javascript đọc cookie) và `samesite => Lax` (ngăn ngừa CSRF). Ở môi trường chạy HTTPS thực tế, cờ `secure => true` cũng tự động được kích hoạt để đảm bảo cookie chỉ truyền qua giao thức mã hóa.
