<?php

namespace App\Controllers;

use GuzzleHttp\Client;

class EasyDiagnoseController extends BaseController
{
    public function submit()
    {
        $name = $this->request->getPost('name');
        $age = $this->request->getPost('age');
        $complaint = $this->request->getPost('complaint');
        $password = 'password123';  
        $username = $this->generateUsername($name);
        $diseases = $this->request->getPost('diseases');


        // Pastikan diseases adalah array
        if (is_string($diseases)) {
            // Jika data dalam format JSON
            $decoded = json_decode($diseases, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $diseases = $decoded;
            } else {
                // Jika data dipisahkan dengan koma
                $diseases = explode(',', $diseases);
            }
        }

   
        // Input validation
        if (!$name || !$age || !$complaint) {
            return redirect()->back()->with('error', 'All fields are required!')->withInput();
        }
    
        $url = 'http://farahproject.my.id/registerprocess'; // API URL
        $client = new Client();
    
        try {
            // Send data to registration API
            $response = $client->request('POST', $url, [
                // x-www-form-urlencoded
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'role' => 'patient',
                ],
                
                'timeout' => 10,
            ]);
        
            if ($response->getStatusCode() == 200) {
                // Parse the JSON response from the API
                $responseData = json_decode($response->getBody()->getContents(), true);

                // save into session user id
                session()->set('id', $responseData['user_id']);

                

                $url = 'http://farahproject.my.id/patient/save-patient-process'; // API URL

                // Data to be sent to the API
                $postData = [
                    'userId' => $responseData['user_id'],
                    'nama' => $name,
                    'usia' => $age,
                    'keluhan_penyakit' => $complaint,
                ];

                // Send data to the API
                $response = $client->request('POST', $url, [
                    'form_params' => $postData,
                    'timeout' => 10,
                ]);

                if ($response->getStatusCode() == 200) {

                    
                    // panggil method getDoctors
                    $doctors = $this->getDoctors($diseases);
                } else {
                    
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Registration failed!',
                    ]);

                }


            } else {
                // Return error in JSON format
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Registration failed!',
                ]);
            }
        } catch (\Exception $e) {
            // Return exception error in JSON format
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
        
    }
    
    private function generateUsername($name)
    {
        // Generate a random username based on the name and random digits
        return strtolower(str_replace(' ', '', $name)) . rand(1000, 9999);
    }


    private function getDoctors(array $diseases)
    {   
        
        // Inisialisasi string penyakit
        $diseaseString = '';
        // Inisialisasi string hasil akhir
        $resultString = '';

        // Looping setiap disease
        foreach ($diseases as $disease) {
            // Menentukan string berdasarkan disease
            if ($disease == 'Influenza') {
                $diseaseString = 'umum';
            } elseif ($disease == 'Diabetes') {
                $diseaseString = 'dalam';
            } elseif ($disease == 'Hypertension') {
                $diseaseString = 'kardiologi';
            } elseif ($disease == 'Maag') {
                $diseaseString = 'gastroenterologi';
            }
            else {
                $diseaseString = 'umum';
            }

            // Tambahkan ke resultString dengan separator "-"
            if ($resultString === '') {
                // Jika resultString kosong, langsung tambahkan
                $resultString = $diseaseString;
            } else {
                // Jika tidak, tambahkan dengan tanda strip
                $resultString .= '-' . $diseaseString;
            }
        }

        
        // Menggunakan concatenation untuk memasukkan resultString ke URL
        $url = 'http://farahproject.my.id/doctor/spesialis/' . $resultString;
        $client = new Client();
    
        try {
            // Send request to the API
            $response = $client->request('GET', $url, [
                'timeout' => 10,
            ]);
        
            if ($response->getStatusCode() == 200) {
                // return json 
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data dokter berhasil diambil.',
                    'data' => json_decode($response->getBody()->getContents(), true),
                ]);
            } else {
                // Return an empty array if the request failed
                return [];
            }
        } catch (\Exception $e) {
            // Return an empty array if an exception occurred
            return [];
        }
    }
    
}
