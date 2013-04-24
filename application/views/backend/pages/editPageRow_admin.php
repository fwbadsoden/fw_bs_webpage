<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $columnCount = $columns['full'] + $columns['empty'];
?>

<tr>
    <td colspan='2'>
        <table>
            <tr>
<?  if(isset($row['boxes']))
    {
        foreach($row['boxes'] as $b) { ?>
                <td width='150'></td>
<?      } 
    }
?>
            </tr>
            <tr><td colspan='<?=$columnCount?>'><strong>Zeile <?=$row['rowName']?></strong></td></tr>
<?
    if($columns['empty'] > 0) {
?>
            <tr>
                <td><a href="<?=base_url('admin/content/page/addbox/'.$row['rowID'])?>" class="button_mini" title="Inhaltselement hinzuf&uuml;gen"><span class='button_add_small'></span></a></td><td>Inhaltselement hinzuf&uuml;gen</td>
            </tr>
<?
    } else {
?>
            <tr>
                <td colspan='<?=$columnCount?>'>keine weiteren Inhalte m&ouml;glich</td>
            </tr>
<?
    }
    if(isset($row['boxes']))
    {
    ?>      <tr>    <?
        foreach($row['boxes'] as $b) 
        { 
        ?>
                <td colspan='<?=$b['columnCount']?>'><a href='<?=site_url('admin/content/page/addboxcontent/'.$b['boxID'])?>'><img src='<?=base_url('/images/admin/pages/'.$b['boxImg'])?>'></a></td>        
        <?         
        }
            
    ?>      
                <td colspan='<?=$columns['empty']?>'></td>
            </tr>   <?
    }
?>
        </table>
    </td>
</tr>