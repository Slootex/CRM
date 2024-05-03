<?php
use App\Http\Controllers\Buchhaltung_CONTROLLER;
use App\Http\Controllers\kunde;
use App\Http\Controllers\mailInbox;
use App\Mail\errorMail;
use App\Models\mahnungstext;
use App\Models\tracking;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auftrags_CONTROLLER;
use App\Http\Controllers\packtisch_CONTROLLER;
use App\Http\Controllers\Settings;
use App\Models\order_id;
use App\Models\new_orders_person_declaration;
use App\Models\new_order_accepten;
use App\Models\new_orders_car_declaration;
use App\Models\new_leads_person_data;
use App\Models\new_leads_car_data;
use App\Models\statuse;
use App\Models\employee_account;
use App\Models\status_histori;
use App\Models\maindata;
use App\Models\email_templates;
use App\Models\shelfe;
use App\Models\order_process_data;
use App\Models\device_orders;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use App\Form;
use App\Http\Controllers\employee;
use App\Http\Controllers\googleAPI;
use App\Http\Controllers\kundenkonto as ControllersKundenkonto;
use App\Http\Controllers\rechnung;
use App\Mail\repair_contract;
use App\Models\active_orders_person_data;
use App\Models\archive_lead_person_data;
use App\Models\archive_orders_person;
use App\Models\artikel;
use App\Models\component_name;
use App\Models\contact;
use App\Models\countrie;
use App\Models\employee as ModelsEmployee;
use App\Models\kundenkonto;
use App\Models\mahneinstellungen;
use App\Models\rechnungen;
use App\Models\rechnungstext;
use App\Models\User;
use Google\Service\Calendar\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
    >>>>>>>>>>>>>>>>>>>>>>> GET  to  VIEW <<<<<<<<<<<<<<<<<<<<<<<<
*/


Route::get('/crm/neue-interessenten/neuen-interessent', function() {
    return view("forMitarbeiter/interessenten/neuen_interessent_anlegen");
});
Route::get('awdawd', function() {
    return view("forMitarbeiter/interessenten/neuen_interessent_anlegen");
});
Route::get('employee/login', function() {
    return view("forMitarbeiter/login");
});
Route::get("/crm/change/device/{id}", [auftrags_CONTROLLER::class, "changeDeviceView"]);
/*
    >>>>>>>>>>>>>>>>>>>>>>> GET  to  CONTROLLER <<<<<<<<<<<<<<<<<<<<<<<<
*/

Route::get("crm/packtisch/lagerplatzübersicht/bearbeiten/{id}", [packtisch_CONTROLLER::class, "getShelfeEditView"])->middleware(["auth"]);
Route::get("crm/packtisch/lagerplatzübersicht/entsorgungssperre-aktivieren/{id}", [packtisch_CONTROLLER::class, "entsorgungssperreAktivieren"])->middleware(["auth"]);
Route::get("crm/packtisch/lagerplatzübersicht/entsorgungssperre-deaktivieren/{id}", [packtisch_CONTROLLER::class, "entsorgungssperreDeaktivieren"])->middleware(["auth"]);

Route::get("/", [packtisch_CONTROLLER::class, "packtischView"])->middleware(["auth"]);
Route::view("/status", "frontend/status");
Route::post("status-abfragenn", [auftrags_CONTROLLER::class, "getStatusView"]);
Route::post("/crm/change-shelfe", [packtisch_CONTROLLER::class, "changeShelfeComponent"]);

Route::post("crm/profile/change/{id}", [employee::class, "changeProfile"]);
Route::get("crm/profile/picture/delete/{id}", [employee::class, "deleteProfilePicture"]);
Route::get("/crm/profile/back", function() {
    return redirect()->back();
});

Route::get("crm/mailinbox", [Settings::class, "mailInboxView"]);
Route::get("/crm/emailInbox/anschauen/{id?}", [Settings::class, "mailInboxBearbeitenView"]);
Route::get("/crm/emailInbox/zuweisen-{account}", [Settings::class, "mailInboxZuweisen"]);
Route::get("/crm/contact/delete/{id}", [Settings::class, "deleteContact"]);
Route::get("/crm/warenausgang/pick-list", [Settings::class, "getPicklistAusgang"]);
Route::get('crm/get-kundendaten-modal-{id}', [auftrags_CONTROLLER::class, "editKundenData"])->middleware(["auth"]);
Route::get('crm/kundendaten-lieferaddresse-toggle-{id}', [auftrags_CONTROLLER::class, "toggleKundedatenLieferaddresse"])->middleware(["auth"]);
Route::post("/crm/interessent/neuer-telefontext", [auftrags_CONTROLLER::class, "neuerTelefonText"]);
Route::post("/crm/interessent/neuer-auftragshistorientext", [auftrags_CONTROLLER::class, "neuerAuftragsText"]);
Route::get('crm/auftrag-move-archiv-{id}', [auftrags_CONTROLLER::class, "moveOrderToArchiv"])->middleware(["auth"]);
Route::get('crm/auftrag-move-active-{id}', [auftrags_CONTROLLER::class, "moveOrderToActive"])->middleware(["auth"]);

Route::get("/crm/tracking/delete-sendungsnummer-{id}", [Settings::class, "deleteTrackingHistory"]);
Route::get("crm/tracking-get-history-{id}", [Settings::class, "getTrackingHistory"]);
Route::post("/crm/tracking/neue-sendungsnummer", [Settings::class, "setNewTrackingnumber"]);
Route::post("/crm/emailInbox/zuweisenManuel", [Settings::class, "mailInboxZuweisenManuel"]);
Route::post("/shelfe/count/single", [Settings::class, "changeShelfeSingleCount"]);
Route::post("/shelfe/count/multiple", [Settings::class, "changeShelfeMultipleCount"]);
Route::get("crm/auftrag-archiv", [auftrags_CONTROLLER::class, "orderAchivView"]);
Route::get('/crm/bookings/{id}', [auftrags_CONTROLLER::class, "bookings_view"]);
Route::get("/crm/label/get/{id}/{shortcut?}", [auftrags_CONTROLLER::class, "getLabel"]);
Route::get("/crm/zuweisen/zurück/{id}/{process_id}", [Settings::class, "deleteZuweisen"]);
Route::get("crm/email/get/{id}/{pr_id}", [auftrags_CONTROLLER::class, "getEmail"]);
Route::get('/crm/neuer-auftrag', [auftrags_CONTROLLER::class, "new_order_view"]);
Route::get('/crm/auftraege-neues-geraet/{id}', [auftrags_CONTROLLER::class, "new_device"]);
Route::get('employee/change/{id}', [auftrags_CONTROLLER::class, "Change_lead_view"]);
Route::get('test', [auftrags_CONTROLLER::class, "fillShelfDatabase"]);
Route::post('/crm/auftrag-hinweis-edit', [auftrags_CONTROLLER::class, "editAuftragHinweis"]);
Route::get('crm/archive/order/{id}', [auftrags_CONTROLLER::class, "changeArchivView"]);
Route::get('crm/interessenten-archiv', [auftrags_CONTROLLER::class, "leadArchivView"]);
Route::get('/crm/lagerplatz/bearbeiten/{id}', [packtisch_CONTROLLER::class, "lagerplatzBearbeiten"]);

Route::post("/crm/moveto/archive/leads/{id}", [auftrags_CONTROLLER::class, "moveToLeadsArchive"]);
Route::post("/crm/moveto/archive/orders/{id}", [auftrags_CONTROLLER::class, "moveToOrdersArchive"]);
Route::get('awd', [auftrags_CONTROLLER::class, "send_repair_contract"]);
Route::get('crm/email-vorlagen', function() {
    return view("forMitarbeiter/crm/email/mail_main_view");
});
Route::get('crm/get-scannermode', [employee::class, "getScannermodus"]);
Route::post("crm/set-scannermode", [employee::class, "setScannermodus"]);
Route::post("crm/change/barcodespecialchar", [Settings::class, "setBarcodeSpecialChar"]);
Route::get('crm/orders/change/{id}', ['as' => 'custom_paint',auftrags_CONTROLLER::class, "change_order_view"])->name("testtt");
Route::get('crm/neue-packtische', [packtisch_CONTROLLER::class, "packtisch_view"]);
Route::post("crm/intern/auftrag/{id}", [packtisch_CONTROLLER::class, "intern_auftrag_view"]);
Route::post("crm/helpercode/auftrag/{helpercode}/{shelfe}", [packtisch_CONTROLLER::class, "helpercode_auftrag_view"]);
Route::get("/crm/auftrag/pdf/{id}/{process_id?}/{gerätedaten?}/{get?}", [packtisch_CONTROLLER::class, "auftrag_pdf"]);
Route::get("/crm/versenden", [packtisch_CONTROLLER::class, "versendenView"]);
Route::get("/crm/abholung", [packtisch_CONTROLLER::class, "getAbholauftragView"]);
Route::get("/crm/abholung/get/{id}", [packtisch_CONTROLLER::class, "getAbholauftragAuftrag"]);
Route::get("/crm/abholung/delete/{id}", [packtisch_CONTROLLER::class, "deleteAbholauftrag"]);
Route::get("/crm/abholung/contact/{id}", [packtisch_CONTROLLER::class, "getAbholauftragAdressbuch"]);
Route::post("/crm/abholung/beauftragen", [packtisch_CONTROLLER::class, "postAbholungBeauftragen"]);
Route::get("/crm/shipping/status/{id}/{process_id}", [auftrags_CONTROLLER::class, "getShippingStatusView"]);
Route::get("/crm/get-order-row-{id}", [auftrags_CONTROLLER::class, "getOrder"]);

Route::get("crm/search-orders/{key}", [Settings::class, "searchOrders"]);


Route::post("/crm/device/add/primary/{id}", [auftrags_CONTROLLER::class, "addPrimaryDevice"]);
Route::post("/crm/hilfscode-an-packtisch/{id}", [packtisch_CONTROLLER::class, "helpercodeToPacktisch"]);
Route::get("crm/einkauf/neuer-einkauf" , [auftrags_CONTROLLER::class, "getNeuerEinkaufModal"]);

