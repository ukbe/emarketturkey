<?php
set_time_limit(999999);
//ini_set('memory_limit', '2048M');

    $filename = $_GET['file'];
    if($filename == '')
    {
        echo "provide filename!";
        die;
    }
    $targetln = strtolower($_GET['target']);
    if($targetln == '')
    {
        echo "provide target language!";
        die;
    }

    $con = oci_connect('geek', 'geeker', 'emtbag');
    
    $sql = "select cat_id from emt_tx_catalogue where target_lang='$targetln'";
    
    $stmt = oci_parse($con, $sql);
    oci_execute($stmt);
    
    if ($row = oci_fetch_row($stmt))
    {
        $catid = $row[0];
echo "found target language info<br />";
ob_flush();
    }
    else
    {
        echo "target language not found!";
ob_flush();
        oci_close($con);
        die;
    }

    $trans = array();
    // Check if data already exist
    $sql = "select msg_id, source, translated from emt_tx_trans_unit where cat_id=:catid";
        
    $stmt = oci_parse($con, $sql);
    oci_bind_by_name($stmt, ':catid', $catid);
    oci_execute($stmt);
    
    while ($row = oci_fetch_row($stmt))
    {
        $src = is_object($row[1]) ? (string)$row[1]->load() : (string)$row[1];
        $trans[$src][] = (int)$row[0];
        $trans[$src][] = (int)$row[2];
    }
echo "populated current translations(".count($trans).")<br />";
ob_flush();

    libxml_use_internal_errors(true);
    
    if (file_exists($filename)) echo "found xml file.<br />";
        else "could not find xml file.<br />";
ob_flush();
    if (!$xml = simplexml_load_file($filename))
    {
        echo "Failed loading XML\n";
        foreach(libxml_get_errors() as $error) {
            echo "\t", $error->message;
        }
        die;
    }
    libxml_use_internal_errors(false);

echo "loaded xml content<br />";
ob_flush();
    
    $translationUnit = $xml->xpath('//trans');

    $translated = 0;
    $inserted = 0;
    $author = 'amangeldi';

echo "parsed xml items<br />";
ob_flush();
    
    foreach ($translationUnit as $unit)
    {
      $source = (string) $unit->source;
      $msgid = null;
  

      if (!isset($trans[$source]))
      {
          $inserted++;
          
          $sql = "INSERT INTO emt_tx_trans_unit
            (msg_id, cat_id, id, source, target, date_added, date_modified, author, translated) VALUES
            (EMT_TX_TRANS_UNIT_SEQ.nextval, $catid, 1, :message, :target, sysdate, sysdate, :author, :translated)
            RETURNING msg_id into :msgid";

          $stmt = oci_parse($con, $sql);
    
          $target = (string)$unit->target;
          $translated = $target != '' ? 1 : 0;
          
          oci_bind_by_name($stmt, ':message', $source);
          oci_bind_by_name($stmt, ':target', $target);
          oci_bind_by_name($stmt, ':author', $author);
          oci_bind_by_name($stmt, ':translated', $translated);
          oci_bind_by_name($stmt, ':msgid', $msgid);
          
          $result = oci_execute($stmt);

          $trans[$source][] = '';
          $trans[$source][1] = 1;
if ($result) echo "inserted translation record(msgid=$msgid)<br />";
else echo "error while inserting record(msgid=$msgid)<br />";
ob_flush();
      }
      elseif (!$trans[$source][1])
      {
          $msgid = $trans[$source][0];
          $translated++;
          $sql = "update emt_tx_trans_unit set target=:target, translated=1, date_modified=sysdate where msg_id=:msgid";
          $stmt = oci_parse($con, $sql);
          $target = (string)$unit->target;
          oci_bind_by_name($stmt, ':target', $target);
          oci_bind_by_name($stmt, ':msgid', $msgid);
          $result = oci_execute($stmt);

          $trans[$source][1] = 1;
if ($result) echo "updated translation record(msgid=$msgid)<br />";
else echo "error while updating record(msgid=$msgid)<br />";
ob_flush();
      }
    }
    
    echo "Translated: $translated - Inserted: $inserted";
    ob_flush();
    
    oci_close($con);
