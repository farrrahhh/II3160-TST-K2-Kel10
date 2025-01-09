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
    
        // Input validation
        if (!$name || !$age || !$complaint) {
            return redirect()->back()->with('error', 'All fields are required!')->withInput();
        }
    
        $url = 'http://localhost:8080/registerprocess'; // API URL
        $client = new Client();
        $postData = [
            'username' => $username,
            'password' => $password,
            'role' => 'patient',
        ];
    
        try {
            // Send data to registration API
            $response = $client->request('POST', $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $postData,
                'timeout' => 10,
            ]);
        
            if ($response->getStatusCode() == 200) {
                // Parse the JSON response from the API
                $responseData = json_decode($response->getBody()->getContents(), true);
        
                // Return the JSON response
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Registration successful',
                    'data' => $responseData // Include the API response data
                ]);
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
    
}