Route::post("/crm/upload/files/{id}/{tab?}", [auftrags_CONTROLLER::class, "uploadFiles"]);
Route::post("/crm/change/car/data/{id}/{gerät?}", [auftrags_CONTROLLER::class, "changeCarData"]);
Route::post("/crm/change/car/data/interessent/{id}/{gerät?}", [auftrags_CONTROLLER::class, "changeCarDataInteressent"]);
Route::get("/crm/hilfscode/versenden/{id}" , [packtisch_CONTROLLER::class, "sendHelperCode"]);
Route::get("/crm/warenausgang/zurück/{id}" , [packtisch_CONTROLLER::class, "warenausgangZurück"]);
Route::get("/crm/warenausgang/label/delete/{id}" , [packtisch_CONTROLLER::class, "warenausgangLabelLöschen"]);
Route::get("/crm/email/bearbeiten/order/{emailid}/{id}" , [auftrags_CONTROLLER::class, "emailOrderBearbeitenView"]);
Route::get("crm/kundenübersicht-aktiv" , [auftrags_CONTROLLER::class, "getKundenübersichtView"]);
Route::get("crm/einkaufsübersicht-aktiv" , [auftrags_CONTROLLER::class, "getEinkaufsübersichtView"]);
Route::get("crm/reklamationsübersicht-aktiv" , [auftrags_CONTROLLER::class, "getReklamationsübersichtView"]);
Route::get("crm/reklamation/sortieren-{field}-{type}" , [Settings::class, "sortReklamationsübersicht"]);
Route::get("/crm/einkauf/delete-einkauf-{id}" , [auftrags_CONTROLLER::class, "deleteEinkauf"]);
Route::get("/crm/einkauf/delete-reverse-{id}" , [auftrags_CONTROLLER::class, "deleteEinkaufReverse"]);
Route::get("/crm/einkauf/archiv" , [auftrags_CONTROLLER::class, "getEinkaufArchiv"]);
Route::post("/crm/reklamation-kategorie-bearbeiten", [Settings::class, "changeReklamationKategorie"]);
Route::post("/crm/neuer-auftrag-check", [auftrags_CONTROLLER::class, "checkNewOrder"]);
Route::get("/crm/reklamation/delete-{id}" , [auftrags_CONTROLLER::class, "deleteReklamation"]);
Route::post("/crm/kunden/filter" , [auftrags_CONTROLLER::class, "filterKundenübersicht"]);

Route::post("/crm/change/contact/{id}", [auftrags_CONTROLLER::class, "changeContact"]);
Route::post("/crm/shelfe/to-archive", [auftrags_CONTROLLER::class, "fachZuArchive"]);
Route::post("/crm/fach/to-aktive", [auftrags_CONTROLLER::class, "fachZuAktive"]);

Route::post("/crm/change/dateiverteilen", [Settings::class, "changeZuteilenFileName"]);
Route::get("/crm/change/nightmode", [Settings::class, "changeNightMode"]);
Route::get("/crm/sendmahnung/{id}", [rechnung::class, "sendMahnung"]);

Route::post("/crm/regal/to-archive", [auftrags_CONTROLLER::class, "regalZuArchive"]);
Route::post("/crm/regal/to-aktive", [auftrags_CONTROLLER::class, "regalZuAktive"]);
Route::post("/crm/delete/shelfe", [auftrags_CONTROLLER::class, "regalLöschen"]);
Route::post("/crm/add/shelfe", [auftrags_CONTROLLER::class, "regalHinzufügen"]);
Route::post("/crm/email/custom/send", [auftrags_CONTROLLER::class, "sendCustomEmail"]);
Route::post("/crm/emailinbox/upload-eml", [Settings::class, "uploadEML"]);
Route::post("/crm/zeiterfassung/upload-csv", [Settings::class, "uploadCSVFeiertage"]);

Route::post("/crm/auftraghistory/new/message/{id}", [auftrags_CONTROLLER::class, "auftragshistory_new_message"]);
Route::post("/crm/new/booking/{id}", [auftrags_CONTROLLER::class, "new_booking"]);
Route::post("/crm/orders/search/{type?}", [auftrags_CONTROLLER::class, "search_orders"]);
Route::post("/crm/phone/new/message/{id}", [auftrags_CONTROLLER::class, "phone_new_message"]);
Route::post("/crm/phone/new/message/{id}/order", [auftrags_CONTROLLER::class, "phoneNewMessageOrder"]);
Route::post("/crm/change/status/order/{id}", [auftrags_CONTROLLER::class, "form_change_status_order"]);
Route::post("/crm/moveto/orders/{id}", [auftrags_CONTROLLER::class, "moveto_orders"]);
Route::post("/crm/moveto/interessenten/{id}", [auftrags_CONTROLLER::class, "moveto_leads"]);
Route::post("crm/auftraege-neues-geraet/{id}", [auftrags_CONTROLLER::class, "add_device"]);
Route::post("crm/intern/add/{id}", [auftrags_CONTROLLER::class, "add_intern"]);
Route::post("crm/send/email/{id}", [auftrags_CONTROLLER::class, "send_email_lead"]);
Route::post("crm/comparison/{id}", [auftrags_CONTROLLER::class, "order_comarison"]);
Route::post("crm/assign/{id}", [auftrags_CONTROLLER::class, "assign"]);
Route::post("/crm/send/email/order/{id}", [auftrags_CONTROLLER::class, "send_email_order"]);
Route::post("/crm/change/email_status/order/{id}", [auftrags_CONTROLLER::class, "send_email_lead"]);
Route::post('order_ready_step_one', [auftrags_CONTROLLER::class, "ready_step_one"]);
Route::post('add_component', [auftrags_CONTROLLER::class, "add_component"]);
Route::post('order_ready_step_two', [auftrags_CONTROLLER::class, "ready_step_two"]);
Route::post('order_form_send', [auftrags_CONTROLLER::class, "order_form_send"]);
Route::post('employee/login', [auftrags_CONTROLLER::class, "employee_login"]);
Route::post('employee/neuen-auftrag/anlegen', [auftrags_CONTROLLER::class, "add_new_order"]);
Route::post('/crm/einkauf-aktiv/neue-position', [auftrags_CONTROLLER::class, "neuerEinkaufAnlegen"]);
Route::post('/crm/einkaufsübersicht-aktiv/neuer-einkauf', [auftrags_CONTROLLER::class, "einkaufZusammenfassen"]);
Route::post('/crm/kunde-bearbeiten/position', [auftrags_CONTROLLER::class, "einkaufPositionBearbeiten"]);
Route::get('/crm/kunde-bearbeiten/get-positions-{id}', [auftrags_CONTROLLER::class, "getEinkaufsPositionen"]);
Route::get('/crm/kunde-bearbeiten/position-{id}', [auftrags_CONTROLLER::class, "getEinkaufPositionBearbeiten"]);
Route::get('/crm/kunde-bearbeiten/get-einkauf-{id}', [auftrags_CONTROLLER::class, "getEinkauf"]);
Route::get('/crm/kunde-bearbeiten/delete-position-{id}', [auftrags_CONTROLLER::class, "deleteEinkaufPosition"]);
Route::get('/crm/check-auftragsnummer-{id}', [auftrags_CONTROLLER::class, "checkAuftragsnummer"]);
Route::post('crm/neuer-auftrag/auftragsuche', [kunde::class, "getAuftragById"]);
Route::post('crm/neuer-interessent/auftragsuche', [kunde::class, "getInteressentById"]);
Route::post('employee/neuen-interessenten/anlegen', [auftrags_CONTROLLER::class, "add_new_interessenten"]);
Route::post('crm/einstellungen/signatur', [Settings::class, "changeSignatur"]);
Route::post('/crm/change/lead_data/{id}', [auftrags_CONTROLLER::class, "change_lead_data"]);
Route::post('/crm/change/order_data/{id}', [auftrags_CONTROLLER::class, "change_order_data"]);
Route::post('/crm/change/interessenten_data/{id}', [auftrags_CONTROLLER::class, "change_interessenten_data"]);
Route::post("/crm/device/delete/{id}", [auftrags_CONTROLLER::class, "deleteDevice"])->middleware("device.inuse:{id}");
Route::post("/crm/change/device/data/{id}", [auftrags_CONTROLLER::class, "changeDeviceData"]);
Route::get("crm/delete/file/{id}/{filename}/{tab}", [auftrags_CONTROLLER::class, "deleteFile"]);
Route::post("/crm/foto/complete/{id}", [packtisch_CONTROLLER::class, "complete_foto"]);

Route::post('/crm/wareneingang/neu/{id}', [packtisch_CONTROLLER::class, "new_device"]);
Route::post("/crm/warenausgang/view/{id}", [packtisch_CONTROLLER::class, "warenausgang_view"]);
Route::post('/crm/shipping/device', [packtisch_CONTROLLER::class, "shipping_device"]);
Route::post('/crm/to/packtisch/{id}/{type?}', [packtisch_CONTROLLER::class, "packtisch_request"]);
Route::post('/crm/add/component/{id?}', [packtisch_CONTROLLER::class, "new_device_view"]);
Route::post("/crm/shipping/device_cart", [packtisch_CONTROLLER::class, "device_cart_add"]);
Route::post("/crm/shipping/new/", [packtisch_CONTROLLER::class, "shipping_new"]);
Route::post("/crm/shipping/new/{id}/{warenausgang}", [packtisch_CONTROLLER::class, "warenausgang_shipping"]);
Route::post("/crm/shipping/new/{id}/tec/tec", [packtisch_CONTROLLER::class, "warenausgang_shipping_tec"]);
Route::post("/crm/globale-suche", [packtisch_CONTROLLER::class, "global_search"]);
Route::post("/crm/filter/globale-suche", [packtisch_CONTROLLER::class, "filterGlobaleSuche"]);
Route::post("/crm/umlagerungsauftrag/{component_number}", [packtisch_CONTROLLER::class, "umlagerungsauftrag_finish"]);
Route::GET("/crm/lagerplatzübersicht/change/{id}" , [packtisch_CONTROLLER::class, "changeLagerplatsübersichtView"]);
Route::get("/crm/get/barcode/{barcode}", [packtisch_CONTROLLER::class, "getBarcode"]);
Route::get("/crm/packtisch/ausgang-sperren-{id}", [packtisch_CONTROLLER::class, "warenausgangEinzelnSperren"]);
Route::get("/crm/packtisch/ausgang-entsperren-{id}", [packtisch_CONTROLLER::class, "warenausgangEinzelnEntsperren"]);
Route::get("/crm/packtisch/warenausgang-bearbeiten/{id}", [packtisch_CONTROLLER::class, "getWarenausgangView"]);
Route::get("/crm/packtisch/warenausgang-bearbeiten-techniker/{id}", [packtisch_CONTROLLER::class, "getWarenausgangTechnikerView"]);
Route::post("/crm/add/helper/device/{helpercode}/{shelfe}", [packtisch_CONTROLLER::class, "addHelperBarcode"]);
Route::post("/crm/helpercode/assign/view/{helpercode}", [packtisch_CONTROLLER::class, "addHelperBarcode"]);
Route::post("/crm/packtisch/inventur", [packtisch_CONTROLLER::class, "inventurView"]);
Route::post("/crm/finish/inventur", [packtisch_CONTROLLER::class, "inventurAbschließen"]);
Route::post("/crm/packtisch/entsorgung/complete", [packtisch_CONTROLLER::class, "warenausgang_entsorgung_shipping"]);
Route::post("/crm/change/permission", [Settings::class, "changePermission"]);
Route::post("/crm/delete/permission", [Settings::class, "deletePermission"]);

