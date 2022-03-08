<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Log;

class TextDetectionController extends Controller
{
    /**
     * Read text from image
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function detectText(Request $request)
    {
        Log::info('Enter in text detection function -- ' . print_r($request->all(), 1));
        $image = request('image');
        if (isset($image)) {
            $imagePath = $image->getPathName();
            $fp_image = fopen($imagePath, 'r');
            $image = fread($fp_image, filesize($imagePath));
            fclose($fp_image);

            $client = new RekognitionClient([
                'version'     => 'latest',
                'region'      => 'us-east-1',
                'credentials' => [
                    'key'    => AWS_Key,
                    'secret' => AWS_Secret
                ],
                'http'    => [
                    'verify' => false
                ]
            ]);

            $data = $client->detectText([
                'Image' => array(
                    'Bytes' => $image,
                ),
            ])['TextDetections'];

            $string = '';
            // Make a string of all words which are detected from image
            foreach ($data as $item) {
                if ($item['Type'] === 'WORD') {
                    $string .= $item['DetectedText'] . ' ';
                }
            }
        }
        return view('upload', compact('string'));
    }
}