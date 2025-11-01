<?php

namespace App\Helpers;

use App\Helpers\Session;

$error = Session::get('error');
$success = Session::get('success');
if ($error) {
    Session::unset('error');
}
if ($success) {
    Session::unset('success');
}

include __DIR__ . '/../layouts/header.php';
?>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="checkout container">
        <h1 class="mb-5">Thanh toán</h1>
        <div class="row">
            <div class="col-lg-6">
                <h3>Chi tiết giao hàng</h3>
                <form method="POST" action="/checkout/process" id="checkoutForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên *</label>
                        <input type="text" class="form-control form-control_md" name="fullname" id="fullname" required>
                        <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại *</label>
                        <input type="text" class="form-control form-control_md" name="phone" id="phone" required pattern="[0-9]{10,11}">
                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10-11 số).</div>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">Tỉnh/Thành phố *</label>
                        <select class="form-control form-control_md" name="state" id="state" required>
                            <option value="">Đang tải danh sách...</option>
                        </select>
                        <input type="hidden" name="state_name" id="state_name">
                        <div class="invalid-feedback">Vui lòng chọn tỉnh/thành phố.</div>
                    </div>
                    <div class="mb-3">
                        <label for="town_city" class="form-label">Quận/Huyện *</label>
                        <select class="form-control form-control_md" name="town_city" id="town_city" required disabled>
                            <option value="">Chọn tỉnh/thành phố trước</option>
                        </select>
                        <input type="hidden" name="town_city_name" id="town_city_name">
                        <div class="invalid-feedback">Vui lòng chọn quận/huyện.</div>
                    </div>
                    <div class="mb-3">
                        <label for="ward" class="form-label">Phường/Xã</label>
                        <select class="form-control form-control_md" name="ward" id="ward" disabled>
                            <option value="">Chọn quận/huyện trước</option>
                        </select>
                        <input type="hidden" name="ward_name" id="ward_name">
                    </div>
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Mã bưu điện *</label>
                        <input type="text" class="form-control form-control_md" name="pincode" id="pincode" required>
                        <div class="invalid-feedback">Vui lòng nhập mã bưu điện.</div>
                    </div>
                    <div class="mb-3">
                        <label for="house_no" class="form-label">Số nhà, Tên tòa nhà *</label>
                        <input type="text" class="form-control form-control_md" name="house_no" id="house_no" required>
                        <div class="invalid-feedback">Vui lòng nhập số nhà.</div>
                    </div>
                    <div class="mb-3">
                        <label for="road_name" class="form-label">Tên đường, Khu vực *</label>
                        <input type="text" class="form-control form-control_md" name="road_name" id="road_name" required>
                        <div class="invalid-feedback">Vui lòng nhập tên đường.</div>
                    </div>
                
                </div>
                <div class="col-lg-6">
                    <h3>Đơn hàng của bạn</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = 0;
                            foreach ($cartItems as $item):
                                $itemSubtotal = $item['price'] * $item['quantity'];
                                $itemVat = $itemSubtotal * 0.1;
                                $itemTotal = $itemSubtotal + $itemVat;
                                $subtotal += $itemTotal;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['title']) ?> x <?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($itemTotal, 0) ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tổng cộng</th>
                                <td><?= number_format($subtotal, 0) ?> VND</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment_method" value="cod" id="cod" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng</label>
                            <p>Thanh toán bằng tiền mặt khi nhận hàng.</p>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment_method" value="payos" id="payos">
                            <label class="form-check-label" for="payos">PayOS</label>
                            <p>Thanh toán trực tuyến qua PayOS.</p>
                        </div>
                    </div>
                    <p>Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm trên website này, và các mục đích khác được mô tả trong chính sách bảo mật của chúng tôi.</p>
                    <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>
                </form>
            </div>
        </div>
    </section>
