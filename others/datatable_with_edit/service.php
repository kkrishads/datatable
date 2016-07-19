<?php
/**
 *
 * PHP AJAX Calendar
 * http://www.script-tutorials.com/datatables-data-from-ajax-edit-in-place/
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Script Tutorials
 * http://www.script-tutorials.com/
 if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);
 */

// set error reporting level



if ($_GET) {
    require_once('classes/CMySQL.php');
    switch ($_GET['action']) {
        case 'getMembersAjx':
            getMembersAjx();
            break;
        case 'updateMemberAjx':
            updateMemberAjx();
            break;
        case 'deleteMember':
            deleteMember();
            break;
    }
    exit;
}

function getMembersAjx() {

    // SQL limit
    $sLimit = '';
    if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
        $sLimit = 'LIMIT ' . (int)$_GET['iDisplayStart'] . ', ' . (int)$_GET['iDisplayLength'];
    }

    // SQL order
    $aColumns = array('company', 'model', 'price', 'image', 'summary', 'spec_status');
    $sOrder = '';
    if (isset($_GET['iSortCol_0'])) {
        $sOrder = 'ORDER BY  ';
        for ($i=0 ; $i<(int)$_GET['iSortingCols'] ; $i++) {
            if ( $_GET[ 'bSortable_'.(int)$_GET['iSortCol_'.$i] ] == 'true' ) {
                $sOrder .= '`'.$aColumns[ (int)$_GET['iSortCol_'.$i] ].'` '.
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .', ';
            }
        }

        $sOrder = substr_replace($sOrder, '', -2);
        if ($sOrder == 'ORDER BY') {
            $sOrder = '';
        }
    }

    // SQL where
    $sWhere = 'WHERE 1';
    if (isset($_GET['sSearch']) && $_GET['sSearch'] != '') {
        $sWhere = 'WHERE 1 AND (';
        for ($i=0; $i<count($aColumns) ; $i++) {
            if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == 'true') {
                $sWhere .= '`' . $aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch'])."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, '', -3 );
        $sWhere .= ')';
    }

    $aMembers = $GLOBALS['MySQL']->getAll("SELECT * FROM `mobile_list` {$sWhere} {$sOrder} {$sLimit}");
    $iCnt = (int)$GLOBALS['MySQL']->getOne("SELECT COUNT(`Id`) AS 'Cnt' FROM `mobile_list` WHERE 1");

    $output = array(
        'sEcho' => intval($_GET['sEcho']),
        'iTotalRecords' => count($aMembers),
        'iTotalDisplayRecords' => $iCnt,
        'aaData' => array()
    );
    foreach ($aMembers as $iID => $aInfo) {
        $aItem = array(
            $aInfo['company'], $aInfo['model'], $aInfo['price'], $aInfo['image'], $aInfo['summary'], $aInfo['spec_status'], 'DT_RowId' => $aInfo['Id']
        );
        $output['aaData'][] = $aItem;
    }
    echo json_encode($output);
}
function updateMemberAjx() {
 // SQL order
    $aColumns = array('company', 'model', 'price', 'image', 'summary', 'spec_status');
    $sVal = $GLOBALS['MySQL']->escape($_POST['value']);

    $iId = (int)$_POST['id'];
	echo $_POST['columnName']."-".$iId;
    if ($iId && $sVal !== FALSE) {
			
        switch ($_POST['columnName']) {
		
            case $aColumns[0]:
			
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET ". $aColumns[0]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
          case $aColumns[1]:
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET ". $aColumns[1]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
           case $aColumns[2]:
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET ". $aColumns[2]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
            case $aColumns[3]:
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET ". $aColumns[3]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
            case $aColumns[4]:
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET ". $aColumns[4]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
            case $aColumns[5]:
                $GLOBALS['MySQL']->res("UPDATE `mobile_list` SET". $aColumns[5]."='{$sVal}' WHERE `Id`='{$iId}'");
                break;
        }
		
        echo 'Successfully saved';
    }
    exit;
}
function deleteMember() {
    $iId = (int)$_POST['id'];
    if ($iId) {
        $GLOBALS['MySQL']->res("DELETE FROM `mobile_list` WHERE `Id`='{$iId}'");
		
        return;
    }
    echo 'Error';exit;
}