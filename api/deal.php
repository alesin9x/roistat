<?php
const API_URL = "https://aalesin.amocrm.ru/api/v4/leads";
// 01.09.2024
const LONG_TIME_TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUwMDcwMjVhMGQzMWViZDY0NzU5YTdkNmZmZTQwMTA2M2EwYjI5NjkzODg3OTQyZjZjMjI4ZWVlNzQ0OTIyMTljNTExM2IyYjM0OGFlZWFkIn0.eyJhdWQiOiI2OWU0NWUzZC04NWY2LTQyZTctODZjMi0zMzI2MzNhODA2MTgiLCJqdGkiOiI1MDA3MDI1YTBkMzFlYmQ2NDc1OWE3ZDZmZmU0MDEwNjNhMGIyOTY5Mzg4Nzk0MmY2YzIyOGVlZTc0NDkyMjE5YzUxMTNiMmIzNDhhZWVhZCIsImlhdCI6MTcyMTIxODQ2MCwibmJmIjoxNzIxMjE4NDYwLCJleHAiOjE3MjUxNDg4MDAsInN1YiI6IjExMjg0Mzk4IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxODUzMjA2LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiZmFiMWRiOTktYjk4OS00OGRlLTk3ZDctZWU5ZTQ5ZjFkY2IxIn0.jjPOtgaaAoW0MdawDkkDLArhJvrK1y5vW8oxRupFWXgUFzXgEbre23l_Cqc56S_RU0ZYAWRmwaFJcDqrZB3lLZ3hQoQpHxj5qTg9jmOLXrR3sg3_ts9yTFoUSXa5WEo4e1iDfmI_lcAUww0ZwqJhKPsELObmvQCkPGW-0ktpLYVM3CY4PHd-2Egf32ZvY9z5aOZxtL_bCewXHy7rpYaLblPv5du7Bojadg-oZGmhYA029Djd5hv1pMnlGH9DrLEkCFHcetWe7v9kIkRKFyiH2wzd5xgEjutP0e9tSnbip10q5Ffibzfs4DbIxzwpVcQGDp3W2QovnEA7fywY5jxZCA";
const CUSTOM_FIELD_ID = 740733;
if (empty($post = file_get_contents('php://input'))) {
    die();
}
$post = json_decode($post, true);

$output = ['success' => true];
try {
    preparePostData($post);
    $body = [];
    $boolean = $post['boolean'] == 1 ? 'true' : 'false';
    unset($post['boolean']);
    $post['custom_fields_values'][] = [
        'field_id' => CUSTOM_FIELD_ID,
        'values' => [
            [
                'value' => strval($boolean) 
            ]
        ]
    ];
    $body[] = $post;
    $res = sendData(json_encode($body, JSON_NUMERIC_CHECK));
    
    die(json_encode(compact('res', 'boolean', 'body'), JSON_NUMERIC_CHECK));
} catch (Exception $e) {
    $output = ['success' => false, 'e' => $e->getMessage()];
}

echo json_encode($output);

function preparePostData($post)
{
    $needle = ['name', 'email', 'telephone', 'price', 'boolean'];
    foreach ($needle as $key) {
        if (!isset($post[$key])) {
            throw new Exception('Missing key: ' . $key);
        }
    }
    $post['price'] = (int) $post['price'];
    return $post;
}


function sendData($post)
{
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . LONG_TIME_TOKEN,
                'Cookie: session_id=uje6l207u64ir3cj7k9qos6hcb; user_lang=ru; csrf_token=def502003d4fbd7d21fb370c08a541cffb5142dd5ed9896979a09cd11caa3616eb648b5619311758674688b44d652597c88679e211c11b7ec705a39b0a931b7a236ab8b0bbc970f0ba5f639f563331f7ddd73bde1ce939512ca406b9c764abc5e00c9d6e04b7dfbcbbc47234150a796b03755430a622af127455dfdd44197b786784bca87ed820b69f2fd048b750906426d8a6dfbcfc94e9485e2a09f1b17d197c86dbea182d060030981c93de0c628318fdaff03214404504cfa7ec9e241c5eee9f7ba63e421ade98c95b3427c035943d47d6686fc95f455026047ec0350d6135260d7f2b504290d8b62bddcc90d27f2e2ea1654150118246421d0ca292e3d3812fe2987bf8e03755f65c'
            ),
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}