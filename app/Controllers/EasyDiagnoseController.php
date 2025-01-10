<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EasyDiagnoseController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'base_uri' => 'http://farahproject.my.id/',
        ]);
    }

    public function submit()
    {
        $rules = [
            'name' => 'required',
            'age' => 'required|numeric',
            'complaint' => 'required',
            'diseases' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('errors/html/error_validation', ['errors' => $this->validator->getErrors()]);
        }

        $name = $this->request->getPost('name');
        $age = $this->request->getPost('age');
        $complaint = $this->request->getPost('complaint');
        $diseases = $this->parseDiseases($this->request->getPost('diseases'));

        $username = $this->generateUsername($name);
        $password = 'password123'; // Consider using a more secure password generation method

        try {
            $userId = $this->registerUser($username, $password);
            $this->savePatientData($userId, $name, $age, $complaint);
            $doctors = $this->getDoctors($diseases);
            session()->setFlashdata('doctors', $doctors);
            return redirect()->to('/MediMart/booking');
            
        } catch (\Exception $e) {
            // return json response for API
            return $this->response->setJSON(['error' => $e->getMessage()]);
            
        }
    }

    private function parseDiseases($diseases)
    {
        if (is_string($diseases)) {
            $decoded = json_decode($diseases, true);
            return (json_last_error() === JSON_ERROR_NONE) ? $decoded : explode(',', $diseases);
        }
        return $diseases;
    }

    private function generateUsername(string $name): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name)) . rand(1000, 9999);
    }

    private function registerUser(string $username, string $password): int
    {
        try {
            $response = $this->client->post('registerprocess', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'role' => 'patient',
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            session()->set('id', $responseData['user_id']);
            return $responseData['user_id'];
        } catch (GuzzleException $e) {
            throw new \Exception('Registration failed: ' . $e->getMessage());
        }
    }

    private function savePatientData(int $userId, string $name, int $age, string $complaint): void
    {
        try {
            $this->client->post('patient/save-patient-process', [
                'form_params' => [
                    'userId' => $userId,
                    'nama' => $name,
                    'usia' => $age,
                    'keluhan_penyakit' => $complaint,
                ],
            ]);
        } catch (GuzzleException $e) {
            throw new \Exception('Patient data save failed: ' . $e->getMessage());
        }
    }

    private function getDoctors(array $diseases): array
    {
        $specialistMap = [
            'Influenza' => 'umum',
            'Diabetes' => 'dalam',
            'Hypertension' => 'kardiologi',
            'Maag' => 'gastroenterologi',
        ];

        $specialists = array_unique(array_map(function($disease) use ($specialistMap) {
            return $specialistMap[$disease] ?? 'umum';
        }, $diseases));

        $specialistsQuery = implode('-', $specialists);

        try {
            $response = $this->client->get('doctor/spesialis', [
                'query' => ['spesialis' => $specialistsQuery],
            ]);

            $doctorSchedule = json_decode($response->getBody()->getContents(), true);

            if (!is_array($doctorSchedule) || empty($doctorSchedule)) {
                throw new \Exception('Doctor schedule data is empty or invalid.');
            }

            return $doctorSchedule;
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to load doctor schedule: ' . $e->getMessage());
        }
    }
}