</main>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/plugins/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // API Base URL
    const API_BASE = 'https://provinces.open-api.vn/api/';

    // Cache cho dữ liệu API
    const cache = {
        provinces: null,
        districts: {},
        wards: {}
    };

    // Hàm fetch dữ liệu từ API với cache
    async function fetchData(endpoint, cacheKey = null) {
        if (cacheKey && cache[cacheKey]) {
            return cache[cacheKey];
        }

        try {
            const response = await fetch(`${API_BASE}${endpoint}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (cacheKey) {
                cache[cacheKey] = data;
            }
            return data;
        } catch (error) {
            console.error('Lỗi khi tải dữ liệu:', error);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Không thể tải dữ liệu địa chỉ. Vui lòng thử lại sau.',
                confirmButtonText: 'OK'
            });
            return null;
        }
    }

    // Khởi tạo dropdown tỉnh/thành phố
    async function initProvinces() {
        const stateSelect = document.getElementById('state');
        const stateNameInput = document.getElementById('state_name');
        const data = await fetchData('p/', 'provinces');
        
        if (data && Array.isArray(data)) {
            stateSelect.innerHTML = '<option value="">Chọn tỉnh/thành phố</option>';
            data.forEach(province => {
                const option = document.createElement('option');
                option.value = province.code;
                option.textContent = province.name;
                stateSelect.appendChild(option);
            });
            stateSelect.disabled = false;
        } else {
            stateSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
            stateSelect.disabled = true;
        }
    }

    // Cập nhật dropdown quận/huyện dựa trên tỉnh
    async function updateDistricts(provinceCode) {
        const townCitySelect = document.getElementById('town_city');
        const townCityNameInput = document.getElementById('town_city_name');
        const wardSelect = document.getElementById('ward');
        const wardNameInput = document.getElementById('ward_name');

        // Reset
        townCitySelect.innerHTML = '<option value="">Đang tải quận/huyện...</option>';
        wardSelect.innerHTML = '<option value="">Chọn quận/huyện trước</option>';
        townCitySelect.disabled = true;
        wardSelect.disabled = true;

        if (!provinceCode) {
            townCitySelect.innerHTML = '<option value="">Chọn tỉnh/thành phố trước</option>';
            return;
        }

        const data = await fetchData(`p/${provinceCode}?depth=2`, `districts_${provinceCode}`);
        if (data && data.districts && Array.isArray(data.districts)) {
            townCitySelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
            data.districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.code;
                option.textContent = district.name;
                townCitySelect.appendChild(option);
            });
            townCitySelect.disabled = false;
        } else {
            townCitySelect.innerHTML = '<option value="">Không có quận/huyện</option>';
        }
    }

    // Cập nhật dropdown phường/xã dựa trên quận/huyện
    async function updateWards(districtCode) {
        const wardSelect = document.getElementById('ward');
        const wardNameInput = document.getElementById('ward_name');

        // Reset
        wardSelect.innerHTML = '<option value="">Đang tải phường/xã...</option>';
        wardSelect.disabled = true;

        if (!districtCode) {
            wardSelect.innerHTML = '<option value="">Chọn quận/huyện trước</option>';
            return;
        }

        const data = await fetchData(`d/${districtCode}?depth=2`, `wards_${districtCode}`);
        if (data && data.wards && Array.isArray(data.wards)) {
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
            data.wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.code;
                option.textContent = ward.name;
                wardSelect.appendChild(option);
            });
            wardSelect.disabled = false;
        } else {
            wardSelect.innerHTML = '<option value="">Không có phường/xã</option>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');
        const stateSelect = document.getElementById('state');
        const stateNameInput = document.getElementById('state_name');
        const townCitySelect = document.getElementById('town_city');
        const townCityNameInput = document.getElementById('town_city_name');
        const wardSelect = document.getElementById('ward');
        const wardNameInput = document.getElementById('ward_name');

        // Khởi tạo tỉnh/thành phố
        initProvinces();

        // Cập nhật tên tỉnh/thành phố khi chọn
        stateSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            stateNameInput.value = selectedOption ? selectedOption.textContent : '';
            updateDistricts(this.value);
        });

        // Cập nhật tên quận/huyện khi chọn
        townCitySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            townCityNameInput.value = selectedOption ? selectedOption.textContent : '';
            updateWards(this.value);
        });

        // Cập nhật tên phường/xã khi chọn
        wardSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            wardNameInput.value = selectedOption ? selectedOption.textContent : '';
        });

        // Xác thực form
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                form.classList.add('was-validated');
                return;
            }
        });

        <?php if ($error): ?>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '<?= htmlspecialchars($error) ?>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
        <?php if ($success): ?>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '<?= htmlspecialchars($success) ?>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                timer: 2000,
                timerProgressBar: true
            });
        <?php endif; ?>
    });
</script>

<?php
include __DIR__ . '/../layouts/footer.php';
?>