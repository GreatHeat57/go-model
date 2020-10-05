<?php
namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use GeoIp2\Database\Reader;
use App\Helpers\Ip;
// use PulkitJalan\GeoIP\Facades\GeoIP;
use PulkitJalan\GeoIP\GeoIP;

class CountryController extends Controller
{
    public function getCountryInfo() {

        $notEUCountryList = array('US', 'CA', 'AR', 'BR', 'MX', 'NG', 'ZA', 'CN', 'HK', 'IN', 'JP', 'AU', 'NZ');
        $EUCountryList = array('AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PO', 'SK', 'SI', 'ES', 'SE', 'PL', 'PT', 'UK');

        if (\Auth::user() != null) {
            $data = array("showCookieConsentPopup" => false);
            return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
        }

        try {
            // get ip address
            $ipAddr = Ip::get();
            // set ip in geoIp

            //GeoIP::setIp($ipAddr);
            // get GeoIP country code
            // $countryCode = GeoIP::getCountryCode();

            $geoip = new GeoIP();
            $geoip->setIp($ipAddr);
            $countryCode = $geoip->getCountryCode();

        } catch (\Exception $e) {
            \Log::alert($e);
            $data = array("showCookieConsentPopup" => true);
            return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
        }

        if (in_array(strtoupper($countryCode), $EUCountryList) || in_array(strtoupper($countryCode), $notEUCountryList) || $countryCode == NULL ) {
            $data = array("showCookieConsentPopup" => true);
        } else {
            $data = array("showCookieConsentPopup" => false);
        }
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}