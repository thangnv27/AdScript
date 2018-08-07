<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Common Functions
 */
class CommonsComponent extends Component {

    /**
     * Display with <pre> tag on browser
     * 
     * @param All format $value
     */
    public function preTag($value) {
        if (is_string($value)) {
            echo "<pre>";
            echo($value);
            echo "</pre>";
        } else {
            echo "<pre>";
            print_r($value);
            echo "</pre>";
        }
    }

    /**
     * Display with <pre> tag on browser
     * Display value and type of all field
     * @param All format $value
     */
    public function varDump($value) {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }

    /**
     * Check valid username
     * @param string $username Account using to signin
     * @return string Username is valid
     */
    public function is_valid_username($username) {
        return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*$^", $username);
    }

    /**
     * Check valid the email
     * @return boolean
     */
    public function isValidEmail($email) {
//        return filter_var($email, FILTER_VALIDATE_EMAIL);
//        return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^", $email);
        return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,6}))$#si', $email);
    }

    /**
     * Tests a string to see if it's a valid phone number
     *
     * @param	string	$phone Phone number
     *
     * @return	boolean
     */
    public function is_valid_phone_number($phone) {
        return preg_match("#^[0-9[:space:]\+\-\.\(\)]+$#si", $phone);
    }

    /**
     * Validate tax code
     * 
     * @param string $tax_code Tax code to validate
     * @param boolean
     */
    public static function is_valid_tax_code($tax_code) {
        if (empty($tax_code))
            return true;

        if (!(strlen($tax_code) == 10 || strlen($tax_code) == 13))
            return false;

        $is_TaxCode = str_split($tax_code);

        for ($ii_Index = 0; $ii_Index < 10; $ii_Index++)
        {
            if (!is_numeric($is_TaxCode[$ii_Index]))
            {
                return false;
            }
        }

        $ii_TotalValue = 0;
        $ii_LastNumber = intval($is_TaxCode[9]);

        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[0]) * 31;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[1]) * 29;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[2]) * 23;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[3]) * 19;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[4]) * 17;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[5]) * 13;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[6]) * 7;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[7]) * 5;
        $ii_TotalValue = $ii_TotalValue + intval($is_TaxCode[8]) * 3;
        $ii_TotalValue = $ii_TotalValue - ((int)($ii_TotalValue / 11) * 11);

        if (10 - $ii_TotalValue == $ii_LastNumber)
        {
            return true;
        }
        return false;
    }

    /**
     * Check valid katakana
     * @return boolean
     */
    public function isKatakana($name) {
        return preg_match("/^(\xe3\x82[\xa1-\xbf]|\xe3\x83[\x80-\xbe])+$/", $name);
    }

    /**
     * Convert an object to array
     * @param Object $object
     * @return array
     */
    public function convert_object_to_array($object){
        $array = array();
        foreach ($object as $member => $data){
            $array[$member] = $data;
        }
        return $array;
    }

    /**
     * Generate random string 
     * 
     * @param integer $length default length = 32
     * @return string
     */
    public function random_string($length = 32) {
        $key = '';
        $rand = str_split(strtolower(md5(time() * microtime())));
        $keys = array_merge(range(0, 9), range('a', 'z'));
        $keys = array_merge($keys, $rand);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    /**
     * Generates a random password that is much stronger than what we currently use.
     * Default length = 8
     *
     * @param	integer	Length of desired password
     */
    public function random_password($length = 8) {
        $password_characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
        $total_password_characters = strlen($password_characters) - 1;

        $digit = $this->grand(0, $length - 1);

        $newpassword = '';
        for ($i = 0; $i < $length; $i++) {
            if ($i == $digit) {
                $newpassword .= chr($this->grand(48, 57));
                continue;
            }

            $newpassword .= $password_characters{$this->grand(0, $total_password_characters)};
        }
        return $newpassword;
    }

    /**
     * Generates a totally random string
     * @param	integer	Length of string to create
     * @return	string	Generated String
     */
    public function random_salt($length = 30) {
        $salt = '';
        for ($i = 0; $i < $length; $i++) {
            $salt .= chr($this->grand(33, 126));
        }
        return $salt;
    }

    /**
     * Hash password
     * 
     * @return string password encrypted
     */
    public function hash_password($password, $salt) {
        return sha1(md5($password) . $salt);
    }

    /**
     * Random number generator
     *
     * @param	integer	Minimum desired value
     * @param	integer	Maximum desired value
     * @param	mixed	Seed for the number generator (if not specified, a new seed will be generated)
     */
    public function grand($min = 0, $max = 0, $seed = -1) {
        mt_srand(crc32(microtime()));

        if ($max AND $max <= mt_getrandmax()) {
            $number = mt_rand($min, $max);
        } else {
            $number = mt_rand();
        }
        // reseed so any calls outside this function don't get the second number
        mt_srand();

        return $number;
    }

    /**
     * Replaces url entities with -
     *
     * @param string $fragment
     * @return string
     */
    public function clean_entities($fragment) {
        $translite_simbols = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $fragment = preg_replace($translite_simbols, $replace, $fragment);
        $fragment = preg_replace('/(-)+/', '-', $fragment);

        return strtolower($fragment);
    }

    /**
     * Generate Slug URL from title
     * 
     * @param string $title Title for clean entities
     * @param string $slug Slug for check empty
     * @return string Slug URL
     */
    public function generateSlug($title, $slug = "") {
        if(empty($slug)){
            $slug = $this->clean_entities($title);
        } else {
            $slug = $this->clean_entities($slug);
        }
        return $slug;
    }

    /**
     * get year list from year start to now
     * @param int $yearStart
     * @return array : from year start to now
     */
    public function getYears($yearStart = 1950) {
        $yearList = array();
        for ($year = $yearStart; $year <= date('Y'); $year++) {
            $yearList[$year] = $year;
        }
        return $yearList;
    }

    /**
     *
     * @return array
     */
    public function getDaysInWeek() {
        $weeks = array();
        for ($i = 1; $i <= 7; $i++) {
            if ($i < 10)
                $weeks['0' . $i] = '0' . $i;
            else
                $weeks[$i] = $i;
        }
        return $weeks;
    }

    /**
     *
     * @return array
     */
    public function getHours() {
        $hours = array();
        for ($i = 0; $i <= 24; $i++) {
            if ($i < 10)
                $hours['0' . $i] = '0' . $i;
            else
                $hours[$i] = $i;
        }
        return $hours;
    }

    /**
     *
     * @return array
     */
    public function getMinutes() {
        $minutes = array();
        for ($i = 0; $i < 60; $i++) {
            if ($i < 10)
                $minutes['0' . $i] = '0' . $i;
            else
                $minutes[$i] = $i;
        }
        return $minutes;
    }

    /**
     * 
     * @param type $arrays
     * @param type $length
     * @return type
     */
    public function cutString($arrays, $length) {
        foreach ($arrays as &$value) {
            $charset = 'UTF-8';
            if (mb_strlen($value, $charset) > $length) {
                $value = mb_substr($value, 0, $length, $charset) . '...';
            }
        }
        return $arrays;
    }

    /**
     * Remove special char
     * 
     * @param string $string
     * @return string
     */
    public function removeSpecialChar($string) {
        $specialChar = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "-", "+", "=", ";", ":", "'", "\"", ",", ".", "/", "<", ">", "?",);
        foreach ($specialChar as $key => $value) {
            $pos = strpos($string, $value);
            if ($pos) {
                $string = str_replace(substr($string, $pos, 2), ucwords(substr($string, $pos + 1, 1)), $string);
            }
        }
        return $string;
    }

    /**
     * Remove BBCODE from text document
     * @param string $code text document
     * @return string text document
     */
    public function removeBBCode($code) {
        $code = preg_replace("/(\[)(.*?)(\])/i", '', $code);
        $code = preg_replace("/(\[\/)(.*?)(\])/i", '', $code);
        $code = preg_replace("/http(.*?).(.*)/i", '', $code);
        $code = preg_replace("/\<a href(.*?)\>/", '', $code);
        $code = preg_replace("/:(.*?):/", '', $code);
        $code = str_replace("\n", '', $code);
        return $code;
    }

    /**
     * Get short content from full contents
     * 
     * @param integer $length 
     * @return string
     */
    public function get_short_content($contents, $length) {
        $short = "";
        $contents = strip_tags($contents);
        if (strlen($contents) >= $length) {
            $text = explode(" ", substr($contents, 0, $length));
            for ($i = 0; $i < count($text) - 1; $i++) {
                if ($i == count($text) - 2) {
                    $short .= $text[$i];
                } else {
                    $short .= $text[$i] . " ";
                }
            }
            $short .= "...";
        } else {
            $short = $contents;
        }
        return $short;
    }
    
    ################### STATIC FUNCTIONS #######################################
    
    /**
     * Indent white space
     * @param $length Number space
     * @return String with white space
     */
    public static function indentSpace($length = 4) {
        $space = "";
        for ($i = 0; $i < $length; $i++) {
            $space .= "&nbsp;";
        }
        return $space;
    }

    /**
     * Indent white dash
     * @param $length Number dash
     * @return String with white dash
     */
    public static function indentDash($length = 2) {
        $dash = "";
        for ($i = 0; $i < $length; $i++) {
            $dash .= "&HorizontalLine;";
        }
        return $dash;
    }

    /**
     * Cities in Vietnamese
     * @return array
     */
    public static function vn_city_list() {
        return array(
            "An Giang", "Bà Rịa - Vũng Tàu", "Bạc Liêu", "Bắc Kạn", "Bắc Giang", "Bắc Ninh", "Bến Tre", "Bình Dương",
            "Bình Định", "Bình Phước", "Bình Thuận", "Cà Mau", "Cao Bằng", "Cần Thơ", "Đà Nẵng", "Đắk Lắk", "Đắk Nông",
            "Đồng Nai", "Đồng Tháp", "Điện Biên", "﻿Gia Lai", "Hà Giang", "Hà Nam", "Hà Nội", "Hà Tĩnh", "Hải Dương",
            "Hải Phòng", "Hòa Bình", "Hậu Giang", "Hưng Yên", "TP. Hồ Chí Minh", "Khánh Hòa", "Kiên Giang", "Kon Tum",
            "Lai Châu", "Lào Cai", "Lạng Sơn", "Lâm Đồng", "Long An", "Nam Định", "Nghệ An", "Ninh Bình", "Ninh Thuận",
            "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam", "Quảng Ngãi", "Quảng Ninh", "Quảng Trị", "Sóc Trăng",
            "Sơn La", "Tây Ninh", "Thái Bình", "Thái Nguyên", "Thanh Hóa", "Thừa Thiên - Huế", "Tiền Giang",
            "Trà Vinh", "Tuyên Quang", "Vĩnh Long", "Vĩnh Phúc", "Yên Bái", "Nơi khác",
        );
    }

    public static function genderList() {
        return array('female' => __('Nữ'), 'male' => __('Nam'), 'other' => __('Khác'));
    }

    public static function YesNoStatus() {
        return array(1 => __('Có'), 0 => __('Không'));
    }

    public static function getProductStatus() {
        return array('in_stock' => __('Còn hàng'), 'out_stock' => __('Hết hàng'), 'coming_soon' => __('Sắp có hàng'));
    }

    public static function getProductAttr($arrayOfObjects, $attr_name) {
        $neededObject = array_filter($arrayOfObjects, function ($e) use (&$attr_name) {
            return $e->attr_name == $attr_name;
        });
        return array_shift($neededObject);
    }

    public static function getOrderStatus() {
        return array('pending' => __('Chờ xử lý'), 'in_progress' => __('Đang xử lý'), 'paid' => __('Đã thanh toán'), 'canceled' => __('Đã hủy'));
    }

    public static function getDeliveryStatus() {
        return array('pending' => __('Chờ xử lý'), 'shipping' => __('Đang chuyển hàng'), 'shipped' => __('Đã giao hàng'));
    }

    public static function getPostStatus() {
        return array('publish' => __('Xuất bản'), 'draft' => __('Nháp'), 'trash' => __('Thùng rác'));
    }

    public static function getPostStatusKeys() {
        return array('publish', 'draft', 'trash');
    }

    public static function getRoleKeys() {
        return array('admin', 'editor', 'author', 'contributor', 'subscriber');
    }

    public static function getRole($key) {
        $roles = self::getRoleList();
        return $roles[$key];
    }

    public static function getRoleList() {
        return array(
            'admin' => __('Quản trị viên'),
//            'editor' => __('Biên tập viên'),
//            'author' => __('Tác giả'),
//            'contributor' => __('Cộng tác viên'),
            'member' => __('Thành viên'),
            'subscriber' => __('Theo dõi')
        );
    }

}
