/*
 *	RevCTRL (c) API accesser
 *	 Pawn Version
 *
 * Remember to change the PROJECT_ID and USER_PROJECT
*/

#include 			<a_samp>
#include 			<a_http>
#include 			<zcmd>

// Must change defines

//#define PROJECT_ID  1
#if !defined PROJECT_ID
 #error Define your project id. Find it on your RevCTRL project's about page.
#endif

//#define USER_PROJECT		"IrresistibleDev/SF-CNR" // you can grab it off the API but still it's tedious
#if !defined USER_PROJECT
 #error Define USER_PROJECT with your own project
#endif

// General defines

#define API_URL			"irresistiblegaming.com/rc_updates.php?id=" #PROJECT_ID // You can use your own!!! Check revctrl.php 
#define DIALOG_CHANGES		4000 // change if you want

// Forward

public OnRevCTRLHTTPResponse(index, response_code, data[]);

// Http Response Callback (OnRevCTRLHTTPResponse)

public OnRevCTRLHTTPResponse(index, response_code, data[]) {
	if (response_code != 200) {
		return ShowPlayerDialog(index, DIALOG_CHANGES, DIALOG_STYLE_MSGBOX, "{C0C0C0}" #USER_PROJECT "{FFFFFF} - RevCTRL", "{FFFFFF}An error has occurred, try again later.", "Okay", "");
	}
	return ShowPlayerDialog(index, DIALOG_CHANGES, DIALOG_STYLE_MSGBOX, "{C0C0C0}" #USER_PROJECT "{FFFFFF} - RevCTRL", data, "Okay", "");
}

CMD:updates(playerid, params[]) {
	HTTP(playerid, HTTP_GET, API_URL, "", "OnRevCTRLHTTPResponse");
	return SendClientMessage(playerid, -1, "Reading latest changes from {C0C0C0}www.revctrl.com/" #USER_PROJECT "/latest{FFFFFF}, please wait!");
}