Route::get("/crm/entsorgung/extendtime/{id}", [packtisch_CONTROLLER::class, "entsorgungZeitVerlängern"]);
Route::get("/crm/entsorgung/minustime/{id}", [packtisch_CONTROLLER::class, "entsorgungZeitKürzen"]);
Route::get("/crm/lagerplatübersicht/filter/{id}", [packtisch_CONTROLLER::class, "lagerplatzÜbersichtFilterLager"]);
Route::get("/crm/auftrag/get-entsorgung/{id}", [packtisch_CONTROLLER::class, "getShelfeEditModal"]);

Route::post("tables/see", [auftrags_CONTROLLER::class, "seeTable"]);
Route::post("change/records/{tablename}", [auftrags_CONTROLLER::class, "changeRecords"]);
Route::post("new/record/{tablename}", [auftrags_CONTROLLER::class, "addRecord"]);
Route::get("tables" , [auftrags_CONTROLLER::class, "tablePage"]);
Route::get("/crm/get/device-shelfe/{id}" , [packtisch_CONTROLLER::class, "checkDeviceShelfe"]);
//Route::view("error", "forEmployees/administration/error");
Route::get("crm/logout" , [employee::class, "logoutEmployee"]);
Route::post("/crm/warenausgang/zusammenfassen", [packtisch_CONTROLLER::class, "getWarenausgangZusammenfassen"]);

Route::post("/crm/filter/orders", [auftrags_CONTROLLER::class, "aufträgeFiltern"]);
Route::post("/crm/tagesabschluss", [packtisch_CONTROLLER::class, "tagesabschlussAbschließen"]);
Route::get("/crm/globale-suche/keyword/{word}", [auftrags_CONTROLLER::class, "getGlobaleSucheKeyword"]);
Route::post("employee/login", [employee::class, "loginEmployee"]);
Route::post("/crm/umlagerungsauftrag-archive/{id}", [packtisch_CONTROLLER::class, "umlagerungsauftragArchive"]);
Route::post("/crm/packtisch/ausgang/complete/{id}", [packtisch_CONTROLLER::class, "warenausgang_shipping"]);
Route::post("/crm/packtisch/extern/complete", [packtisch_CONTROLLER::class, "completeExternAusgang"]);
Route::post("crm/packtisch/Fotoauftrag/{id}", [packtisch_CONTROLLER::class, "fotoauftragView"]);
Route::post("crm/packtisch/Umlagerungsauftrag/{id}", [packtisch_CONTROLLER::class, "umlagerungsauftragView"]);
Route::post("crm/packtisch/Beschriftungsauftrag/{id}", [packtisch_CONTROLLER::class, "beschriftungsauftragView"]);
Route::get("crm/packtisch/Umlagerungsauftrag-Archive/{id}", [packtisch_CONTROLLER::class, "umlagerungsauftragArchiveView"]);
Route::get("crm/transportschaden/{id}/{comp}", [packtisch_CONTROLLER::class, "transportschadenView"]);
Route::post("/crm/packtisch/kein-barcode/{id}/{shelfe}", [packtisch_CONTROLLER::class, "keinBarcode"]);
Route::post("/crm/beschriftungsauftrag/{id}", [packtisch_CONTROLLER::class, "beschriftungsauftragErledigt"]);
Route::post("/crm/transportschaden", [packtisch_CONTROLLER::class, "transportschadenBeauftragen"]);
Route::get("/crm/transportschaden/{id}/", [packtisch_CONTROLLER::class, "transportschadenBearbeitenView"]);
Route::get("/crm/check/labelcount/{id}", [packtisch_CONTROLLER::class, "technikerVersandLabelCheck"]);
Route::get("/crm/roles", [Settings::class, "rollenView"]);
Route::get("/crm/rolle/neu", [Settings::class, "rollenBearbeitenNeu"]);
Route::post("/crm/rolle/neu", [Settings::class, "rolleNeu"]);
Route::get("/crm/roles/neu", [Settings::class, "rollenBearbeitenNeu"]);
Route::get('/crm/email/delete-zuweisung-{id}', [Settings::class, "emailZuweisungDelete"])->middleware(["auth"]);
Route::post('/crm/export-order-files', [auftrags_CONTROLLER::class, "exportOrderFiles"])->middleware(["auth"]);
Route::post('/crm/auftrag/neuer-text-quick', [auftrags_CONTROLLER::class, "neuerAuftragTextQuick"])->middleware(["auth"]);
Route::get('crm/interessent-move-active-{id}', [auftrags_CONTROLLER::class, "moveto_orders"])->middleware(["auth"]);
Route::get('crm/interessent-move-leads-{id}', [auftrags_CONTROLLER::class, "moveto_leads"])->middleware(["auth"]);
Route::get('crm/interessent-move-archiv-{id}', [auftrags_CONTROLLER::class, "moveToArchiveLeads"])->middleware(["auth"]);
Route::get('crm/interessent-move-activeleads-{id}', [auftrags_CONTROLLER::class, "moveToActiveLeads"])->middleware(["auth"]);
Route::get('crm/tracking-get/{id}', [auftrags_CONTROLLER::class, "getCustomTracking"])->middleware(["auth"]);
Route::get('/crm/auftrag/tracking-view-{id}', [auftrags_CONTROLLER::class, "getTrackingTableView"])->middleware(["auth"]);
Route::get('/crm/tracking/search-like-{inp}-{id}', [auftrags_CONTROLLER::class, "getTrackingLike"])->middleware(["auth"]);
Route::get('crm/order/check-bpz-{id}-{dev}', [auftrags_CONTROLLER::class, "checkBPZUpload"])->middleware(["auth"]);
Route::get('email-inbox/search/{account}-{inp}', [Settings::class, "searchEmailInbox"])->middleware(["auth"]);
Route::get('/crm/order/zuweisung-checked/{id}', [auftrags_CONTROLLER::class, "setHistorientextZuweisungChecked"])->middleware(["auth"]);

Route::get('crm/auftrag-bearbeiten-{id}', [auftrags_CONTROLLER::class, "getOrderNewTab"])->middleware(["auth"]);
Route::get('/crm/auftragsübersicht-aktiv', [auftrags_CONTROLLER::class, "active_orders_view"])->middleware(["auth"]);
Route::get('/crm/auftragsübersicht-archiv', [auftrags_CONTROLLER::class, "getArchiveOrders"])->middleware(["auth"]);
Route::get('/crm/hinweis-löschen-{id}', [packtisch_CONTROLLER::class, "deleteHinweis"])->middleware(["auth"]);
Route::get('crm/tracking/auftrag-aktiv-{id}', [auftrags_CONTROLLER::class, "active_orders_viewTracking"])->middleware(["auth"]);
Route::get('crm/tracking/interessenten-aktiv-{id}', [auftrags_CONTROLLER::class, "active_leads_viewTracking"])->middleware(["auth"]);
Route::get('/crm/statuscode-select-delete-{id}', [Settings::class, "deleteStatuscodeSelect"])->middleware(["auth"]);
Route::get('/crm/statuscodes-bearbeiten', [Settings::class, "getStatuscodesBearbeiten"])->middleware(["auth"]);
Route::get('/crm/statuscode-select-neu', [Settings::class, "getStatuscodesSelectNeu"])->middleware(["auth"]);
Route::get('/crm/statuscode-select-delete-{id}', [Settings::class, "deleteStatuscodeSelect"])->middleware(["auth"]);
Route::post('/crm/statuscodes-select-neu', [Settings::class, "newStatuscodesSelect"])->middleware(["auth"]);

Route::post("/crm/change-kundendaten", [auftrags_CONTROLLER::class, "changeKundenDatenSave"]);
Route::get('crm/aufträge/sortieren-{type}-{sort}', [auftrags_CONTROLLER::class, "sortActivOrdersMain"])->middleware(["auth"]);
Route::get('crm/archiv/sortieren-{type}-{sort}', [auftrags_CONTROLLER::class, "sortArchivOrdersMain"])->middleware(["auth"]);

Route::get('/crm/get-emailinbox', [Settings::class, "getEmailInboxView"])->middleware(["auth"]);
Route::get('/crm/set-spam-{id}', [Settings::class, "setEmailToSpam"])->middleware(["auth"]);

Route::get('/crm/interessentenübersicht-aktiv', [auftrags_CONTROLLER::class, "interessentenView"])->middleware(["auth"]);
Route::get('/crm/interessentenübersicht-archiv', [auftrags_CONTROLLER::class, "getArchiveLeads"])->middleware(["auth"]);
Route::get('/crm/interessenten/sortieren-{field}-{type}', [auftrags_CONTROLLER::class, "interessentenSortieren"])->middleware(["auth"]);
Route::get('/crm/email-modal/{status}/{id}', [auftrags_CONTROLLER::class, "emailModalView"])->middleware(["auth"]);

Route::get('/crm/lagerbestandt', [packtisch_CONTROLLER::class, "lagerbestandtView"])->middleware(["auth"]);
Route::get('/crm/packtisch/tagesabschluss/bestellung-löschen-{id}', [packtisch_CONTROLLER::class, "tagesabschlussBestellungLöschen"])->middleware(["auth"]);
Route::get('/crm/packtisch', [packtisch_CONTROLLER::class, "packtischView"])->middleware(["auth"]);
Route::get('/crm/neuer/auftrag', [auftrags_CONTROLLER::class, "newOrderView"])->middleware(["auth"]);
Route::get('/crm/neuer/interessent', [auftrags_CONTROLLER::class, "newInteressentenView"])->middleware(["auth"]);
Route::get('/crm/auftrag/archiv', [auftrags_CONTROLLER::class, "orderArchivView"])->middleware(["auth"]);
Route::get('/crm/change/order_archive/{id}', [auftrags_CONTROLLER::class, "archiveOrderView"])->middleware(["auth"]);
Route::post('/crm/warenausgang/fotoauftrag/refresh/{id}', [packtisch_CONTROLLER::class, "refreshWarenausgangFotoauftrag"])->middleware(["auth"]);
Route::post('/crm/techniker/zusammenfassen', [packtisch_CONTROLLER::class, "technikerZusammenfassen"])->middleware(["auth"]);
Route::post('/crm/neuer-auftrag/nummersuche', [auftrags_CONTROLLER::class, "searchKBA"])->middleware(["auth"]);
Route::post('/crm/zuweisung/neuer-auftrag', [auftrags_CONTROLLER::class, "neuerAuftragUndGerät"])->middleware(["auth"]);

