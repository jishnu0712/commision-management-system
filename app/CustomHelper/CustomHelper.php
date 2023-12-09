<?php

namespace App\CustomHelper;

require_once __DIR__ . '/QRCode/vendor/autoload.php';

use DateTime;
use Exception;
use nguyenary\QRCodeMonkey\QRCode;
use Illuminate\Support\Facades\Http;

if (!class_exists('CustomHelper')) {
    class CustomHelper
    {
        public static function whatsappURL()
        {
            return env('WHATSAPP_API_URL');
        }

        public static function createQrCode($text, $filename, $path = 'QrCode')
        {
            $qrcode = new QRCode($text);
            $qrcode->setConfig([
                'bgColor' => '#FFFFFF',
                'body' => 'square',
                'bodyColor' => '#0277bd',
                'brf1' => [],
                'brf2' => [],
                'brf3' => [],
                'erf1' => [],
                'erf2' => [],
                'erf3' => [],
                'eye' => 'frame13',
                'eye1Color' => '#000000',
                'eye2Color' => '#000000',
                'eye3Color' => '#000000',
                'eyeBall' => 'ball15',
                'eyeBall1Color' => '#000000',
                'eyeBall2Color' => '#000000',
                'eyeBall3Color' => '#000000',
                'gradientColor1' => '#0277bd',
                'gradientColor2' => '#000000',
                'gradientOnEyes' => 'true',
                'gradientType' => 'linear',
                'logoMode' => 'clean'
            ]);
            $qrcode->setFileType('png');
            $qrcode->setSize(300);
            $qrcode->create($path . '/' . $filename);
        }
        //CHECK EMAIL IS TRUE OR NOT
        public static function isEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
        }
        //CHECK IS NAME OR NOT
        public static function isName($name)
        {
            if (preg_match("/^[a-zA-Z ]*$/", $name)) {
                return true;
            }
        }
        //IS USERNAME
        public static function isUsername($username)
        {
            if (preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                return true;
            }
        }
        //INTEGER VAL IS ODD
        public static function isEven(int $int)
        {
            if ($int % 2 === 0) {
                return true;
            }
            return false;
        }
        //IS MOBILE
        public static function isMobile($mobile)
        {
            if (preg_match("/^[0-9]*$/", $mobile)) {
                return true;
            }
        }

        //CHECk REAL URL OR NOT
        public static function isUrl($url)
        {
            if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
                return true;
            }
        }
        //HIDE CARD AND MOBILE NO
        public static function hideNumber(string $number, $show, $hidden_with = "X")
        {
            return str_repeat($hidden_with, strlen($number) - $show) . substr($number, -$show);
        }

        //ENCRYPT DATA
        public static function oneTimeEncrypted($value)
        {
            return md5(sha1($value));
        }

        //AUTH KEY
        public static function authKey($length = 20)
        {
            return substr(str_shuffle("AbCdEfGhIjKlMnOpQrStUvWxYz1234567890" . sha1(time()) . md5(date('Y/m/d h:i:s'))), 0, $length);
        }

        //GET EMAIL FROM TEXT
        public static function mailFromText($text)
        {
            if (!empty($text)) {
                $res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $text, $matches);
                if ($res) {
                    $tempArr = [];
                    foreach (array_unique($matches[0]) as $email) {
                        $tempArr[] = $email;
                    }
                    return $tempArr;
                } else {
                    return false;
                }
            }
        }

        //FULL URL
        public static function fullUrl()
        {
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            return $actual_link;
        }
        //GET FULL DOMAIN
        public static function getDomain()
        {
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            return $actual_link;
        }

        //GET SSL
        public static function getSSL()
        {
            $ssl = isset($_SERVER['HTTPS']) ? "https" : "http".'://';
            return $ssl;
        }


        //STRING TO INTEGER
        public static function strToInt($str)
        {
            $intValue = intval(preg_replace('/[^0-9]+/', '', $str));
            return $intValue;
        }

        //GET QUERY VARIABLE FROM COSTUME URL
        public static function getUrlVar($url)
        {
            $parts = parse_url($url);
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
                return $query;
            }
        }

        public static function youTubeId($url)
        {
            $video_id = false;
            $url = parse_url($url);
            if (strcasecmp($url['host'], 'youtu.be') === 0) {
                $video_id = substr($url['path'], 1);
            } elseif (strcasecmp($url['host'], 'www.youtube.com') === 0) {
                if (isset($url['query'])) {
                    parse_str($url['query'], $url['query']);
                    if (isset($url['query']['v'])) {
                        $video_id = $url['query']['v'];
                    }
                }
                if ($video_id == false) {
                    $url['path'] = explode('/', substr($url['path'], 1));
                    if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                        $video_id = $url['path'][1];
                    }
                }
            }
            return $video_id;
        }

        // DATE FORMAT
        public static function dateFormat($format, $date)
        {
            $new_date = date($format, strtotime($date));
            return $new_date;
        }
        //EXPIRY DATE
        public static function expiryDate($expiry = "+28 days", $date = "")
        {
            if (empty($date)) {
                $date = date("Y-m-d H:i:s");
            }
            return date('Y-m-d H:i:s', strtotime($date . $expiry));
        }
        //DATE IS EXPIRED OR NOT
        public static function isExpired($date)
        {
            $today = date("Y-m-d H:i:s");
            if ($date < $today) {
                return true;
            }
        }

        //GE DAY BETWEEN TWO DATE
        public static function totalDays($date2, $date1 = '')
        {
            if (empty($date1)) {
                $date1 = date_create(date("Y-m-d h:i:s"));
            } else {
                $date1 = date_create($date1);
            }
            $date2 = date_create($date2);
            $diff = date_diff($date1, $date2);
            return $diff->format("%R%a");
        }

        //GET USER IP ADDRESS
        public static function userIP()
        {
            $clint = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote = $_SERVER['REMOTE_ADDR'];
            if (filter_var($clint, FILTER_VALIDATE_IP)) {
                $ip = $clint;
            } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
                $ip = $forward;
            } else {
                $ip = $remote;
            }
            return $ip;
        }

        //ESCAPE SPECIAL CHAR
        public static function escape($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars_decode($data);
            $data = strip_tags($data);
            return $data;
        }

        //GET LENGTH OF ARRAY AND STRING
        public static function len($val)
        {
            if (is_string($val)) {
                return strlen($val);
            } elseif (is_array($val)) {
                return count($val);
            } else {
                return "len() function take string or array!";
            }
        }

        //GET A TO Z IN A STRING
        public static function lowerString($start = 0, $end = 26)
        {
            return substr('abcdefghijklmnopqrstuvwxyz', $start, $end);
        }
        //GET A TO Z IN UPPER
        public static function upperString($start = 0, $end = 26)
        {
            return substr('ABCDEFGIJKLMNOPQRSTUVWXYZ', $start, $end);
        }

        // SET WORD
        public static function getWords($sentence, $count = 10)
        {
            preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
            return $matches[0];
        }

        public static function bsToImg($base64_string, $output_file)
        {
            $ifp = fopen($output_file, 'wb');
            $data = explode(',', $base64_string);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            return $output_file;
        }
        // EXPORT TO CSV
        public static function exportCSV($file_name = '')
        {
            if (empty($file_name)) {
                $file_name = self::authKey(30);
            }
            $ext = explode(".", $file_name);
            if (end($ext) != "csv") {
                $file_name .= ".csv";
            }
            header('Content-Type: application/csv');
            header('Content-disposition: attachment; filename=' . $file_name);
        }
        // EXPORT TO EXCEL
        public static function exportEXCEL($file_name = '')
        {
            if (empty($file_name)) {
                $file_name = self::authKey(30);
            }
            $ext = explode(".", $file_name);
            if (end($ext) != "xls") {
                $file_name .= ".xls";
            }
            header('Content-Type: application/xls');
            header('Content-disposition: attachment; filename=' . $file_name);
        }

        //DATE RANGE
        public static function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
        {
            $dates = [];
            $current = strtotime($first);
            $last = strtotime($last);
            while ($current <= $last) {
                $dates[] = date($format, $current);
                $current = strtotime($step, $current);
            }
            return $dates;
        }

        // SHOW PHP ERROR
        public static function showAllError()
        {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        // MAKE DATA FOR SQL IN FUNCTION
        public static function makeMulti($myArray, $type = "str")
        {
            if (is_array($myArray)) {
                $myArray = implode(",", $myArray);
                $myArray = array_unique(explode(",", $myArray));
                $myArray = array_map("trim", $myArray);
                $myArray  = array_filter($myArray);
                $myArray = implode(",", $myArray);
            }

            return ($type == "str") ? "'" . str_replace(",", "','", $myArray) . "'" : $myArray;
        }

        // GROUP CONCAT FUNCTION
        public static function groupConcat($array, $key)
        {
            return implode(",", array_column($array, $key));
        }

        // REMOVE SPECIAL CHAR
        public static function removeSpecialChar($string)
        {
            $specialChar = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "-", "+", "{", "[", "]", "}", "\\", "|", "/", '"', "'", ".", ",", "=", ":", ";", "<", ">"];
            $result = str_replace($specialChar, '', trim($string));
            $result =  strtolower(str_replace(" ", "_", $result));
            return $result;
        }

        //NUMBER TO WORDS
        public static function numberToWords($number)
        {
            $no = round($number);
            $point = round($number - $no, 2) * 100;
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninety');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str[] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                } else {
                    $str[] = null;
                }
            }
            $str = array_reverse($str);
            $result = implode('', $str);
            $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
            if (!empty($points)) {
                return $result . "rupees  " . $points . " paise";
            } else {
                return $result . "rupees  ";
            }
        }

        //PERCENTAGE
        public static function getPercentahe($number, $percent)
        {
            return ($percent / 100) * $number;
        }

        // DAYS TO d/m/Y
        public static function dateToDMY($to, $from = '')
        {
            $from = empty($from) ? date("Y-m-d H:i:s") : $from;
            $date1 = new DateTime($from);
            $date2 = new DateTime($to);
            $interval = $date2->diff($date1);
            return ["days" => $interval->d, "months" => $interval->m, "years" => $interval->y, "hours" => $interval->h, "minute" => $interval->i, "second" => $interval->s, "total_days" => $interval->days];
        }

        public static function removeFromArray($array_data, $key_name, $key_value)
        {
            return array_filter($array_data, function ($item) use ($key_name, $key_value) {
                return $item[$key_name] !== $key_value;
            });
        }

        public static function orderStatusClass()
        {
            return [
                1 => [
                    'class' => 'filter_option_delivered',
                    'text' => 'Completed'
                ],
                2 => [
                    'class' => 'filter_option_pending',
                    'text' => 'Placed'
                ],
                3 => [
                    'class' => 'filter_option_preparation',
                    'text' => 'In Process'
                ],
                4 => [
                    'class' => 'filter_option_ontheway',
                    'text' => 'Served'
                ],
                5 => [
                    'class' => 'filter_option_cancelled',
                    'text' => 'Cancelled'
                ],
            ];
        }

        public static function currencyFormat($number, $decimalPlace = 2)
        {
            return number_format($number, $decimalPlace, '.', ',');
        }

        public static function sendWhstsAppMessage($mobile, $message, $filename = 'invoice.pdf', $caption = '', $responseMsg = 'Sent successfully.')
        {
            $url = env('SOCKET_URL') . '/sendmessage';
            $data = [
                "message" => $message,
                "phone" => $mobile,
                "auth_key" => md5(auth('restaurant')->user()->id),
                "secretkey" => md5(auth('restaurant')->user()->username),
                "caption" => $caption,
                "filename" => $filename,
                "responseMsg" => $responseMsg
            ];

            try {
                $response = Http::post($url, $data);
                $responseData = $response->json();
                return response()->json(['error' => $responseData['status'], 'message' => $responseData['msg']]);
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
        }

        // CHECK WHATSAPP INSTANCE
        public static function checkInstance(string $instance_id)
        {
            $url = self::whatsappURL();
            try {
                $response = Http::get($url . '/instance/info?key=' . $instance_id);
                return (object) $response->json();
            } catch (Exception $e) {
                return (object)['error' => true, 'message' => $e->getMessage()];
            }
        }

        // CREATE WHATSAPP INSTANCE
        public static function createInstance(string $instance_id)
        {
            $url = self::whatsappURL();
            try {
                $response = Http::get($url . '/instance/init?key=' . $instance_id);
                return (object) $response->json();
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
        }

        // GET BASE64 QR CODE
        public static function base64Qr(string $instance_id)
        {
            $url = self::whatsappURL();
            try {
                $response = Http::get($url . '/instance/qrbase64?key=' . $instance_id);
                return (object) $response->json();
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
        }

        // SEND WHATSAPP MESSAGE
        public static function sendMessage(string $instance_id, $to_number, $message)
        {
            $url = self::whatsappURL();
            try {
                $response = Http::asForm()
                    ->post($url . '/message/text?key=' . $instance_id, [
                        'id' => $to_number . '@c.us',
                        'message' => $message,
                    ]);
                return (object) $response->json();
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
        }

        // SEND DOCUMENT
        public static function sendDocument(string $instance_id, $to_number, $caption, $pdfData, $filename = 'document.pdf')
        {
            $url = self::whatsappURL();
            try {
                $tempPdfFile = tempnam(sys_get_temp_dir(), 'temp-pdf-');
                file_put_contents($tempPdfFile, $pdfData);

                $response = Http::attach(
                    'file',
                    fopen($tempPdfFile, 'r'),
                    $filename
                )->post($url.'/message/doc?key='.$instance_id, [
                    'id' => $to_number.'@c.us',
                    'filename' => $filename,
                    'caption' => $caption,
                ]);
                return (object) $response->json();
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
        }
    }
}
