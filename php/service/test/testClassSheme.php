<?php

require_once(dirname(__FILE__) . './../../vendors/yii-1.1.8/framework/yii.php');

function send_request($url, $httpMethod, $params = array())
{
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $httpMethod);
    if ($httpMethod == 'GET')
    {
        $params_uri = '?';
        foreach ($params as $param => $value)
        {
            if ($params_uri !== '?')
                $params_uri .= '&';
            
            $params_uri .= $param . '=' . $value;
        }
        $url .= $param_uri;
    }
    else
    {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    }
    
    $res = curl_exec($curl);
    curl_close($curl);
    
    return $res;
}

function is_assoc($arr)
{
    return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
}

function echo_line($line, $tab_count = 0)
{
    for ($i = 0; $i < $tab_count; $i++)
        echo '    ';
    
    echo $line."\n";
}

function print_as_json($arr_key, $arr, $level = 0)
{
    if (!is_array($arr))
    {
        echo_line($arr_key.' : '.$arr.',', $level);
        return;
    }
    
    $is_assoc = is_assoc($arr);
    
    if ($arr_key !== '' && !is_int($arr_key))
        $arr_key .= ' : ';

    if ( is_int($arr_key))
        $arr_key = (!$is_assoc ? '[' : '{');
    else
        $arr_key = $arr_key . (!$is_assoc ? '[' : '{');
    
    echo_line($arr_key, $level);
    
    foreach ($arr as $key => $value)
        print_as_json($key, $value, $level + 1);
    
    echo_line(!$is_assoc ? '],' : '},', $level);
}

class testCase {
    const BASE_SERVICE = 'http://resourceservice.local/index.php/api/service/';
    const RESPONSE_FORMAT = 'json';
    
    private $test_list = array(
        'class_list' => 'class',
        'class_by_id' => 'class/1',
    );
    
    public function testList() {
        echo '<ul>';
        foreach ($this->test_list as $test_name => $uri) {
            echo "<li> <a href=\"?test=$uri\">$test_name</a> </li>\n";
        }
        echo '</ul>';
    }
    
    public function performTest($testName) {
        $testUri = testCase::BASE_SERVICE . $testName . '.' . testCase::RESPONSE_FORMAT;
        
        echo_line('<pre>');
        
        echo_line("Request:");
        echo_line("\t".$testUri);
        echo_line("\nResponse:\n");
        
        $response = send_request($testUri, 'GET');

        $coder = new CJSON();
        $object = $coder->decode($response);

        print_as_json('', $object);

        echo_line('</pre>');
    }
}

$testCase = new testCase();

if (isset($_GET['test'])) {
    echo '<a href="testClassSheme.php">< back</a><br/>';
    
    $testCase->performTest($_GET['test']);
} else {
    $testCase->testList();
}

?>