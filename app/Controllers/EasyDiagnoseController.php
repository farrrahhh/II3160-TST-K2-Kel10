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

        // Ensure diseases is an array
        if (is_string($diseases)) {
            // If data is in JSON format
            $decoded = json_decode($diseases, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $diseases = $decoded;
            } else {
                // If data is comma-separated
                $diseases = explode(',', $diseases);
            }
        }

        // Input validation
        if (!$name || !$age || !$complaint) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required!',
            ]);
        }
    
        $url = 'http://farahproject.my.id/registerprocess'; // API URL
        $client = new Client();
    
        try {
            // Send data to registration API
            $response = $client->request('POST', $url, [
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

                // Save user ID into session
                session()->set('id', $responseData['user_id']);

                // Prepare data for the second API call
                $url = 'http://farahproject.my.id/patient/save-patient-process'; // API URL
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
                    // Call getDoctors method
                    $doctors = $this->getDoctors($diseases);
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Registration and patient save successful!',
                        'data' => $doctors,
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Patient data save failed!',
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Registration failed!',
                ]);
            }
        } catch (\Exception $e) {
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
        // Initialize specialist list
        $spesialisList = [];

        // Loop through each disease
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

        // Remove duplicates and join with "-"
        $spesialisQuery = implode('-', array_unique($spesialisList));

        // API URL for doctors
        $url = 'http://farahproject.my.id/doctor/spesialis';

        $client = new Client();

        try {
            // Send GET request for doctors based on specialties
           // Fetch the doctor schedule API response
            // Send the request to the API
            $response = $client->request('GET', $url, [
                'query' => ['spesialis' => $spesialisQuery],
                'timeout' => 10,
            ]);

            // Parse JSON response
            $jadwalDokter = json_decode($response->getBody()->getContents(), true);

            if (!is_array($jadwalDokter) || empty($jadwalDokter)) {
                throw new \Exception('Doctor schedule data is empty or invalid.');
            }

            // return to view booking with parsing data jadwaldokter
            return view('MediMart/user/booking', ['jadwalDokter' => $jadwalDokter]);

        } catch (\Exception $e) {
            log_message('error', 'Error in getDoctors: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Failed to load doctor schedule. Please try again.',
            ];
        }
    }
}
