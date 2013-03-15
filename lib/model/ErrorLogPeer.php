<?php

class ErrorLogPeer extends BaseErrorLogPeer
{
    public static function Log($item_id, $item_type_id, $message, $e = null)
    {
        $context = sfContext::getInstance();
        $stack = $e ? $e->outputStackTrace() : '[object absent]';
        if ($e) $message .= (!is_null($message) ? "\"" . $message . "\"\n" : '') . "Message: {$e->getMessage()}\nFile: {$e->getFile()}\nLine: {$e->getLine()}\n\nApplication:{$log->getApplication()}\nModule:{$log->getModule()}\nAction:{$log->getAction()}\n\nStack:\n{$stack}";
        $message .= "";
        try
        {
            $log = new ErrorLog();
            $log->setCausingItemId($item_id ? $item_id : 0);
            $log->setCausingItemTypeId($item_type_id ? $item_type_id : 0);
            $log->setMessage($message);
            $log->setApplication($context->getConfiguration()->getApplication());
            $log->setModule($context->getModuleName());
            $log->setAction($context->getActionName());
            $log->save();
            mail('ukbe.akdogan@emarketturkey.com', 'Error occured', $message);
        }
        catch (Exception $e)
        {
            mail('ukbe.akdogan@emarketturkey.com', 'cannot log errors', "hi pal,\n I can not log errors \n reason:".$e->getMessage());
        }
    }
}
