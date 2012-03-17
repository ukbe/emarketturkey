<?php

class CustomerMessagePeer extends BaseCustomerMessagePeer
{
    public static $topics = Array('1' => 'Technical Support',
                                  '2' => 'Feature Request',
                                  '3' => 'Bug Report',
                                  '4' => 'Financial Inquiry',
                                  '5' => 'Other'
                            );
}
