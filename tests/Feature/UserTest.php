<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class UserTest extends TestCase
{
    public function testRegisterSuccess(): void
    {
        $this->postJson('/api/users/regiter', [
            'name' => 'Muhammad Fazri',
            'foto_karyawan' => 'photo_2023-10-24_21-19-02.jpg',
            'email' => 'muhamadfazri0702@gmail.com',
            'telepon' => '08515822110',
            'username' => 'fazriis',
            'password' => 'password',
            'tgl_lahir' => '2001-02-07',
            'gender' => 'Male',
            'tgl_join' => '2023-10-25',
            'status_nikah' => 'single',
            'alamat' => 'Kp.Pasir Angin Gadog',
            'cuti_dadakan' => '1',
            'cuti_bersama' => '2',
            'cuti_menikah' => '3',
            'cuti_diluar_tanggungan' => '4',
            'cuti_khusus' => '5',
            'cuti_melahirkan' => '6',
            'izin_telat' => '7',
            'izin_pulang_cepat' => '8',
            'is_admin' => 'user',
            'jabatan_id' => 2,
            'lokasi_id' => 1
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'name' => 'Muhammad Fazri',
                    'foto_karyawan' => 'photo_2023-10-24_21-19-02.jpg',
                    'email' => 'muhamadfazri0702@gmail.com',
                    'telepon' => '08515822110',
                    'username' => 'fazriis',
                    'tgl_lahir' => '2001-02-07',
                    'gender' => 'Male',
                    'tgl_join' => '2023-10-25',
                    'status_nikah' => 'single',
                    'alamat' => 'Kp.Pasir Angin Gadog',
                    'cuti_dadakan' => '1',
                    'cuti_bersama' => '2',
                    'cuti_menikah' => '3',
                    'cuti_diluar_tanggungan' => '4',
                    'cuti_khusus' => '5',
                    'cuti_melahirkan' => '6',
                    'izin_telat' => '7',
                    'izin_pulang_cepat' => '8',
                    'is_admin' => 'user',
                    'jabatan_id' => 2,
                    'lokasi_id' => 1
                ]
            ]);
            
    }

    public function testRegisterFailed()
    {

    }

    public function testRegisterUsernameExist(){

    }
}
