<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $columnCount = $columns['full'] + $columns['empty'];     
?>

    <tr>
        <td>
            <table>
                <tr>
                    <td class="button">
                        <table>
                            <tr><td><a href="<?=base_url('admin/content/page/row/checkdel/'.$row['rowID'].'/'.$content['pageID'])?>" class="button_mini" title="Zeile l&ouml;schen"><span class='button_delete_small'></span></a></tr>
<?  if($row['orderID'] == 1) { ?>
                            <tr><td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td></tr>
<?  } else { ?>
                            <tr><td><a href="<?=base_url('admin/content/page/row/order/up/'.$row['rowID'])?>" class="button_mini" title="Zeile nach oben schieben"><span class='button_up_small'></span></a></td></tr>
<?  } if($row['orderID'] >= $content['rowCount']) { ?>
                            <tr><td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td></tr>
<?  } else { ?>   
                            <tr><td><a href="<?=base_url('admin/content/page/row/order/down/'.$row['rowID'])?>" class="button_mini" title="Zeile nach unten schieben"><span class='button_down_small'></span></a></td></tr>
<?  } ?>                            
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr><td><strong>Zeile <?=$row['orderID']?></strong></td></tr>
                            <tr>
                                <td>
                                    <table>
<? if($columns['empty'] > 0) { ?>
                                        <tr>
                                            <td colspan='<?=$columnCount?>'>
                                                <table>
                                                        <tr>
                                                            <td><a href="<?=base_url('admin/content/page/box/add/'.$row['rowID'])?>" class="button_mini" title="Inhaltselement hinzuf&uuml;gen"><span class='button_add_small'></span></a></td><td>Inhaltselement hinzuf&uuml;gen</td>
                                                        </tr>
                                                </table>
                                            </td>
                                        </tr>
<?  } else { ?>      
                                        <tr>
                                            <td colspan='<?=$columnCount?>'>keine weiteren Inhalte m&ouml;glich</td>
                                        </tr>            
<?  } if(isset($row['boxes'])) { ?>  
                                        <tr>    

<?      
        foreach($row['boxes'] as $b) 
        {           
            if($b['specialBox'] == 0) 
            {
                $boxTagNames = explode(PAGES_BOX_TAGS_SEPARATOR, $b['boxTagsNames']);
                $i = 0;   
?>
                                            <td width='30'>
                                                <table>
                                                    <tr><td><a href="<?=base_url('admin/content/page/box/checkdel/'.$b['rowContentID'])?>" class="button_mini" title="Inhaltselement l&ouml;schen"><span class='button_delete_small'></span></a></td></tr>
                                                </table>
                                            </td>
                                            <td colspan='<?=$b['columnCount']?>'>
                                                <table>

<?              foreach($b['content'] as $c) { ?>                                           
                                            
                                                    <tr><td><a href='<?=site_url('admin/content/page/box/content/edit/'.$b['rowContentID'].'/'.$c['boxContentID'])?>' title="Inhalt bearbeiten"><?=$boxTagNames[$i]?> bearbeiten</a></td></tr>
                                            
                                            
<?          
                    $i++;
                } 
?>                                            
                                                </table>
                                            </td>
<?          } else { ?>
                                            <td width='30'>
                                                <table>
                                                    <tr><td><a href="<?=base_url('admin/content/page/box/checkdel/'.$b['rowContentID'])?>" class="button_mini" title="Inhaltselement l&ouml;schen"><span class='button_delete_small'></span></a></td></tr>
                                                </table>
                                            </td>
                                            <td colspan='<?=$b['columnCount']?>'><?=$b['boxName']?></td>
<?          } ?>        
        
<?      } ?>   
                                            <td colspan='<?=$columns['empty']?>'></td>
                                        </tr>
<?  } ?>                                                                                                  
                                    </table>    
                                </td>
                            </tr>
                        </table>    
                    </td>
                </tr>
            </table>
        </td>
    </tr>               