Route::get('/crm/interessenten/archiv', [auftrags_CONTROLLER::class, "interessentenArchivView"])->middleware(["auth"]);
Route::get('/crm/change/device/{id}', [auftrags_CONTROLLER::class, "changeDeviceData"])->middleware(["auth"]);
Route::get('/crm/globale-aufträge', [auftrags_CONTROLLER::class, "globaleAufträgeView"])->middleware(["auth"]);
Route::get('/crm/packtisch/lagerplatzübersicht', [packtisch_CONTROLLER::class, "lagerplatzÜbersicht"])->middleware(["auth"]);
Route::post('/crm/inventur/beauftragen', [packtisch_CONTROLLER::class, "inventurBeauftragen"])->middleware(["auth"]);
Route::post('/crm/set-quick-status', [auftrags_CONTROLLER::class, "setQuickStatus"])->middleware(["auth"]);
Route::post('/crm/entsorgung/beauftragen', [packtisch_CONTROLLER::class, "entsorgungBeauftragen"])->middleware(["auth"]);
Route::get('/crm/packtisch/entsorgungsauftrag', [packtisch_CONTROLLER::class, "entsorgungsauftragView"])->middleware(["auth"]);
Route::get('/crm/packtisch/warenausgang-bearbeiten-entsorgung', [packtisch_CONTROLLER::class, "getWarenausgangEntsorgungView"])->middleware(["auth"]);
Route::get('/crm/packtisch/frei-umlagern', [packtisch_CONTROLLER::class, "freiUmlagernView"])->middleware(["auth"]);
Route::get('/crm/packtisch/slider-trackinghistory/{id}', [packtisch_CONTROLLER::class, "getSliderTrackinghistory"])->middleware(["auth"]);
Route::get('/crm/packtisch/freies-umlagern', [packtisch_CONTROLLER::class, "getFreiUmlagernView"])->middleware(["auth"]);
Route::post('/crm/packtisch/freies-umlagern-save', [packtisch_CONTROLLER::class, "freiesUmlagernAbschliessen"])->middleware(["auth"]);
Route::post('crm/packtisch/warenausgang-versenden/{id}', [packtisch_CONTROLLER::class, "warenausgangKundeVersenden"])->middleware(["auth"]);
Route::post('crm/packtisch/neuer-kundenversand', [packtisch_CONTROLLER::class, "neuerKundenversandAnPacktisch"])->middleware(["auth"]);
Route::post('crm/packtisch/neuer-technikerversand', [packtisch_CONTROLLER::class, "neuerTechnikerversandAnPacktisch"])->middleware(["auth"]);
Route::post('crm/packtisch/warenausgang-versenden-entsorgung', [packtisch_CONTROLLER::class, "warenausgangEntsorgungVersenden"])->middleware(["auth"]);
Route::post('/crm/auftrag-aktiv/bearbeiten-{id}/kundendaten-bearbeiten', [auftrags_CONTROLLER::class, "kundendatenAuftragBearbeiten"])->middleware(["auth"]);
Route::post('/crm/auftrag-aktiv/bearbeiten-{id}/beipackzettel-bearbeiten', [auftrags_CONTROLLER::class, "kundendatenAuftragBeipackzettelBearbeiten"])->middleware(["auth"]);
Route::get('/crm/auftrag-aktiv/bearbeiten-{id}/get-devicedata', [auftrags_CONTROLLER::class, "getKundendatenAuftragGerätedaten"])->middleware(["auth"]);
Route::get('crm/new-order/new-devicedata', [auftrags_CONTROLLER::class, "getNewDeviceData"])->middleware(["auth"]);
Route::get('crm/ausgang/check-label-{id}', [packtisch_CONTROLLER::class, "checkLabel"])->middleware(["auth"]);
Route::get('crm/packtisch/warenausgang-verpacken/{id}', [packtisch_CONTROLLER::class, "warenausgangKundeVerpacken"])->middleware(["auth"]);
Route::get('crm/packtisch/warenausgang-bearbeiten-{id}', [packtisch_CONTROLLER::class, "getWarenausgangBearbeiten"])->middleware(["auth"]);
Route::post('crm/aktivitätsmonitor/filter', [Settings::class, "aktivitätenFiltern"])->middleware(["auth"]);
Route::get('crm/packtisch/siegel/check-{id}', [Settings::class, "checkSiegel"])->middleware(["auth"]);
Route::get('crm/get/stammdaten-{id}', [auftrags_CONTROLLER::class, "getStammdatenModal"])->middleware(["auth"]);
Route::get('/crm/auftrag/kundendaten-{id}', [auftrags_CONTROLLER::class, "getKundendaten"])->middleware(["auth"]);

Route::get('/crm/statuse', [Settings::class, "statusView"])->middleware(["auth"]);
Route::get('/crm/statuse/bearbeiten/{id}', [Settings::class, "statusBearbeiten"])->middleware(["auth"]);
Route::get('/crm/status/delete/{id}', [Settings::class, "statusLöschen"])->middleware(["auth"]);
Route::post('/crm/change/status/{id?}', [Settings::class, "statusBearbeitenPOST"])->middleware(["auth"]);
Route::get('/crm/status/neu', [Settings::class, "statusNeu"])->middleware(["auth"]);
Route::get('/get/time', [employee::class, "getTime"])->middleware(["auth"]);
Route::get('/crm/auftrag-gerät-toggle-primarydevice-{id}', [auftrags_CONTROLLER::class, "togglePrimaryDevice"])->middleware(["auth"]);
Route::get('/crm/auftrag-toggle-device-reklamation-{id}', [auftrags_CONTROLLER::class, "toggleReklamationDevice"])->middleware(["auth"]);
Route::post('/crm/auftragshistory/new/{id}', [auftrags_CONTROLLER::class, "neuerAuftraghistory"])->middleware(["auth"]);
Route::post('/crm/versand/packtisch', [packtisch_CONTROLLER::class, "toPacktischExternVersand"])->middleware(["auth"]);
Route::get('/crm/versand/auswahl-kunde/{id}/{selecteddevices?}/{contact?}', [auftrags_CONTROLLER::class, "externVersendenKundenauswahl"])->middleware(["auth"]);
Route::get('/crm/versand/select-device/{device}/{id}/{selecteddevices?}/{contact?}', [packtisch_CONTROLLER::class, "externVersandSelectDevice"])->middleware(["auth"]);
Route::get('/crm/versenden/contact/{contact}/{id?}/{selectedDevices?}', [packtisch_CONTROLLER::class, "getContactExternVersand"])->middleware(["auth"]);

Route::get('/crm/add-blacklist/{id}', [auftrags_CONTROLLER::class, "addToBlacklist"])->middleware(["auth"]);
Route::get('/crm/remove-blacklist/{id}', [auftrags_CONTROLLER::class, "removeFromBlacklist"])->middleware(["auth"]);
Route::get("rechnungs", [Settings::class, "getRechnung"])->middleware(["auth"]);
Route::get("angebot", [Settings::class, "getAngebot"])->middleware(["auth"]);
Route::get("mahnung", [Settings::class, "getMahnung"])->middleware(["auth"]);

