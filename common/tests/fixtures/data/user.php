<?php

use common\models\constant\UserRolesConstant;

return [
    [
        'id' => 1,
        'username' => 'admin',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'Administrator',
        'email' => 'ngocatp.52@gmail.com',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => null,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::ADMIN,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
    [
        'id' => 2,
        'username' => 'qamanager1',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'QA Manager 1',
        'email' => 'ngocdmgch211114@fpt.edu.vn',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => null,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::QA_MANAGER,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
    [
        'id' => 3,
        'username' => 'qacoordinator1',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'QA Coordinator 1',
        'email' => 'ngocdmbhaf180239@fpt.edu.vn',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => 1,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::QA_COORDINATOR,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
    [
        'id' => 4,
        'username' => 'staff1',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'Staff 1',
        'email' => 'enterprise.project.2702@gmail.com',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => 1,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::STAFF,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
    [
        'id' => 5,
        'username' => 'qacoordinator2',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'QA Coordinator 2',
        'email' => 'abc@gmail',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => 2,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::QA_COORDINATOR,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
    [
        'id' => 6,
        'username' => 'staff2',
        'password' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'full_name' => 'Staff 2',
        'email' => 'def@gmail.com',
        'dob' => '20/10/2010',
        'phone_number' => '0941900193',
        'avatar' => null,
        'address' => 'Hà Nội',
        'departmentId' => 2,
        'auth_key' => '$2y$13$iTkZeIYcbrCwQxVLnpueneajQUrIJZG2kntbzDOTGyEX2hV973Nkq',
        'status' => 1,
        'role' => UserRolesConstant::STAFF,
        'created_at' => '1681510796',
        'created_by' => 'admin',
        'updated_at' => null,
        'updated_by' => null,
    ],
];