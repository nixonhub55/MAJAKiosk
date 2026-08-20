<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CompanyPassword extends Model
{
      public function get_company_password_details()
      { 
            $passwordSettings = DB::table('companysetting')
                  ->select('passwordChangeInitLogon', 'passwordReuseRestriction', 'passwordLength', 'passwordComplexEnabled', 'lockedOutDuration', 'lockedOutRecoveryType', 'passwordExpiredDays', 'enableCaptcha', 'logAttempts','protocol','smtpHost','smtpPort','defaultSenderName','password','companyName','authType','kioskEmail','ImagePath','ImageFile','companyLogoBlob')
                  ->first(); 
            return $passwordSettings ? (array) $passwordSettings : [];
      }

      
      public function update_company_password_env($captchaStatus)
      {


            // $passwordSettings = $this->get_company_password_details();

            $enableCaptcha = isset($captchaStatus) && $captchaStatus == 1 ? '1' : '0';
            $this->updateEnvKey('ENABLECAPTCHA', $enableCaptcha);
      }

      public function updateEnvKey($key, $value)
      {
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);


            $pattern = "/^{$key}\s*=\s*.*$/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                  $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                  $envContent = rtrim($envContent) . "\n{$replacement}";
            }
            file_put_contents($envPath, $envContent);
      }
}