Route::get('/versand-versenden/get-contact/{id}', [packtisch_CONTROLLER::class, "versandVersendenGetContact"]);
Route::get('/versand-versenden/get-devices/{id}', [packtisch_CONTROLLER::class, "versandVersendenGetDevices"]);
Route::get('/kunde/emailcheck/{id}/{uuid}', [Settings::class, "emailUUIDCheck"]);
Route::get('/crm/email-vorlagen', [Settings::class, "emailVorlagenView"])->middleware(["auth"]);
Route::get('/crm/emailsetting/{state?}/{id?}', [Settings::class, "emailBearbeiten"])->middleware(["auth"]);
Route::post('/crm/neuer/vergleichstext', [Settings::class, "neuerVergleichstext"])->middleware(["auth"]);
Route::post('/crm/textvorlage/neu', [Settings::class, "neueTextvorlage"])->middleware(["auth"]);
Route::post('/crm/zeiterfassung/profilbearbeiten', [employee::class, "zeiterfassungProfilBearbeiten"])->middleware(["auth"]);
Route::post('/crm/neuer/rechnungstext', [Settings::class, "neuerRechnungstext"])->middleware(["auth"]);
Route::post('/crm/neuer/mahnungstext', [Settings::class, "neuerMahnungstext"])->middleware(["auth"]);
Route::get('/crm/dateiverteilen', [Settings::class, "getDateiVerteilenView"])->middleware(["auth"]);
Route::get('/crm/mahnung/pdf-{stufe}/{id}', [rechnung::class, "getMahnungPdf"])->middleware(["auth"]);
Route::get('/crm/dateimanager', [Settings::class, "getDateimanager"])->middleware(["auth"]);
Route::post('/crm/dateimanager/upload', [Settings::class, "uploadDateimanagerFile"])->middleware(["auth"]);
Route::post('/crm/dateimanager/edit', [Settings::class, "changeDateimanagerFilename"])->middleware(["auth"]);
Route::post('/crm/change/mwst-setting', [Settings::class, "changeMwst"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-angebot-hochladen', [Settings::class, "uploadAngebotPDF"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-angebotmwst-hochladen', [Settings::class, "uploadAngebotMWSTPDF"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-rechnung-hochladen', [Settings::class, "uploadRechnungPDF"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-rechnungmwst-hochladen', [Settings::class, "uploadRechnungMWSTPDF"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-gutschrift-hochladen', [Settings::class, "uploadGutschriftPDF"])->middleware(["auth"]);
Route::post('/crm/buchhaltung-gutschriftmwst-hochladen', [Settings::class, "uploadGutschriftMWSTPDF"])->middleware(["auth"]);
Route::get('/crm/emailInbox/getAssignProxs/{account}', [Settings::class, "getAssignProxs"])->middleware(["auth"]);
Route::get('/crm/reklamation/archiv-toggle-{id}', [auftrags_CONTROLLER::class, "toggleReklamationArchiv"])->middleware(["auth"]);
Route::get('/crm/reklamationsübersicht-archiv', [auftrags_CONTROLLER::class, "getReklamationArchiv"])->middleware(["auth"]);
Route::get('crm/email/verschieben-{id}-{account}', [Settings::class, "emailVerschieben"])->middleware(["auth"]);
Route::get('crm/delete-account-{account}', [Settings::class, "deleteEmailAccount"])->middleware(["auth"]);
Route::get('crm/auftragsverlauf/hide-text-{account}', [auftrags_CONTROLLER::class, "hideTextAuftragsverlauf"])->middleware(["auth"]);

Route::post('/crm/dateiverteilen/upload', [Settings::class, "uploadDateiVerteilenDatei"])->middleware(["auth"]);
Route::post('/crm/orders-sort', [auftrags_CONTROLLER::class, "OrderViewSort"])->middleware(["auth"]);
Route::post('/crm/interessenten-sort', [auftrags_CONTROLLER::class, "InteressentenViewSort"])->middleware(["auth"]);
Route::get('/crm/verteilen/löschen/{id}', [Settings::class, "deleteDateiVerteilen"])->middleware(["auth"]);
Route::get('/crm/verteilen', [Settings::class, "dateiVerteilen"])->middleware(["auth"]);
Route::get('/email-inbox/refresh/{id}', [Settings::class, "refreshMailDatabase"])->middleware(["auth"]);
Route::get('testlol', [auftrags_CONTROLLER::class, "active_orders_viewa"])->middleware(["auth"]);
Route::get('/email-inbox/getEmails/{id}', [Settings::class, "getMailsDatabase"])->middleware(["auth"]);
Route::get('/email-inbox/getEmail/{account}/{id}', [Settings::class, "getMailDatabase"])->middleware(["auth"]);
Route::get('/email-inbox/get-orders', [Settings::class, "getMailOrders"])->middleware(["auth"]);
Route::get('/email-inbox/get-leads', [Settings::class, "getMailLeads"])->middleware(["auth"]);
Route::get('/email-inbox/get-order/{id}', [Settings::class, "getMailOrder"])->middleware(["auth"]);
Route::post('email-inbox/entwurf-speichern', [Settings::class, "postMailEntwurfSpeichern"])->middleware(["auth"]);
Route::post('email-inbox/email-answer', [Settings::class, "postMailAnswer"])->middleware(["auth"]);
Route::post('email-inbox/email-new', [Settings::class, "postMailNew"])->middleware(["auth"]);
Route::post('crm/save-statuscode', [Settings::class, "saveStatuscodeChange"])->middleware(["auth"]);
Route::get('crm/ups-statuscodes', [Settings::class, "getUPSStatuscodesView"])->middleware(["auth"]);
Route::get('crm/change-statuscode-{id}', [Settings::class, "getStatuscodesChange"])->middleware(["auth"]);
Route::post('crm/email/neuer-account', [Settings::class, "neuerEmailAccount"])->middleware(["auth"]);
Route::post('crm/buchhaltung/rechnung-email', [Buchhaltung_CONTROLLER::class, "sendRechnungEmail"])->middleware(["auth"]);

Route::post('/crm/neuer/phonetext', [Settings::class, "newPhoneText"])->middleware(["auth"]);
Route::post('/crm/emailsetting/change/{id?}', [Settings::class, "changeEmailTemplate"])->middleware(["auth"]);
Route::get('/crm/helpercode/zuteilen/{id}', [auftrags_CONTROLLER::class, "keinBarcodeZuteilen"])->middleware(["auth"]);
Route::post('/crm/hilfscode/zuweisen/{id}', [auftrags_CONTROLLER::class, "keinBarcodeKundeZuteilen"])->middleware(["auth"]);
Route::get('/crm/lagerbestandt/bestellen/{item}', [packtisch_CONTROLLER::class, "lagerbestandtBestellen"])->middleware(["auth"]);
Route::get('/crm/vergleichsetting/{state?}/{text?}/{id?}', [Settings::class, "vergleichsettingView"])->middleware(["auth"]);
Route::post('/crm/allow/barcode', [Settings::class, "allowBarcode"])->middleware(["auth"]);
Route::get('/crm/change/order/{id}/{gerät?}/{contact?}', [auftrags_CONTROLLER::class, "changeOrderView"])->middleware(["auth"]);
Route::get('/crm/change/interessent/{id}/{gerät?}/{contact?}', [auftrags_CONTROLLER::class, "changeInteressentView"])->middleware(["auth"]);
Route::get('/crm/new/device', [auftrags_CONTROLLER::class, "newDeviceView"])->middleware(["auth"]);
Route::get('/crm/add/component/refresh/{code}/{shelfe}', [packtisch_CONTROLLER::class, "newDeviceViewRefresh"])->middleware(["auth"]);
Route::get('/crm/add/fotoauftrag/refresh/{code}/{shelfe}', [packtisch_CONTROLLER::class, "fotoauftragRefresh"])->middleware(["auth"]);
Route::get('/testing', [packtisch_CONTROLLER::class, "pickupTest"])->middleware(["auth"]);
Route::get('/crm/sort/{area}/{type}/{direction}', [auftrags_CONTROLLER::class, "sortTable"])->middleware(["auth"]);
Route::get('/delete/email_template/{id}', [Settings::class, "deleteEmailTemplate"])->middleware(["auth"]);
Route::get('/crm/skip/tagesabschluss', [packtisch_CONTROLLER::class, "skipMaterialinventur"])->middleware(["auth"]);
Route::get('/crm/packtisch/tagesabschluss/bestellungen/{id}', [packtisch_CONTROLLER::class, "getMaterialinventurBestellung"])->middleware(["auth"]);
Route::get('/crm/zeiterfassung/drucken/{employee}/{month}/{year}', [employee::class, "zeiterfassungDrucken"])->middleware(["auth"]);
Route::get('/crm/zeiterfassungs/übersicht/{employee}', [employee::class, "zeiterfassungÜbersicht"])->middleware(["auth"]);
Route::post('/crm/zeiterfassung/newtime', [employee::class, "zeiterfassungNeueZeit"])->middleware(["auth"]);
Route::post('/crm/packtisch/inventar-neue-bestellung/{id}', [packtisch_CONTROLLER::class, "neueBestellungZuInventar"])->middleware(["auth"]);
Route::post('/crm/zeiterfassung/stoppen', [employee::class, "zeiterfassungStoppen"])->middleware(["auth"]);
Route::post('/crm/zeiterfassung/bearbeiten', [employee::class, "zeiterfassungBearbeiten"])->middleware(["auth"]);
Route::get('/crm/zeiterfassung/deleteindex/{id}', [employee::class, "zeiterfassungEintragLöschen"])->middleware(["auth"]);
Route::get('/crm/zeiterfassung/changedate/{employee}/{year}/{month}', [employee::class, "zeiterfassungDatum"])->middleware(["auth"]);
Route::get('/crm/orders/sort/{type}/{direc}', [auftrags_CONTROLLER::class, "sortOrders"])->middleware(["auth"]);
Route::post("/crm/zeiterfassung/start", [employee::class, "zeiterfassungStart"])->middleware(["auth"]);
Route::post("/crm/zeiterfassung/pause", [employee::class, "zeiterfassungPause"])->middleware(["auth"]);
Route::post("/crm/zeiterfassung/ready", [employee::class, "zeiterfassungWeiter"])->middleware(["auth"]);
Route::post("/crm/zeiterfassung/newstart", [employee::class, "zeiterfassungRestart"])->middleware(["auth"]);
Route::post("/crm/zeiterfassung/feierabend", [employee::class, "zeiterfassungFeierabend"])->middleware(["auth"]);

Route::get("/crm/contact/bearbeiten/{shortcut}", [Settings::class, "contactBearbeiten"])->middleware(["auth"]);
Route::post("/crm/contact/change/{shortcut}", [Settings::class, "contactChange"])->middleware(["auth"]);
Route::get("/testtest", [auftrags_CONTROLLER::class, "sendSmsNotificaition"])->middleware(["auth"]);
Route::get("/crm/packtisch/exist-order-documents/{id}/{device}", [packtisch_CONTROLLER::class, "checkExistOrderDocuments"])->middleware(["auth"]);

Route::get("testtracking", function(Request $req) {

    $data = array(
        "shipments" => array([
            "trackingId" => "EE10021942088880001030003D0N",
            "destinationCountry" => "Canada"
        ]),
        "language" => "en",
        "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJiNzUxZGZiMC0yZDk0LTExZWUtYjQ5OS05M2E3OWU0OTVjZjIiLCJzdWJJZCI6IjY0YzQzZWM0OWU0M2FjM2MxZWUwMmE4MSIsImlhdCI6MTY5MDU4MjcyNH0.ySYTqjMK2HJHAuQISVNXYqE53Oul3nxEINSWTrheJKM"
    );

    $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

    $ch = curl_init("https://parcelsapp.com/api/v3/shipments/tracking");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
    )
);
        $result = curl_exec($ch);
        dd($result);
		$response = json_decode($result);

});

Route::get("/crm/adressbuch/edit-{id}", [Settings::class, "getAdressbuchEditView"])->middleware(["auth"]);
Route::get("/crm/adressbuch/neu", [Settings::class, "getAdressbuchNeuView"])->middleware(["auth"]);
Route::get("/crm/adressbuch", [Settings::class, "adressbuchView"])->middleware(["auth"]);
Route::get("/crm/kontakt/neu", [Settings::class, "kontaktNeuView"])->middleware(["auth"]);
Route::get("/crm/lagerplatz/bearbeiten/no_shelfe/{id}", [packtisch_CONTROLLER::class, "lagerplatzBearbeiten_nichtImLager"])->middleware(["auth"]);
Route::post("/crm/packtisch/Einlagerungsauftrag/{id}", [packtisch_CONTROLLER::class, "einlagerungsAuftragView"])->middleware(["auth"]);
Route::post("/crm/packtisch/einlagerungsauftrag/einlagern/{id}/{shelfe}", [packtisch_CONTROLLER::class, "einlagerungsAuftragAbschließen"])->middleware(["auth"]);
Route::post("/crm/save/phone_historie/{id}", [auftrags_CONTROLLER::class, "saveToPhoneHistory"])->middleware(["auth"]);
Route::post("/crm/new/phonedate/{id}", [auftrags_CONTROLLER::class, "newPhoneDate"])->middleware(["auth"]);
Route::post("/crm/contact/new", [Settings::class, "newContact"])->middleware(["auth"]);

Route::post("/crm/to/packtisch/einlagerungsauftrag/{id}", [packtisch_CONTROLLER::class, "einlagerungsAuftrag"])->middleware(["auth"]);
Route::post("/crm/phonehistory/new/{id}", [auftrags_CONTROLLER::class, "neuePhonehistory"])->middleware(["auth"]);
Route::post("/crm/vollmacht", [packtisch_CONTROLLER::class, "getVollmachtBeauftragen"])->middleware(["auth"]);
Route::get("/crm/vollmacht/abschließen", [packtisch_CONTROLLER::class, "vollmachtAbschließen"])->middleware(["auth"]);

Route::get('/crm/verpacken/{id}', [packtisch_CONTROLLER::class, "warenausgangVerpackenKunde"])->middleware(["auth"]);
Route::get('/crm/auftrag-sperren', [auftrags_CONTROLLER::class, "auftragSperrenView"])->middleware(["auth"]);
Route::get('/crm/vollmacht', [auftrags_CONTROLLER::class, "vollmachtView"])->middleware(["auth"]);
Route::get('/crm/settings', [auftrags_CONTROLLER::class, "settingsView"])->middleware(["auth"]);
Route::get('/crm/auftrag-zu-archive/{id}', [auftrags_CONTROLLER::class, "moveToOrdersArchive"])->middleware(["auth"]);
Route::get('/crm/auftrag-zu-aktive/{id}', [auftrags_CONTROLLER::class, "moveToOrdersActive"])->middleware(["auth"]);
Route::get('/crm/intern/sperren/{id}', [auftrags_CONTROLLER::class, "internSperren"])->middleware(["auth"]);
Route::get('/crm/warenausgang/sperren/{id}/{date}', [auftrags_CONTROLLER::class, "warenausgangSperren"])->middleware(["auth"]);
Route::get('/crm/warenausgang/entsperren/{id}/{date}', [auftrags_CONTROLLER::class, "warenausgangEntsperren"])->middleware(["auth"]);
Route::get('/crm/intern/entsperren/{id}', [auftrags_CONTROLLER::class, "internEntsperren"])->middleware(["auth"]);
Route::get("/crm/zusammenfassen", [Settings::class, "zusammenfassenView"])->middleware(["auth"]);
Route::get("/error", [Settings::class, "error"])->middleware(["auth"]);
Route::get("/crm/sendungen", [Settings::class, "getSendungenView"])->middleware(["auth"]);
Route::get("/crm/sendung/anschauen/{id}", [Settings::class, "getSendungModalView"])->middleware(["auth"]);
Route::get("/crm/mailinbox/zum/archiv/{id}", [Settings::class, "setMailInboxArchive"])->middleware(["auth"]);
Route::get("/crm/mailinbox/zum/aktiv/{id}", [Settings::class, "setMailInboxAktive"])->middleware(["auth"]);
Route::get("/crm/shippinghistory/status/{id}/{label}", [packtisch_CONTROLLER::class, "getShippingHistoryTracking"])->middleware(["auth"]);
Route::get("/crm/abholung/redo/{id}", [packtisch_CONTROLLER::class, "redoAbholungView"])->middleware(["auth"]);
Route::get("/crm/refresh/shipping-status", [packtisch_CONTROLLER::class, "refreshShippingStatus"])->middleware(["auth"]);
Route::post("/crm/versand/druck", [packtisch_CONTROLLER::class, "instantVersand"])->middleware(["auth"]);
Route::get("/crm/rechnung/delete-pos/{id}", [rechnung::class, "deletePos"])->middleware(["auth"]);
Route::get("/crm/set-bezahlt-{id}", [rechnung::class, "setBezahlt"])->middleware(["auth"]);
Route::get("/crm/delete-zahlung-{id}", [Buchhaltung_CONTROLLER::class, "deleteZahlung"])->middleware(["auth"]);
Route::get("/crm/rechnung/get-audio-file/{id}", [rechnung::class, "getAudioFileData"])->middleware(["auth"]);
Route::post("/crm/rechnung/change-audiofile", [Buchhaltung_CONTROLLER::class, "newAudioFile"])->middleware(["auth"]);
Route::get("/crm/buchhaltung/get-rechnung-{id}", [Buchhaltung_CONTROLLER::class, "getRechnungModal"])->middleware(["auth"]);

Route::get("rechnung", function(Request $req){
    $kundenkonto = kundenkonto::where("kundenid", "4881")->with("rechnungen", "rechnungen.zahlungen", "rechnungen.mahnungen", "rechnungen.audiofiles")->first();

    $mahneinstellungen = mahneinstellungen::all();
    $rechnungstexte = rechnungstext::all();
    $firma       = maindata::where("id", "1")->first();
    $artikel     = artikel::all();
    $employees   = User::all();
    $person      = active_orders_person_data::where("process_id", "I7115")->first();
    $countries   = countrie::all();
    $statuses    = statuse::all();

    $orders = active_orders_person_data::all();
    $orders = archive_orders_person::all()->merge($orders);
    $orders = new_leads_person_data::all()->merge($orders);
    $orders = archive_lead_person_data::all()->merge($orders);

    return view("rechnungen.main")->with("statuses", $statuses)->with("orders", $orders)->with("rechnungstexte", $rechnungstexte)->with("countries", $countries)->with("person", $person)->with("kundenkonto", $kundenkonto)->with("mwst", $firma->mwst)->with("artikel", $artikel)->with("mahneinstellungen", $mahneinstellungen)->with("employees", $employees);
});
Route::post('/crm/neue-rechnung/{id}', [ControllersKundenkonto::class, "neueRechnung"]);
Route::post('/crm/workflow/neuer-punkt', [Settings::class, "neuerWorkflowPunkt"]);
Route::post('/crm/rechnung-zusammenfassen/{id}', [ControllersKundenkonto::class, "rechnungZusammenfassen"]);
Route::post('/crm/neuer-artikel', [rechnung::class, "neuerArtikel"]);
Route::post('/crm/bearbeiten-artikel', [rechnung::class, "bearbeitenArtikel"]);
Route::post('/crm/change-pos', [rechnung::class, "bearbeitenPos"]);
Route::post('/crm/change-rabattpos', [rechnung::class, "bearbeitenRabattPos"]);
Route::post('/crm/buchhaltung-neuer-artikel', [Settings::class, "saveNewArtikel"]);
Route::post('/crm/buchhaltung-bearbeiten-zahlziel', [Settings::class, "saveZahlziel"]);
Route::post('/crm/buchhaltung-bearbeiten-artikel-{id}', [Settings::class, "saveBearbeitenArtikel"]);
Route::post('/crm/gerät-neu-zuweisen', [packtisch_CONTROLLER::class, "gerätNeuZuweisen"]);
Route::post('/crm/workflow/neuer-workflow', [Settings::class, "neuerWorkflow"]);
Route::get('/crm/get-positions/{id}', [rechnung::class, "getPositions"]);
Route::get('/crm/workflow', [auftrags_CONTROLLER::class, "getWorkflowView"]);
Route::get('/crm/workflow/get-workflow-{id}', [Settings::class, "getWorkflow"]);
Route::get('/crm/workflow/get-infos-{id}', [Settings::class, "getWorkflowInfos"]);
Route::get('/crm/workflow-auftrag-{id}', [Settings::class, "getWorkflowAuftrag"]);
Route::get('crm/workflow/order/change-device/{id}/{type}', [Settings::class, "changeWorkflowDevice"]);
Route::get('crm/workflow/order/change-techniker/{id}/{tec}', [Settings::class, "changeWorkflowTechniker"]);
Route::get('/crm/workflow/order/pause-{id}', [auftrags_CONTROLLER::class, "pauseWorkflow"]);
Route::get('/crm/workflow/order/append-workflow/{id}/{workflow}', [auftrags_CONTROLLER::class, "appendWorkflow"]);
Route::get('/crm/workflow/order/change-{id}-{workflow}', [auftrags_CONTROLLER::class, "changeWorkflow"]);
Route::get('crm/workflow/order/delete-workflow-{id}', [auftrags_CONTROLLER::class, "deleteAllWorkflow"]);
Route::get('/crm/workflow/order/delete-{id}', [auftrags_CONTROLLER::class, "deleteWorkflow"]);
Route::post('/crm/workflow/order/edit-{id}', [auftrags_CONTROLLER::class, "editWorkflowPoint"]);
Route::post('crm/workflow/order/neuer-punkt', [auftrags_CONTROLLER::class, "workflowNeuerPunkt"]);
Route::get('/crm/workflow/delete-point-{id}', [Settings::class, "deleteWorkflowPoint"]);
Route::get('/crm/workflow/delete-workflow-{id}', [Settings::class, "deleteWorkflow"]);
Route::post('/crm/workflow/edit-workflow-{id}', [Settings::class, "editWorkflowPoint"]);
Route::get("hilfsbarcode-documents-{id}",[Settings::class, "getHelpercodePDF"])->middleware(["auth"]);
Route::get("crm/scanhistory/new/{scan}/{type}/{bereich}",[auftrags_CONTROLLER::class, "newScanHistory"])->middleware(["auth"]);
Route::get("/crm/gerätezuweisung-ändern-{id}",[Settings::class, "getGerätezuweisungView"])->middleware(["auth"]);
Route::get('/crm/buchhaltung-einstellungen', [Settings::class, "getBuchhaltungEinstellungenView"]);
Route::get('/crm/buchhaltung-zahlungsziel-bearbeiten', [Settings::class, "getZahlungszielBearbeiten"]);
Route::get('crm/buchhaltung-artikel-bearbeiten-{id}', [Settings::class, "getBuchhaltungEinstellungenArtikelBearbeiten"]);
Route::post("/crm/neue-zahlung", [rechnung::class, "neueZahlung"]);
Route::post("/crm/auftrag/set-multi-status", [auftrags_CONTROLLER::class, "setMultiStatusOrder"]);
Route::post("/crm/auftrag/set-bottom", [auftrags_CONTROLLER::class, "setBottomStatus"]);
Route::post("crm/auftrag/upload-dokumente", [auftrags_CONTROLLER::class, "uploadAuftragDokumente"]);
Route::get('crm/get-dokument-{id}', [auftrags_CONTROLLER::class, "getDokumenteInspect"]);
Route::post("/crm/interessenten/set-multi-status", [auftrags_CONTROLLER::class, "setMultiStatusInteressenten"]);
Route::post('/crm/zahlung-bearbeiten', [rechnung::class, "zahlungBearbeiten"]);
Route::get('/crm/delete-rechnung/{id}', [rechnung::class, "löschenRechnung"]);
Route::get('/crm/mahneinstellungen', [Settings::class, "getMahneinstellungenView"]);
Route::post("/crm/mahneinstellungen-neu", [Settings::class, "neueMahneinstellung"]);
Route::post("/crm/neue-rabattposition", [rechnung::class, "neueRabattPosition"]);
Route::get('/crm/mahnlaufstarten/{id}', [rechnung::class, "mahnlaufStarten"]);
Route::get('/crm/skip-mahnlevel/{id}', [rechnung::class, "nextMahnLevel"]);
Route::get('/crm/start-mahnsperre/{id}', [rechnung::class, "startMahnsperre"]);
Route::get('/crm/stop-mahnsperre/{id}', [rechnung::class, "stopMahnsperre"]);
Route::get('/crm/siegel', [Settings::class, "getSiegelView"]);
Route::get('/crm/siegel/löschen-{id}', [Settings::class, "deleteSiegel"]);
Route::post('/crm/siegel/hochladen', [Settings::class, "uploadSiegel"]);
Route::post('/email-inbox/entwurf-speichern-neueemail', [Settings::class, "saveNeueEmailEntwurf"]);
Route::post('/crm/packtisch/neuer-abholauftrag', [packtisch_CONTROLLER::class, "neuerAbholauftrag"]);
Route::post('/crm/packtisch/neuer-fotoauftrag', [packtisch_CONTROLLER::class, "neuerFotoauftrag"]);
Route::post('/crm/packtisch/neuer-umlagerungsauftrag', [packtisch_CONTROLLER::class, "neuerUmlagerungsauftrag"]);
Route::post('/crm/packtisch/neuer-hinweis', [packtisch_CONTROLLER::class, "neuerHinweis"]);
Route::post('/crm/packtisch/neuer-nachforschungsauftrag', [packtisch_CONTROLLER::class, "neuerNachforschungsauftrag"])->middleware(["auth"]);
Route::post('/crm/packtisch/neuer-entsorgungsauftrag', [packtisch_CONTROLLER::class, "neuerEntsorgungsauftrag"])->middleware(["auth"]);
Route::get('/crm/rechnung-pdf/{id}', [rechnung::class, "getPdfRechnung"]);
Route::get('crm/auftrag/bearbeiten-{id}', [auftrags_CONTROLLER::class, "getChangeActiveOrderView"]);
Route::get('crm/auftrag/buchhaltung-view-{id}', [auftrags_CONTROLLER::class, "getAuftragBuchhaltungView"]);
Route::get("crm/buchhaltung/rechnung-kopieren-{id}", [\App\Http\Controllers\kundenkonto::class, "copyRechnung"]);
Route::get('crm/auftrag/auftragsverlauf-view-{id}', [auftrags_CONTROLLER::class, "getAuftragsverlaufView"]);
Route::get('crm/auftrag/devicelist-view-{id}', [auftrags_CONTROLLER::class, "getGerätedatenView"]);
Route::get('crm/auftrag/hinweis-view-{id}', [auftrags_CONTROLLER::class, "getHinweisView"]);
Route::get('crm/verlauf/get-{id}', [auftrags_CONTROLLER::class, "getAuftragsverlauf"]);
Route::post('/crm/packtisch/versand-checkaddress', [packtisch_CONTROLLER::class, "checkAddress"])->middleware(["auth"]);
Route::get('crm/unverifizierte-kundenliste', [packtisch_CONTROLLER::class, "getUnverifizierteKundenliste"]);
Route::get('crm/überwachungssystem', [Settings::class, "getÜberwachungsSystem"]);
Route::get('awdawd-{id}-{process_id}', [auftrags_CONTROLLER::class, "setNewTrackingnumber"]);
Route::post('/crm/order/change-device-data', [auftrags_CONTROLLER::class, "changeDeviceDataOrder"])->middleware(["auth"]);
Route::post('/crm/orders/neuer-status', [auftrags_CONTROLLER::class, "setNewOrderStatus"])->middleware(["auth"]);
Route::post('crm/kundenversand-ändern-{id}', [packtisch_CONTROLLER::class, "changeKundenversandData"])->middleware(["auth"]);
Route::get('crm/packtisch/warenausgang-löschen-{id}', [packtisch_CONTROLLER::class, "deleteWarenausgang"]);
Route::get('crm/packtisch/intern-bearbeiten-{id}', [packtisch_CONTROLLER::class, "bearbeitenInternView"]);
Route::post('crm/packtisch/intern-ändern-{id}', [packtisch_CONTROLLER::class, "bearbeitenIntern"]);
Route::get('crm/packtisch/intern-löschen-{id}', [packtisch_CONTROLLER::class, "deleteIntern"]);
Route::get('crm/auftragsübersicht-aktiv/get-orders-{id}', [auftrags_CONTROLLER::class, "getOrdersOptimized"]);
Route::get('crm/interessenten/get-verlauf-telefon-{id}', [auftrags_CONTROLLER::class, "getAuftragsverlaufUpdate"]);
Route::get('crm/interessenten/get-verlauf-dokumente-{id}', [auftrags_CONTROLLER::class, "getDokumenteUpdate"]);
Route::get('crm/interessenten/get-verlauf-statuse-{id}', [auftrags_CONTROLLER::class, "getStatuseUpdate"]);
Route::get('crm/interessenten/get-verlauf-all-{id}', [auftrags_CONTROLLER::class, "getAllUpdate"]);
Route::get('crm/interessenten/get-verlauf-auftrag-{id}', [auftrags_CONTROLLER::class, "getAuftragUpdate"]);
Route::get('crm/auftrag/status/filter/{id}-{process_id}', [auftrags_CONTROLLER::class, "getStatusFilter"]);
Route::get('crm/auftrag/auftrag/filter/{id}-{process_id}/{type}', [auftrags_CONTROLLER::class, "getAuftragFilter"]);
Route::get('crm/packtisch/get-techniker-info/{id}', [auftrags_CONTROLLER::class, "getTechnikerInfo"]);
Route::get('crm/check/secret-{password}', [auftrags_CONTROLLER::class, "checkSecret"]);
Route::get('/crm/buchhaltung/neue-rechnung-{id}', [auftrags_CONTROLLER::class, "getBuchhaltungNeueRechnung"]);
Route::post('crm/buchhaltung/rechnung/neue-position/{id}', [Buchhaltung_CONTROLLER::class, "neueRechnungsposition"]);
Route::get('/crm/buchhaltung/rechnung/mwst-off/{id}', [Buchhaltung_CONTROLLER::class, "getRechnungenMwStOff"]);
Route::get('/crm/buchhaltung/rechnung/mwst-on/{id}', [Buchhaltung_CONTROLLER::class, "getRechnungenMwStOn"]);
Route::get('/crm/buchhaltung/position-delete/{id}/{type}', [Buchhaltung_CONTROLLER::class, "deletePosition"]);
Route::post('crm/buchhaltung/neue-rechnung', [Buchhaltung_CONTROLLER::class, "neueRechnung"]);
Route::post('crm/buchhaltung/edit-rechnung', [Buchhaltung_CONTROLLER::class, "editRechnung"]);
Route::get('crm/buchhaltung/rechnung/audio/{id}', [Buchhaltung_CONTROLLER::class, "getNeueAudiofile"]);
Route::get('crm/buchhaltung/rechnung-delete-{id}', [Buchhaltung_CONTROLLER::class, "deleteRechnung"]);
Route::get('/crm/buchhaltung/get-email-{id}', [Buchhaltung_CONTROLLER::class, "getEmailModal"]);
Route::get('crm/buchhaltung/get-zahlungen-{id}', [Buchhaltung_CONTROLLER::class, "getZahlungenModal"]);
Route::get('crm/buchhaltung/get-rechnungen-{id}', [Buchhaltung_CONTROLLER::class, "getAllRechnungen"]);

Route::get('/crm/get-artikel', [Settings::class, "getArtikelList"])->middleware(["auth"]);
Route::get('/crm/packtisch/kein-barcode', [packtisch_CONTROLLER::class, "keinBarcodeView"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/techniker/{tec}', [packtisch_CONTROLLER::class, "technikerAusgangView"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/kunde/{id}', [packtisch_CONTROLLER::class, "kundenAusgangView"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/extern', [packtisch_CONTROLLER::class, "externAusgangView"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/entsorgung', [packtisch_CONTROLLER::class, "entsorgungAusgangView"])->middleware(["auth"]);
Route::get('/crm/packtisch/historie', [packtisch_CONTROLLER::class, "packtischHistorie"])->middleware(["auth"]);
Route::get('/crm/packtisch/allhistory-tracking/{id}', [packtisch_CONTROLLER::class, "packtischHistorieAllTracking"])->middleware(["auth"]);
Route::get('/crm/set/primarydevice/{id}', [auftrags_CONTROLLER::class, "setPrimaryDevice"])->middleware(["auth"]);
Route::get('/crm/packtisch/warenausgang-entsperren', [packtisch_CONTROLLER::class, "warenausgangEntsperren"])->middleware(["auth"]);
Route::get('/crm/packtisch/warenausgang-sperren', [packtisch_CONTROLLER::class, "warenausgangSperren"])->middleware(["auth"]);
Route::get('/crm/email-vorlage/pdf-entfernen/{id}', [Settings::class, "deleteEmailVorlagenPDF"])->middleware(["auth"]);
Route::get('/crm/aktivitätsmonitor', [Settings::class, "getActivityMonitor"])->middleware(["auth"]);
Route::get('/crm/order/versand-info-{id}', [packtisch_CONTROLLER::class, "getVersandInfosModal"])->middleware(["auth"]);
Route::get('crm/aktivitäten-seite-{id}', [Settings::class, "getAktivitätenSeite"])->middleware(["auth"]);
Route::view('cookie', "consent.banner")->middleware(["auth"]);
Route::get('crm/packtisch/get/sliderhistory', [auftrags_CONTROLLER::class, "getSliderHistory"])->middleware(["auth"]);
Route::get('crm/packtisch/get/wareneingang-bearbeiten-{id}', [packtisch_CONTROLLER::class, "getWareningangBearbeiten"])->middleware(["auth"]);
Route::get('crm/packtisch/wareneingang-zurück-{id}', [packtisch_CONTROLLER::class, "deleteWareneingang"])->middleware(["auth"]);
Route::get('crm/packtisch/materialinventur/bild-löschen-{id}', [packtisch_CONTROLLER::class, "deleteTagesabschlussBild"])->middleware(["auth"]);
Route::get('crm/packtisch/historie/eingang-site-{id}', [packtisch_CONTROLLER::class, "historieEingangSeite"])->middleware(["auth"]);
Route::get('crm/packtisch/historie/intern-site-{id}', [packtisch_CONTROLLER::class, "historieInternSeite"])->middleware(["auth"]);
Route::get('/crm/siegel/edit-setting-{id}', [Settings::class, "setSealSettings"])->middleware(["auth"]);

Route::get("employee/login", function() {
    return view("forEmployees/administration/login");
});

Route::post('crm/packtisch/intern/einlagerungsauftrag-durchführen-{id}', [packtisch_CONTROLLER::class, "einlagerungsauftragAbschließen"])->middleware(["auth"]);
Route::view('/frontend', "steubel.index");
Route::get('/crm/get-orders-like-{input}', [auftrags_CONTROLLER::class, "getOrdersLike"])->middleware(["auth"]);
Route::get('crm/auftragsübersicht-aktiv/filter-{id}', [auftrags_CONTROLLER::class, "getOrderViewFilter"])->middleware(["auth"]);
Route::get('crm/interessentenübersicht-aktiv/filter-{id}', [auftrags_CONTROLLER::class, "getLeadsViewFilter"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/extern', [packtisch_CONTROLLER::class, "externAusgangView"])->middleware(["auth"]);
Route::get('/crm/packtisch/kein-barcode', [packtisch_CONTROLLER::class, "getKeinBarcodeView"])->middleware(["auth"]);
Route::post('crm/packtisch/beschriftungsauftrag-abschließen/{id}', [packtisch_CONTROLLER::class, "internBeschriftungsauftragAbschließen"])->middleware(["auth"]);
Route::post('api/post/neuer-auftrag', [auftrags_CONTROLLER::class, "neuerInteressentExtern"])->middleware(["auth"]);
Route::get('api/get/components', [Settings::class, "APIGetComponents"])->middleware(["auth"]);
Route::post('crm/packtisch/problem-melden/{id}/{device}', [packtisch_CONTROLLER::class, "packtischProblemMelden"])->middleware(["auth"]);
Route::post('crm/packtisch/fotoauftrag-abschließen/{id}', [packtisch_CONTROLLER::class, "internFotoauftragAbschließen"])->middleware(["auth"]);
Route::post('crm/packtisch/unbekanntes-gerät-einlagern/{id}', [packtisch_CONTROLLER::class, "unbekanntesGerätEinlagern"])->middleware(["auth"]);
Route::get('/crm/packtisch/get-order-documents/{device}', [packtisch_CONTROLLER::class, "getOrderDocuments"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-beschriftungsauftrag/{id}', [packtisch_CONTROLLER::class, "getInternBeschriftungsauftragView"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-fotoauftrag/{id}', [packtisch_CONTROLLER::class, "getInternFotoauftragView"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-umlagerungsauftrag/{id}', [packtisch_CONTROLLER::class, "getInternUmlagerungsauftragView"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-abholauftrag/{id}', [packtisch_CONTROLLER::class, "getInternAbholauftragView"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-einlagerungsauftrag/{id}', [packtisch_CONTROLLER::class, "getInternEinlagerungsauftrag"])->middleware(["auth"]);
Route::get('crm/packtisch/abholauftrag-get-document/{id}', [packtisch_CONTROLLER::class, "getAbholauftragDocument"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-nachforschungsauftrag/{id}', [packtisch_CONTROLLER::class, "getInternNachforschungsauftragView"])->middleware(["auth"]);
Route::get('crm/packtisch/intern-bearbeiten-inventur/{id}', [packtisch_CONTROLLER::class, "getInternInventurauftragView"])->middleware(["auth"]);
Route::post('crm/packtisch/abholung-abschließen/{id}', [packtisch_CONTROLLER::class, "finishAbholauftrag"])->middleware(["auth"]);
Route::post('crm/packtisch/nachforschungsauftrag-abschließen/{id}', [packtisch_CONTROLLER::class, "finishNachforschungsauftrag"])->middleware(["auth"]);
Route::post('/crm/packtisch/gerät-umlagern/{device}', [packtisch_CONTROLLER::class, "saveUmlagerungGerät"])->middleware(["auth"]);
Route::get('/crm/packtisch/get-device-documents/{device}', [packtisch_CONTROLLER::class, "getDeviceDocuments"])->middleware(["auth"]);
Route::get('crm/inventar/löschen-{id}', [Settings::class, "deleteInventarProd"])->middleware(["auth"]);
Route::post('/crm/packtisch/neues-gerät-einlagern/{process_id}', [packtisch_CONTROLLER::class, "new_device"])->middleware(["auth"]);
Route::get('/crm/packtisch/check-order-documents/{id}', [packtisch_CONTROLLER::class, "checkOrderDocuments"])->middleware(["auth"]);
Route::get('/crm/rechnung-get-rechnungsnummer-{id}', [Settings::class, "getRechnungsnummern"])->middleware(["auth"]);
Route::get('/crm/packtisch/check-device-documents/{id}', [packtisch_CONTROLLER::class, "checkDeviceDocuments"])->middleware(["auth"]);
Route::get('/packtisch/ausgang/entsorgung', [packtisch_CONTROLLER::class, "entsorgungAusgangView"])->middleware(["auth"]);
Route::get('/crm/packtisch/historie', [packtisch_CONTROLLER::class, "packtischHistorie"])->middleware(["auth"]);
Route::get('/crm/wareneingang-zuweisen-{id}', [packtisch_CONTROLLER::class, "getWareneingangZuweisenView"])->middleware(["auth"]);
Route::get('/crm/wareneingang-archiv-zuweisen-{id}', [packtisch_CONTROLLER::class, "getWareneingangArchivZuweisenView"])->middleware(["auth"]);
Route::get('/crm/zuweisen/neuer-auftrag', [packtisch_CONTROLLER::class, "getZuweisenNeuerAuftrag"])->middleware(["auth"]);
Route::get('crm/generateHelpercodeORG-{process_id}-{barcode}', [packtisch_CONTROLLER::class, "generateHelpercodeORG"])->middleware(["auth"]);
Route::get('crm/generateHelpercodeATwithORG-{id}', [packtisch_CONTROLLER::class, "generateHelpercodeATwithORG"])->middleware(["auth"]);
Route::get('crm/generateATbyORG-{id}', [packtisch_CONTROLLER::class, "generateATbyORG"])->middleware(["auth"]);
Route::post('crm/set-helpercode', [packtisch_CONTROLLER::class, "setHelpercode"])->middleware(["auth"]);
Route::get('/crm/get-devices-{id}', [packtisch_CONTROLLER::class, "getAllORGDevices"])->middleware(["auth"]);
Route::get('/get-emailvorlagen', [Settings::class, "getEmailVorlagen"])->middleware(["auth"]);
Route::get('/get-emailvorlage-{id}', [Settings::class, "getEmailVorlage"])->middleware(["auth"]);
Route::get('/crm/packtisch/tagesabschluss', [packtisch_CONTROLLER::class, "getMaterialinventurView"])->middleware(["auth"]);
Route::get('crm/statuscode-select-edit-{id}', [Settings::class, "editStatuscodeSelect"])->middleware(["auth"]);
Route::get('/crm/set/primarydevice/{id}', [auftrags_CONTROLLER::class, "setPrimaryDevice"])->middleware(["auth"]);
Route::get('/crm/packtisch/tagesabschluss/produkt-bearbeiten/{id}', [packtisch_CONTROLLER::class, "getProduktBearbeitenInventar"])->middleware(["auth"]);
Route::get('/crm/packtisch/delete-device-documents/{id}', [packtisch_CONTROLLER::class, "deleteDeviceDocuments"])->middleware(["auth"]);
Route::get('/crm/packtisch/delete-order-documents/{id}', [packtisch_CONTROLLER::class, "deleteOrderDocuments"])->middleware(["auth"]);
Route::get('/crm/rollen', [Settings::class, "getRollenView"])->middleware(["auth"]);
Route::get('/crm/rechnung-get-kundenkonto-{id}', [Settings::class, "getKundenkontoCollection"])->middleware(["auth"]);
Route::get('kein-zugang', [Settings::class, "getKeinZugangView"])->middleware(["auth"]);
Route::get('/crm/rolle-löschen-{id}', [Settings::class, "deleteRolle"])->middleware(["auth"]);
Route::get('/crm/benutzer', [Settings::class, "getBenutzerView"])->middleware(["auth"]);
Route::get('/crm/benutzer-löschen-{id}', [Settings::class, "deleteBenutzer"])->middleware(["auth"]);
Route::get('/crm/delete-permission-{id}', [Settings::class, "deleteCustomPermission"])->middleware(["auth"]);
Route::get('/crm/benutzer-bearbeiten-{id}', [Settings::class, "getBenutzerBearbeitenView"])->middleware(["auth"]);
Route::post('/crm/changerole-permission-{id}', [Settings::class, "saveRollenPermissions"])->middleware(["auth"]);
Route::post('/crm/benutzer-speichern-{id}', [Settings::class, "saveBenutzerÄnderungen"])->middleware(["auth"]);
Route::post('/crm/benutzer-neu-speichern', [Settings::class, "saveNeuenBenutzer"])->middleware(["auth"]);
Route::post('/crm/neue-rolle-erstellen', [Settings::class, "createNewRole"])->middleware(["auth"]);
Route::post('/crm/neue-permission-erstellen', [Settings::class, "createNewPermission"])->middleware(["auth"]);
Route::post('save-pdf', [Settings::class, "changePDF"])->middleware(["auth"]);
Route::post('crm/packtisch/new-component', [packtisch_CONTROLLER::class, "getNewComponentView"])->middleware(["auth"]);
Route::post('crm/packtisch/neues-inventar/{id?}', [packtisch_CONTROLLER::class, "saveNeuesInventarItem"])->middleware(["auth"]);
Route::post('crm/packtisch/tagesabschluss-absenden', [packtisch_CONTROLLER::class, "saveMaterialinventur"])->middleware(["auth"]);
Route::get('/crm/kundendaten-kunde-sperren-{id}', [Settings::class, "toggleKundenSperre"])->middleware(["auth"]);
Route::get('/crm/status/check-reklamation-{id}-{process_id}', [auftrags_CONTROLLER::class, "checkReklamationStatus"])->middleware(["auth"]);
Route::post('crm/status/set-reklamation-devices', [auftrags_CONTROLLER::class, "setReklamationSelectDevices"])->middleware(["auth"]);
Route::post('crm/status/reklamation-one-device', [auftrags_CONTROLLER::class, "setReklamationSelectOneDevice"])->middleware(["auth"]);
Route::get('crm/wareneingang/hilfsbarcode-rückgängig-{id}', [auftrags_CONTROLLER::class, "deleteWareneingangHilfsbarcode"])->middleware(["auth"]);
Route::get('crm/zeiterfassung-div-{id}', [auftrags_CONTROLLER::class, "getZeitefassungDropdown"])->middleware(["auth"]);
Route::get('crm/zeiterfassung-starten', [auftrags_CONTROLLER::class, "startZeiterfassungAuto"])->middleware(["auth"]);
Route::get('crm/zeiterfassung-stoppen-{id}', [auftrags_CONTROLLER::class, "stopZeiterfassungAuto"])->middleware(["auth"]);
Route::get('crm/zeiterfassung/feiertage', [auftrags_CONTROLLER::class, "getFeiertage"])->middleware(["auth"]);
Route::get('crm/zeiterfassung/delete-feiertag-{id}', [auftrags_CONTROLLER::class, "deleteFeiertag"])->middleware(["auth"]);
Route::get('crm/packtisch/sildeover/all-files-{id}', [packtisch_CONTROLLER::class, "sildeoverGetAllFiles"])->middleware(["auth"]);
Route::post('crm/packtisch/muttergerät-auswählen-einlagern', [packtisch_CONTROLLER::class, "newComponentMuttergerätView"])->middleware(["auth"]);
Route::post('crm/packtisch/historie/filter/eingang', [packtisch_CONTROLLER::class, "packtischHistorieFilterWareneingang"])->middleware(["auth"]);
Route::post('crm/packtisch/historie/filter/intern', [packtisch_CONTROLLER::class, "packtischHistorieFilterIntern"])->middleware(["auth"]);
Route::post('crm/packtisch/historie/filter/ausgang', [packtisch_CONTROLLER::class, "packtischHistorieFilterWarenausgang"])->middleware(["auth"]);

Route::get("employee/login", function() {
    return view("forEmployees/administration/login");
});

Route::get("employee/login", function() {
    return view("forEmployees/administration/login");
});


Route::get("pdfloader", function(Request $req) {

    return view("pdfLoader.main");
    dd($req->cookies->parameters->remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d);
});

