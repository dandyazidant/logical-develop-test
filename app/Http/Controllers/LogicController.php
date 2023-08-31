<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function index(){
        $data = ['11', '12', 'cii', '001', '2', '1998', '7', '89', 'iia', 'fii'];
        $new_data = [];
        $formatted_output = array();
        for ($i = 0; $i < count($data); $i++) {
            if (!is_numeric($data[$i])) {
                $new_data[$data[$i]]  = $this->substring($data[$i]);
            }
        }
        $new_data['S'] = $this->joinarray($new_data);

        $formatted_data = array();

        foreach ($new_data as $key => $values) {
            $formatted_data[$key] = "{" . implode(', ', array_map(function($value) {
                return '"' . $value . '"';
            }, $values)) . "}";
        }

        foreach ($formatted_data as $key => $value) {
            $formatted_output[] = $key . " = " . $value . '<br>';
        }
        echo 'Expected Output:<br>';
        echo implode("\n", $formatted_output);
    }

    function joinarray($arr)
    {
        $new_array = [];
        foreach ($arr as $ele) {
            foreach ($ele as $val) {
                if (!in_array($val, $new_array)) {
                    array_push($new_array, $val);
                }
            }
        }
        return $new_array;
    }

    function substring($string){
        $arr = [];
        for ($z = 1; $z <= strlen($string); $z++) {
            array_push($arr, substr($string, 0, $z));
        }

        for ($x = strlen($string) - 1; $x >= 1; $x--) {
            $start = -$x;
            array_push($arr, substr($string, $start));
        }
        return $arr;
    }
}
