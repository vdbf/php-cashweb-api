<?php namespace Vdbf\Components\Cashweb;


class ApiResponse
{

    const Success = 1;

    const ErrorLogin = 2;
    const ErrorFile = 3;
    const ErrorIssuingToken = 4;
    const ErrorInvalidToken = 5;
    const ErrorCorruptedToken = 6;
    const ErrorUnrecognizedService = 7;

    const ErrorSendPayment = 200;
    const ErrorLockAndDownload = 300;
    const ErrorUploadAndUnlock = 400;
    const ErrorSendingDigipoort = 500;
    const ErrorPuttingFile = 600;
    const ErrorGettingDirList = 700;

    const ErrorExporting = 800;
    const ErrorImporting = 900;
    const ErrorImportingTransactionFailure = 901;
    const ErrorTransactionDoesNotExist = 902;
    const ErrorImportingEmptyAdministration = 903;

    public static function getErrorMessage($code)
    {
        $messages = array(
            1   => 'Success',
            2   => 'Error during login',
            3   => 'Error while handling file',
            4   => 'Error while issuing token',
            5   => 'Invalid token',
            6   => 'Corrupted token',
            7   => 'Unrecognized service',
            200 => 'Error sending payment',
            300 => 'Error during download',
            400 => 'Error during upload',
            500 => 'Error sending digipoort',
            600 => 'Error putting file',
            700 => 'Error getting directory listing',
            800 => 'Error during export',
            900 => 'Error during import',
            901 => 'Importing transaction failed',
            902 => 'Transaction does not exist',
            903 => 'Empty administration'
        );

        return isset($messages[ $code ]) ? $messages[ $code ] : "Unknown error ({$code})";
    }

    public static function isSuccess($response)
    {
        return $response->response->code == static::Success;
    }

} 