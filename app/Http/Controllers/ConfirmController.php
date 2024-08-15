<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductOrder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;
use App\Models\Price;
use Mpdf\Mpdf;
use Illuminate\Support\Str;

class ConfirmController extends Controller
{
    
    public function confirmDetails(Request $request)
    { 
        $data = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|numeric',
            'products.*.dimensions.*.length' => 'required|numeric',
            'products.*.dimensions.*.width' => 'required|numeric',
            'products.*.dimensions.*.count' => 'required|numeric',
            'products.*.dimensions.*.system' => 'required|array',
            'products.*.area' => 'required|numeric',
            'products.*.color' => 'required|numeric',
            'products.*.light' => 'numeric',
            'products.*.dimensions.*.customs' => 'required|array',
            'name' => 'required|string',
            'phone' => 'required|string',
            'company' => 'string',
        ]);

        
        //  foreach ($data['products'] as $product) {
        //     // $productOrder = ProductOrder::create([
        //     //     'order_id' => $order->id,
        //     //     'product_id' => $product['product_id'],
        //     //     'length' => $product['length'],
        //     //     'width' => $product['width'],
        //     //     'area' => $product['area'],
        //     //     'total_cost' => $product['total_cost'],
        //     // ]);
        // $data = [
        //     "name"=>"mohsen",
        //     "phone"=>"09035900509",
        //     "company"=>"sayeroshan",
        //     "products" => [
        //         [
        //             "product_id" => 1,
        //             "dimensions" => [
        //                 [
        //                     "length" => 8000,
        //                     "width" => 1500,
        //                     "light"=>"اکریلیک نقطه‌ای",
        //                     "count" => 4,
        //                     "systems" => [
        //                         [
        //                             "length" => 2000,
        //                             "width" => 1500
        //                         ]
        //                     ],
        //                     "customs" => [
        //                         [
        //                             "engine" => "becker",
        //                             "type" => "Roof Level"
        //                         ]
        //                     ]
                        
        //                 ],
        //                 [
        //                     "length" => 8000,
        //                     "width" => 1500,
        //                     "light"=>"اکریلیک نقطه‌ای",
        //                     "count" => 4,
        //                     "systems" => [
        //                         [
        //                             "length" => 1500,
        //                             "width" => 2000
        //                         ]
        //                     ],
        //                     "customs" => [
        //                         [
        //                             "engine" => "becker",
        //                             "type" => "Roof Level"
        //                         ]
        //                     ]
                        
        //                 ]                           
        //             ]
        //         ]
        //     ]
        // ];

        foreach ($data['products'] as $product) {
            

            $product_id = $product['product_id'];
            $systems=[];
            switch ($product_id) {
                case 1 :
                    
                    $filePath = public_path('excel/Fabric_roof.xlsx');
                    $invoiceNumber = 'INV-' . date('Ymd') . '-' . Str::random(6);
                    $newFileName = "Fabric_roof_{$invoiceNumber}.xlsx";
                    
                    // مسیر فایل جدید
                    $tempPath = public_path("excel/{$newFileName}");
                    

                    File::copy($filePath, $tempPath);
                    
                    
    
                    $nextRow = 12;
                    $row=15;
                    $total=0;
                    foreach($product['dimensions'] as $dimension){
                        if ($product_id == 1) {

                            foreach ($dimension['systems'] as $system) {
                                // dd($system);
                                foreach ($dimension['customs'] as $custom) {
                                    $engine = $custom['engine'];
                                    $type = $custom['type'];
                                }
                                // if($row == 20){
                                //     dd($engine , $type , $system);
                                // }
                                $length = $system['length'];
                                $width = $system['width'];
                                
                                $spreadsheet = IOFactory::load($tempPath);
    
                    
                                $sheet = $spreadsheet->getSheetByName('پیش فاکتور سقف متحرک');

                                
                                
                                $sheet->setCellValue('B' . $nextRow , $length);
                                $sheet->setCellValue('C' . $nextRow, $width);
                                $sheet->setCellValue('D' . $nextRow , $dimension['count']);
                                $sheet->setCellValue('H' . '17' , $dimension['light']);
                                if($type=="Roof Level"){
                                    $sheet->setCellValue('E' . $nextRow, 'Roof Level');
                                }elseif ($type=="Sayaneh") {
                                    $sheet->setCellValue('E' . $nextRow, 'Sayaneh');
                                }elseif ($type=="Pavlion") {
                                    $sheet->setCellValue('E' . $nextRow, 'Pavlion');
                                }elseif("Mah Sayeh"){
                                    $sheet->setCellValue('E' . $nextRow, 'Sayaneh');
                                    $sheet->setCellValue('F' . $nextRow, 'Mah Sayeh');
                                }elseif ($type=="Atin") {
                                    $sheet->setCellValue('E' . $nextRow, 'Pavlion');
                                    $sheet->setCellValue('F' . $nextRow, 'Atin');
                                }
                                elseif ($type=="Horno") {
                                    $sheet->setCellValue('E' . $nextRow, 'Pavlion');
                                    $sheet->setCellValue('F' . $nextRow, 'Horno');
                                }

                                if($engine == "becker"){
                                    $sheet->setCellValue('G' . $nextRow , '120Nm بکر آلمان ');
                                }elseif($engine == "somfy"){
                                    $sheet->setCellValue('G' . $nextRow , '120Nm  سامفی فرانسه ');
                                }elseif($engine == "saye-roshan"){
                                    $sheet->setCellValue('G' . $nextRow , 'اختصاصی سایه روشن 120Nm');
                                }

                                
                                
                                
                                $area = $sheet->getCell('R' . $row)->getCalculatedValue();
                                $unit_price = $sheet->getCell('T' . $row)->getCalculatedValue();
                                $total_price = $sheet->getCell('U' . $row)->getCalculatedValue();
                                $light_price = $sheet->getCell('U33')->getCalculatedValue();
                                
                                
                                $final_price =  $light_price +$total_price;
                                $systems[] = [
                                    'length' => $length,
                                    'width' => $width,
                                    'price'=>$total_price,
                                    'light_price'=>$light_price,
                                    'final_price'=>$final_price,
                                    'unit_price'=> $unit_price,
                                    'count'=>$dimension['count'],
                                    'area'=>$area
                                ];
                                
                                
                                $nextRow++;
                                
                                if($nextRow == 13){
                                    $row= $row+5;
                                }else{
                                    $row = $row +3 ; 
                                }
                                
                                
                            }
                        }
                        
                    }
                    File::delete($tempPath); 
                    break;   
                
                case 2:
                    
                    $filePath = public_path('excel/Al_roof.xlsx');
                    $tempPath = public_path('excel/Al_roof_temp.xlsx');
                    

                    File::copy($filePath, $tempPath);
                    
                    

    
                    $nextRow = 12;
                    $row=15;
                    
                    $total=0;
                    foreach($product['dimensions'] as $dimension){
                        
                            foreach ($dimension['systems'] as $system) {
                                // dd($system);
                                foreach ($dimension['customs'] as $custom) {
                                    $engine = $custom['engine'];
                                    $type = $custom['type'];
                                }
                                $spreadsheet = IOFactory::load($tempPath);
    
                    
                                $sheet = $spreadsheet->getSheetByName('Invoice');
                                $length = $system['length'];
                                $width = $system['width'];
                                
                                
                                if($row!=12){
                                    dd($width);
                                }

                                
                                $sheet->setCellValue('C' . $nextRow , $length);
                                $sheet->setCellValue('D' . $nextRow, $width);
                                $sheet->setCellValue('E' . $nextRow , $dimension['count']);
                                $sheet->setCellValue('H' . '12' , $dimension['light']);
                                if($type=="Roof Level"){
                                    $sheet->setCellValue('F' . $nextRow, 'Roof Level');
                                }elseif ($type=="Sayaneh") {
                                    $sheet->setCellValue('F' . $nextRow, 'Sayaneh');
                                }elseif ($type=="Pavlion") {
                                    $sheet->setCellValue('F' . $nextRow, 'Pavlion');
                                }

                                if($engine == "becker"){
                                    $sheet->setCellValue('G' . '18' , '120Nm بکر آلمان ');
                                }elseif($engine == "somfy"){
                                    $sheet->setCellValue('G' . '18' , '120Nm  سامفی فرانسه ');
                                }elseif($engine == "saye-roshan"){
                                    $sheet->setCellValue('G' . '18' , 'اختصاصی سایه روشن 120Nm');
                                }

                                
                                
                                
                                $area = $sheet->getCell('R' . $row)->getCalculatedValue();
                                $unit_price = $sheet->getCell('T' . $row)->getCalculatedValue();
                                $total_price = $sheet->getCell('U' . $row)->getCalculatedValue();
                                $light_price_1 = $sheet->getCell('U29')->getCalculatedValue();
                                $light_price_2 = $sheet->getCell('U31')->getCalculatedValue();
                                $light_price = $light_price_2+ $light_price_1;
                                $final_price =  $light_price +$total_price;
                                $systems[] = [
                                    'length' => $length,
                                    'width' => $width,
                                    'price'=>$total_price,
                                    'light_price'=>$light_price,
                                    'final_price'=>$final_price,
                                    'unit_price'=> $unit_price,
                                    'count'=>$dimension['count'],
                                    'area'=>$area
                                ];
                                
                                $nextRow++;
                                if($nextRow == 13){
                                    $row= $row+6;
                                }else{
                                    $row = $row +2 ; 
                                }
                                
                            }
                        
                        
                    }
                    
                    File::delete($tempPath); 
                    break;
                case 3:
                    $price = Price::where('product_id', 3)->value('price');
                    // dd($price);
                    foreach($product['dimensions'] as $dimension){
                        $count = $dimension['count'];
                        $length=$dimension['length'];
                        $width=$dimension['width'];
                        $area=$width*$length;
                        $total_price=$area*$price*$count;
                        
                        $systems[] = [
                            'length' => $length,
                            'width' => $width,
                            'final_price'=>$total_price,
                            'unit_price'=> $price,
                            'count'=>$dimension['count'],
                            'area'=>$area
                        ];
                    }
                    break;
                case 4:
                    
                    $filePath = public_path('excel/Gutin_window.xlsx');
                    $tempPath = public_path('excel/Gutin_window_temp.xlsx');
                    

                    File::copy($filePath, $tempPath);
                    
                    

    
                    $nextRow = 10;
                    $row=16;
                    
                    $total=0;
                    foreach($product['dimensions'] as $dimension){
                        
                            foreach ($dimension['systems'] as $system) {
                                // dd($system);
                                foreach ($dimension['customs'] as $custom) {
                                    $type = $custom['type'];
                                }
                                
                                $length = $system['length'];
                                $width = $system['width'];
                                
                                
                                $spreadsheet = IOFactory::load($tempPath);
    
                    
                                $sheet = $spreadsheet->getSheetByName('پیش فاکتور گیوتین');

                                
                                $sheet->setCellValue('C' . $nextRow , $width);
                                $sheet->setCellValue('D' . $nextRow, $length);
                                $sheet->setCellValue('E' . $nextRow , $dimension['count']);
                                
                                if($type=="two-side-laminate"){
                                    $sheet->setCellValue('G' . $nextRow, 'Laminate Glass ( 5mm +1.52PVB+ 5mm )');
                                }elseif ($type=="two-side-seurat") {
                                    $sheet->setCellValue('G' . $nextRow, '6mm + 8 air spacer + 6mm');
                                }
                                }

                               

                                
                                
                                
                                $area = $sheet->getCell('R' . $row)->getCalculatedValue();
                                $unit_price = $sheet->getCell('T' . $row)->getCalculatedValue();
                                $total_price = $sheet->getCell('U' . $row)->getCalculatedValue();
                                

                                
                                $systems[] = [
                                    'length' => $length,
                                    'width' => $width,
                                    'final_price'=>$total_price,
                                    'unit_price'=> $unit_price,
                                    'count'=>$dimension['count'],
                                    'area'=>$area
                                ];
                                
                                $nextRow++;
                                if($nextRow == 11){
                                    $row= $row+6;
                                }else{
                                    $row = $row +4 ; 
                                }
                                
                            }
                        
                        
                    
                    File::delete($tempPath);
                    break;
                    
                
                
                
                case 5:
                    foreach($product['dimensions'] as $dimension){
                        
                        foreach ($dimension['systems'] as $system) {
                            
                            
                            $length = $system['length'];
                            $width = $system['width'];
                            $area = $width*$length;

                            $unit_price = calculateSystemPrice($product_id ,$length , $width );
                            $total_price = $unit_price*$area;
                            $final_price= $total_price * $dimension['count'];

                            $systems[] = [
                                'length' => $length,
                                'width' => $width,
                                'final_price'=>$final_price,
                                'unit_price'=> $unit_price,
                                'count'=>$dimension['count'],
                                'area'=>$area
                            ];
                        }
                        
                    }
                    break;
                    

                
                    
            
                case 6:
                    
                    foreach($product['dimensions'] as $dimension){
                        if (isset($dimension['systems'])) {

                            foreach ($dimension['systems'] as $system) {
                                // dd($system);
                                foreach ($dimension['customs'] as $custom) {
                                    $engine = $custom['engine'];
                                    $type = $custom['type'];
                                }
                                $filePath = public_path('excel/Cable_curtain.xlsx');
                                $tempPath = public_path('excel/Cable_curtain_temp.xlsx');
                                

                                File::copy($filePath, $tempPath);
                                
                                $spreadsheet = IOFactory::load($tempPath);
                
                                
                                $sheet = $spreadsheet->getSheetByName('SALE');
                                
                                $length = $system['length']/100;
                                $width = $system['width']/100;
                                
                                
                                
                                
                                $sheet->setCellValue('D' . '3' , $length);
                                $sheet->setCellValue('D' . '4', $width);
                                $sheet->setCellValue('D' . '5' , $dimension['count']);
                                
                                if($type=="serge"){
                                    $sheet->setCellValue('D' . '6', 'Ferrari');
                                }elseif ($type=="coulisse") {
                                    $sheet->setCellValue('D' . '6', 'Coulisse');
                                }elseif ($type=="mehgies") {
                                    $sheet->setCellValue('D' . '6', 'Mehler');
                                }

                                if($engine == "becker"){
                                    $sheet->setCellValue('D' . '7' , 'Becker');
                                }elseif($engine == "somfy"){
                                    $sheet->setCellValue('D' . '7' , 'Somfy');
                                }elseif($engine == "saye-roshan"){
                                    $sheet->setCellValue('D' . '7' , 'موتور اختصاصی سایه روشن');
                                }

                                
                                
                                
                                $area = $sheet->getCell('F' . '6')->getCalculatedValue();
                                $unit_price = $sheet->getCell('F' . '7')->getCalculatedValue();
                                $total_price = $sheet->getCell('F' . '8')->getCalculatedValue();                                
                                
                                $systems[] = [
                                    'length' => $length,
                                    'width' => $width,
                                    'light_price'=>$light_price,
                                    'final_price'=>$total_price,
                                    'unit_price'=> $unit_price,
                                    'count'=>$dimension['count'],
                                    'area'=>$area
                                ];
                                
                                File::delete($tempPath);
                                
                            }
                        }
                        
                    }
                    break;
                case 7:
                    
                    foreach($product['dimensions'] as $dimension){
                        if (isset($dimension['systems'])) {

                            foreach ($dimension['systems'] as $system) {
                                // dd($system);
                                foreach ($dimension['customs'] as $custom) {
                                    $engine = $custom['engine'];
                                    $type = $custom['type'];
                                }
                                $filePath = public_path('excel/Cable_curtain.xlsx');
                                $tempPath = public_path('excel/Cable_curtain_temp.xlsx');
                                

                                File::copy($filePath, $tempPath);
                                
                                $spreadsheet = IOFactory::load($tempPath);
                
                                
                                $sheet = $spreadsheet->getSheetByName('SALE');
                                
                                $length = $system['length']/100;
                                $width = $system['width']/100;
                                
                                
                                
                                
                                $sheet->setCellValue('D' . '3' , $length);
                                $sheet->setCellValue('D' . '4', $width);
                                $sheet->setCellValue('D' . '5' , $dimension['count']);
                                
                                if($type=="serge"){
                                    $sheet->setCellValue('D' . '6', 'Ferrari');
                                }elseif ($type=="coulisse") {
                                    $sheet->setCellValue('D' . '6', 'Coulisse');
                                }elseif ($type=="mehgies") {
                                    $sheet->setCellValue('D' . '6', 'Mehler');
                                }

                                if($engine == "becker"){
                                    $sheet->setCellValue('D' . '7' , 'Becker');
                                }elseif($engine == "somfy"){
                                    $sheet->setCellValue('D' . '7' , 'Somfy');
                                }elseif($engine == "saye-roshan"){
                                    $sheet->setCellValue('D' . '7' , 'موتور اختصاصی سایه روشن');
                                }

                                
                                
                                
                                $area = $sheet->getCell('F' . '6')->getCalculatedValue();
                                $unit_price = $sheet->getCell('F' . '7')->getCalculatedValue();
                                $total_price = $sheet->getCell('F' . '8')->getCalculatedValue();  
                                $unit_price= ($unit_price *70)/100;                              
                                $total_price= ($total_price *70)/100;
                                $systems[] = [
                                    'length' => $length,
                                    'width' => $width,
                                    'light_price'=>$light_price,
                                    'final_price'=>$total_price,
                                    'unit_price'=> $unit_price,
                                    'count'=>$dimension['count'],
                                    'area'=>$area
                                ];
                                
                                File::delete($tempPath);
                                
                            }
                        }
                        
                    }
                    break;
                    
            }

            $allSystems[] = [
                'product_id' => $product_id,
                'systems' => $systems
            ];
            // dd($allSystems);
            

        
        }
        
        $order = Order::create([
                'customer_name' => $data['name'],
                'customer_company' => $data['company'],
                'customer_phone' => $data['phone'],
                
        ]);
        $order_id = $order->id;
        $pdf = $this->generatePDF($allSystems ,$order_id);
        // dd($pdf);
        $url=$pdf['url'];
       


    
        return response()->json([
            'message' => 'PDF will be sent shortly.',
            'pdf_url' => $url
        ]);
        
       
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
    private function generatePDF($allSystems, $orderId)
    {
        // مسیر فونت‌ها
        // dd($allSystems);
        $fontDir = resource_path('fonts/');

        // تنظیم فونت‌های خاص
        $mpdf = new Mpdf([
            'tempDir' => storage_path('app/temp'),
            'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
                $fontDir
            ]),
            'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], [
                'bnazanin' => [
                    'R' => 'XB Niloofar.ttf',
                    'B' => 'XB NiloofarBd.ttf', // اگر نسخه بولد وجود دارد
                    'useOTL' =>  0xFF,
                    'useKashida' => 75,
                ],
                'btitr' => [
                    'R' => 'XB Titre.ttf',
                    'useOTL' =>  0xFF,
                    'useKashida' => 75,
                ],
            ]),
            'default_font' => 'bnazanin' // تنظیم فونت پیش‌فرض به 'B Nazanin'
        ]);

        // رندر کردن ویو به عنوان HTML
        $html = view('pdf.invoice', compact('allSystems', 'orderId'))->render();
        $mpdf->WriteHTML($html);

        // تولید یک نام یکتا با استفاده از شماره سفارش
        $filename = "invoice_order_{$orderId}_" . Str::uuid() . ".pdf";
        $filePath = storage_path("app/public/invoices/{$filename}");

        // ذخیره کردن فایل PDF در مسیر مشخص
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        // برگرداندن URL فایل PDF
        return [
            'url' => url("/storage/invoices/{$filename}")
        ];
    }
}
