<?php require_once('../init.php');
$Auth->vLogin(null, FALSE, TRUE);
/*
API PARA OBTENCION DE REGISTROS DE MENUS

	Params: 
	Name: action
	Options:
		getMenuAll						GET ALL MENUS
		getMenuId						GET MENU ID

		getMenuItemAll					GET ALL MENUS ITEMS
		getMenuItemId					GET ALL MENUS ITEMS BY MENU CONTAINER
		getMenuItemByIdContainer		GET MENU ITEM ID

	Return:
	status			1 = true, 0 = false;
	log				string: return data
	data			data returned
*/
// Params is required for pass action and 
$params = $_REQUEST ?? null;
try {
	$API = new App\Models\Menu_API($params);
	$API->executeAPI();
} catch (Exception $e) {
	echo $e->getMessage();
}