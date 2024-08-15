<?php
namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    public function requestPreview(Request $request)
    {
        $data = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|',
            'products.*.values'=>'required|array',
            'products.*.values.*.length' => 'required|numeric',
            'products.*.values.*.width' => 'required|numeric',
            // 'count'=>'required',
            //'products.*.additional_features' => 'array',
        ]);

        $previewData = [];
      //  dd($request);
        foreach ($data['products'] as $product) {
            $previewData2=[];
            $product_id = $product['product_id'];
            

            $maxLength = Price::where('product_id', $product_id)->max('length');
            $maxWidth = Price::where('product_id', $product_id)->max('width');

            foreach ($product['values'] as $dimensions) {

                $length = $dimensions['length'];
                $width = $dimensions['width'];


                list($systems, $count)=$this->divideIntoEqualSystems($length, $width, $maxLength, $maxWidth);
                 
                

                $previewData2[] = [
                    'length' => $length,
                    'width' => $width,
                    'count' => $count,
                    'systems'=>$systems,
                   
                ];
            }
            $previewData[] = [
                'product_id' => $product_id,
                'dimensions' => $previewData2
            ];
        }
        return response()->json([
            'products' => $previewData,
        ]);
    }
    private function divideIntoEqualSystems($length, $width, $maxLength, $maxWidth)
    {
        
        $numSystemsLength = ceil($length / $maxLength);
        $numSystemsWidth = ceil($width / $maxWidth);
        
        $total_systems = 0;
        if ($numSystemsLength > 1 ){
            $total_systems += $numSystemsLength;
            $systemLength = $length / $numSystemsLength;
            $systemWidth = $width;
            // for ($i = 0; $i < $numSystemsLength; $i++) {
                $systems[] = [
                    'length' => $systemLength,
                    'width' => $systemWidth,
                ];
                
            // }
            if($numSystemsWidth>1){
                $total_systems *= $numSystemsWidth;
                // foreach($systems as $system){
                    $systemWidth =$systems[0]['width']/$numSystemsWidth;
                    // for ($i = 0; $i < $numSystemsWidth; $i++) {
                        $newSystems[] = [
                            'length' => $systemLength,
                            'width' => $systemWidth,
                        ];
                    // }
                    
                // }
                $systems = [];
                $systems = $newSystems;
               
                return [$systems, $total_systems];
            }
            else{
                return [$systems, $total_systems];
            }
        }elseif($numSystemsWidth > 1){
           
            $total_systems += $numSystemsWidth;
            $systemLength = $length ;
            $systemWidth = $width/ $numSystemsWidth;
            // for ($i = 0; $i < $numSystemsWidth; $i++) {
                $systems[] = [
                    'length' => $systemLength,
                    'width' => $systemWidth,
                ];
            // }
            
            return [$systems, $total_systems];
            
        }else{
            $systems[] = [
                'length' => $length,
                'width' => $width,
            ];
    
            return [$systems, 1];
        }
        
    
    }

    private function calculateSystemPrice($product_id, $length, $width)
    {
        // یافتن نزدیک‌ترین طول و عرض
        $closestLength = Price::where('product_id', $product_id)
            ->orderByRaw("ABS(length - $length)")
            ->first()->length;

        $closestWidth = Price::where('product_id', $product_id)
            ->orderByRaw("ABS(width - $width)")
            ->first()->width;

        // یافتن قیمت برای نزدیک‌ترین طول و عرض
        $closestPrice = Price::where('product_id', $product_id)
            ->where('length', $closestLength)
            ->where('width', $closestWidth)
            ->first();

        if (!$closestPrice) {
            throw new \Exception('No price found for the given dimensions.');
        }

        return $closestPrice->price;
    }

    

    private function calculateAdditionalFeaturesCost($product)
    {
        $additionalCost = 0;

        if (isset($product['additional_features']['motor'])) {
            $motorType = $product['additional_features']['motor'];
            if ($motorType == 'high_power') {
                $additionalCost += 200; 
            } elseif ($motorType == 'standard') {
                $additionalCost += 100; 
            }
        }

        return $additionalCost;
    }

    private function getAdditionalFeaturesDetails($additionalFeatures)
    {
        $details = [];

        if (isset($additionalFeatures['motor'])) {
            $motorType = $additionalFeatures['motor'];
            $cost = 0;
            if ($motorType == 'high_power') {
                $cost = 200;
            } elseif ($motorType == 'standard') {
                $cost = 100;
            }

            $details['motor'] = [
                'type' => $motorType,
                'cost' => $cost
            ];
        }

        return $details;
    }
}
