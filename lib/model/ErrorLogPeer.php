<?php

class ErrorLogPeer extends BaseErrorLogPeer
{
    public static function Log($item_id, $item_type_id, $message, $e = null)
    {
        try
        {
            $log = new ErrorLog();
            $log->setCausingItemId($item_id);
            $log->setCausingItemTypeId($item_type_id);
            $log->setMessage($message);
            $log->save();
            mail('ukbe.akdogan@emarketturkey.com', 'Error occured', $e ? print_r($e, true) : $message);
        }
        catch (Exception $e)
        {
            mail('ukbe.akdogan@emarketturkey.com', 'cannot log errors', "hi pal,\n I can not log errors \n reason:".$e->getMessage());
        }
    }
}
