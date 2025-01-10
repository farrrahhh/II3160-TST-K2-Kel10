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
        $diseases = $this->request->getPost('diseases[]');


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
        // Inisialisasi string spesialis
        $spesialisList = [];

        // Looping setiap disease
        foreach ($diseases as $disease) {
            switch ($disease) {
                case 'Influenza':
                    $spesialisList[] = 'umum';
                    break;
                case 'Diabetes':
                    $spesialisList[] = 'dalam';
                    break;
                case 'Hypertension':
                    $spesialisList[] = 'kardiologi';
                    break;
                case 'Maag':
                    $spesialisList[] = 'gastroenterologi';
                    break;
                default:
                    $spesialisList[] = 'umum';
                    break;
            }
        }

        // Hilangkan duplikat spesialis dan gabungkan dengan tanda "-"
        $spesialisQuery = implode('-', array_unique($spesialisList));

        // URL API
        $url = 'http://farahproject.my.id/doctor/spesialis';

        $client = new Client();

        try {
            // Kirim permintaan ke API
            $response = $client->request('GET', $url, [
                'query' => [
                    'spesialis' => $spesialisQuery,
                ],
                'timeout' => 10,
            ]);

            // Parse JSON response
            $jadwalDokter = json_decode($response->getBody()->getContents(), true);

            // Pastikan response dalam format yang diharapkan
            if (!is_array($jadwalDokter) || empty($jadwalDokter)) {
                throw new \Exception('Data jadwal dokter kosong atau tidak valid.');
            }

            // Kirim data ke view
            return view('MediMart/user/booking', [
                'jadwalDokter' => $jadwalDokter
            ]);
        } catch (\Exception $e) {
            // Log error dan kembalikan view dengan pesan error
            log_message('error', 'Error in getDoctors: ' . $e->getMessage());

            return view('MediMart/user/booking', [
                'jadwalDokter' => [],
                'error' => 'Gagal memuat jadwal dokter. Silakan coba lagi.'
            ]);
        }
    }

    
}
