<?php
    $filename = $_GET['file'];
    if($filename == '')
    {
        echo "provide filename!";
        die;
    }
    libxml_use_internal_errors(true);
    if (!$xml = simplexml_load_file($filename))
    {
      $error = false;

      return $error;
    }
    libxml_use_internal_errors(false);

    $translationUnit = $xml->xpath('//trans-unit');

    $translations = array();
    
    $con = @oci_connect('geek', 'geeker', 'emtbag');
    
    $sql = "select msg_id, source, translated from emt_tx_trans_unit";
    
    $stmt = oci_parse($con, $sql);
    oci_execute($stmt);

    $trans = array();
    
    while ($row = oci_fetch_row($stmt))
    {
        $source = (string)$row[1];
        $trans[$source][] = (int)$row[0];
        $trans[$source][] = (int)$row[2];
    }
    
    $translated = 0;
    $inserted = 0;
    
    foreach ($translationUnit as $unit)
    {
      $source = (string) $unit->source;
      if (!isset($trans[$source]))
      {
          $inserted++;
          
          $sql = "INSERT INTO emt_tx_trans_unit
            (msg_id, cat_id, id, source, target, date_added, date_modified, translated) VALUES
            (EMT_TX_TRANS_UNIT_SEQ.nextval, 1, (select count(*) from emt_tx_trans_unit), :message, :target, sysdate, sysdate, :translated)";
            
          $stmt = oci_parse($con, $sql);
    
          $target = (string)$unit->target;
          $source = (string)$unit->source;
          $translated = $target != '' ? 1 : 0;
          
          oci_bind_by_name($stmt, ':message', $source);
          oci_bind_by_name($stmt, ':target', $target);
          
          oci_bind_by_name($stmt, ':translated', $translated);
          oci_execute($stmt);
          
          $trans[$source][] = '';
          $trans[$source][1] = 1;
      }
      elseif (!$trans[$source][1])
      {
          $translated++;
          $sql = "update emt_tx_trans_unit set target=:target, translated=1, date_modified=sysdate where msg_id=:msg_id";
          $stmt = oci_parse($con, $sql);
          $target = (string)$unit->target;
          oci_bind_by_name($stmt, ':target', $target);
          oci_bind_by_name($stmt, ':msg_id', $trans[$source][0]);
          oci_execute($stmt);
          
          $trans[$source][1] = 1;
      }
    }
    
    echo "Translated: $translated - Inserted: $inserted";
    
    oci_close($con);
